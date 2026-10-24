# Telas especiais e layout base

## Layout base

Feito uma vez, na Fase 0 (ver SKILL.md). Arquivos: `Element/head.ctp`, `Layout/default.ctp`,
`Element/footer.ctp`, `Element/modal.ctp`, `Element/Flash/*.ctp`, `Element/msg-alert.ctp`,
`Element/paginator-footer.ctp`, `Element/menus/*.ctp`.

### head.ctp

```php
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#ffffff">
<?= $this->Html->meta('favicon.ico', 'img/favicon.png', ['type' => 'icon']) ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">

<?= $this->Html->css([
        'bootstrap.min',
        'bootstrap-datepicker3.min',
        'dashboard2.css',          // legado
        'reiniciando.css',         // legado
        'jquery.dataTables.min',
        'dataTables.bootstrap.min',
        'font-awesome.min',
        'ss-theme.css?v=1',        // SEMPRE por último; suba o ?v= a cada alteração
    ]) ?>

<title><?= h($title) ?> · Sales-System</title>
```

Remova o bloco de `html5shiv`/`respond.js` (IE8).

### Layout/default.ctp

Estrutura (mantém a lógica atual de avisos, contagem da sessão, menus por perfil e "Ver como"):

```php
<!DOCTYPE html>
<html lang="pt-BR">
<head><?= $this->element('head') ?></head>
<body>
    <div class="bg_ajax hide" role="status" aria-live="polite">
        <i class="fa fa-spinner fa-pulse fa-fw" aria-hidden="true"></i><span><?= __('Carregando') ?></span>
    </div>

    <header class="ss-topbar">
        <div class="ss-container ss-topbar-inner">
            <button type="button" class="ss-icon-btn ss-nav-toggle navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#menu-reiniciando" aria-controls="menu-reiniciando" aria-expanded="false" aria-label="<?= __('Abrir menu') ?>">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>

            <?= $this->Html->link($this->Html->image('logomarca.png', ['alt' => 'Sales-System', 'id' => 'logo',
                    'data-url' => $this->Url->build('/', true)]),
                    ['controller' => 'Pages', 'action' => 'home'], ['class' => 'ss-logo', 'escape' => false]) ?>

            <div class="ss-topbar-actions">
                <a href="<?= $link_avisos ?>" class="ss-icon-btn btn_modal <?= $count_avisos > 0 ? 'has-alert' : '' ?>"
                   data-title="<?= __('Avisos') ?>" data-loading-text="…"
                   title="<?= __('Avisos') ?>" aria-label="<?= __('{0} avisos', $count_avisos) ?>">
                    <i class="fa fa-bell-o" aria-hidden="true"></i>
                    <?php if ($count_avisos > 0): ?><span class="ss-count ss-count--alert"><?= $count_avisos ?></span><?php endif; ?>
                </a>

                <div class="dropdown">
                    <a href="#" class="ss-user dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $this->Html->image($foto_usuario, ['class' => 'ss-avatar', 'alt' => '']) ?>
                        <span class="ss-user-text">
                            <span class="ss-user-name"><?= h($username) ?></span>
                            <span class="ss-user-plan"><span class="ss-plan ss-plan--<?= (int)$id_planos_usuario ?>"><?= h($planos_usuario) ?></span></span>
                        </span>
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="ss-dropdown-info"><?= __('Sessão expira em') ?> <strong id="countdown"></strong></li>
                        <li role="separator" class="divider"></li>
                        <li>…Meus dados (fa-user)…</li>
                        <li>…Alterar minha senha (fa-lock)…</li>
                        <li>…Dados bancários (fa-university)…</li>
                        <li role="separator" class="divider"></li>
                        <li>…Sair (fa-sign-out)…</li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <?php /* o <script> do contador continua igual, logo após o header */ ?>

    <nav class="navbar ss-navbar" aria-label="<?= __('Menu principal') ?>">
        <div class="ss-container">
            <div class="collapse navbar-collapse" id="menu-reiniciando">
                <ul class="nav navbar-nav">
                    <?php /* element('menus/<perfil>') como hoje */ ?>
                </ul>
                <?php /* seletor "Ver como" (.tipo-acesso) como hoje, com navbar-right */ ?>
            </div>
        </div>
    </nav>

    <main id="conteudo">
        <?php if ($alerta = $this->Flash->render()): ?>
            <div class="ss-container"><div class="ss-flash"><?= $alerta ?></div></div>
        <?php endif; ?>
        <?= $this->fetch('content') ?>
    </main>

    <?= $this->element('modal') ?>
    <footer class="ss-footer"><?= $this->element('footer') ?></footer>
</body>
</html>
```

- Sem `<br>`, `top-*`, `clearfix` e `pull-right` para montar o cabeçalho: o flex do tema cuida.
- O sino aparece uma vez só (o duplicado "versão móvel" sai).
- O menu abre pelo botão `ss-nav-toggle` no topo, no celular.
- Os templates de conteúdo abrem com `<div class="ss-container ss-page">`; o layout não impõe
  container no `<main>` porque relatórios e o login têm larguras próprias.

### footer.ctp

```php
<div class="ss-container ss-spread">
    <span>© <?= date('Y') ?> Sales-System</span>
</div>
<!-- scripts (jQuery, máscaras, Bootstrap, reiniciando.js...) continuam aqui, na mesma ordem -->
```

O selo fixo no canto (`pull-bottom-developed`) deixa de ser fixo: ele cobria conteúdo no celular.

## Dashboard (`Pages/home.ctp`)

Ordem:
1. Faixa `ss-banner` se o cadastro estiver pendente ("Aguardando confirmação de pagamento").
2. Saudação curta: `ss-page-title` "Olá, {primeiro nome}" + subtítulo com o plano.
3. **Métricas** (`ss-grid-stats`): gestão (Dev/Admin) vê os 4 indicadores atuais; associados
   veem saldo disponível, a receber, pedidos em andamento e indicados diretos, conforme os dados
   existentes.
4. **Acesso rápido** (`ss-card` + `ss-grid-auto` de `ss-shortcut`), sem as cores
   vermelho/verde/azul por item: todos na primária, ou um tom por grupo.
5. Coluna lateral para associados (`ss-split`): avisos recentes (`ss-messages`, até 3) e
   resumo da rede.

O título "Acesso rápido" vira `ss-card-title`; o `panel-titulo` antigo sai.

Como ficou (2026-10-24):
- Associado (SM, Master, VIP): ação primária "Solicitar saque" no cabeçalho (some com cadastro
  pendente); 2 métricas (Disponível, Bloqueado), como em Meu extrato; `ss-split` com Acesso
  rápido e "Minhas metas" (`ss-goals`, ver [componentes.md › Metas](componentes.md#metas-progresso)).
- Cliente: sem métricas nem metas; só Acesso rápido.
- Gestão: 4 métricas, Acesso rápido e Relatórios (atalhos que abrem o formulário em modal).
- Avisos recentes e resumo da rede ainda não aparecem: `PagesController::home()` não envia esses
  dados (o sino e Minha rede já cobrem). Incluir exige mexer no controller.

## Login (`Pages/login.ctp`, layout `layout-clean`)

```php
<div class="ss-auth">
    <div class="ss-auth-card">
        <?= $this->Html->image('logomarca.png', ['alt' => 'Sales-System', 'class' => 'ss-auth-logo']) ?>
        <h1 class="ss-auth-title"><?= __('Acesse o painel') ?></h1>
        <p class="ss-auth-subtitle"><?= __('Entre com seu login e senha.') ?></p>
        <?= $this->Flash->render() ?>
        <?= $this->Form->create('Usuario', ['id' => 'form_entrar']) ?>
            <div class="form-group">
                <label for="login"><?= __('Login') ?></label>
                <input type="text" name="login" id="login" class="form-control focus" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label for="senha"><?= __('Senha') ?></label>
                <input type="password" name="senha" id="senha" class="form-control" autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg"><?= __('Entrar') ?></button>
        <?= $this->Form->end() ?>
    </div>
</div>
```

Sem imagem de fundo e sem ícones dentro dos campos (labels visíveis bastam). Mantenha a lógica
de manutenção (`$liberado_temporariamente`) exibindo `ss-alert ss-alert--warning` no lugar do form.

## Relatórios (`Reports/*`, `*/report.ctp`, layout `relatorio`)

Feitos para imprimir em A4; a tela é a prévia.

Markup completo em [componentes.md › Relatório](componentes.md#relatório).

- `Layout/relatorio.ctp`: fundo cinza com a folha branca (`ss-report`) no centro (até 1120px);
  rodapé `hidden-print`. Carrega o Highcharts e define as opções comuns (cores dos tokens via
  `ssCor()`, fonte Inter, sem fundo, sem título interno, `.` de milhar e `,` decimal).
- `Element/report-header.ctp`: põe no bloco `report-toolbar` a barra `hidden-print` com quem gerou
  (`ss-muted ss-text-xs`) e "Imprimir" (primário); abre a folha com logo (36px), título
  (`--ss-text-lg`), período e "Emitido em" (também impresso).
- `Element/report-form.ctp` (modal sm dos `*/report.ctp`): seções Período (De/Até) e Filtros,
  `ss-help` dizendo que abre em nova aba, rodapé Cancelar + "Gerar relatório".
- Tabela `table ss-table` **sem** `--stack` (relatório é para papel), com rolagem
  `ss-table-wrap` na tela. Sem coluna de numeração: a contagem vai no `ss-count` do título.
- Totais em `<tfoot>`; status sempre pelo helper (badge em contorno na impressão).
- Gráficos (Highcharts): série principal `--ss-primary-600`, depois `--ss-gray-500`,
  `--ss-info-solid`, `--ss-warning-solid`; por plano, as cores `--ss-plan-*`. Pizza vira rosca
  (`innerSize: '55%'`) com legenda e sem rótulos.
- Impressão (A4, margem 12mm): folha sem borda nem sombra, cabeçalho da tabela repetido em cada
  página, linha não quebra entre páginas, botão de exportar do gráfico some.

## Minha rede (`Users/network.ctp`, `Element/network-node.ctp`)

- Topo: `ss-alert` com a instrução + contagem em `ss-count` (corpo `ss-spread`). Rede vazia:
  `ss-empty` no lugar do alerta e da árvore.
- Nós (`ss-net-node`, seção 17): `ss-avatar--sm`, nome (`ss-net-node-name`), login
  (`ss-net-node-login`) e a linha `ss-net-node-meta` com `ss-plan`, o badge de status só quando
  não for "Ativo" e a contagem de indicados (`fa-sitemap`).
- Quem tem indicados é `<a href="#" class="rede-pessoa ss-net-node" role="button" aria-expanded>`
  (o script de `network.ctp` alterna a lista e o `aria-expanded`); fechado fica com borda
  tracejada. Quem não tem indicados é `<span class="ss-net-node">`, sem clique.
- O tema já troca o hover vermelho pela primária. A área rola na horizontal no celular.
- Não use `user-profile` no contêiner: a regra antiga do `dashboard2.css` força a foto a 40px.

```php
<li>
    <a href="#" class="rede-pessoa ss-net-node" data-id="12" role="button" aria-expanded="true">
        <img src="…" class="ss-avatar ss-avatar--sm" alt="">
        <span class="ss-net-node-body">
            <span class="ss-net-node-name">Beatriz Cardoso</span>
            <span class="ss-net-node-login">beatrizcardoso</span>
            <span class="ss-net-node-meta">
                <span class="ss-plan ss-plan--4">Master</span>
                <span title="Indicados diretos"><i class="fa fa-sitemap" aria-hidden="true"></i> 2</span>
            </span>
        </span>
    </a>
    <ul>…filhos…</ul>
</li>
```

## Loja (`Orders/store.ctp`)

- Produtos em `ss-grid-auto` de cards `ss-product` (ver
  [componentes.md › Produto da loja](componentes.md#produto-da-loja)) em vez de tabela.
- Coluna lateral (`ss-split`) com os cards Entrega (ou Dados da bonificação, para a gestão),
  Forma de pagamento e Resumo (total + botão primário "Finalizar pedido"). No celular a coluna
  desce para depois dos produtos. `#ajax-retorno` fica no Resumo, logo acima do botão, para o
  erro "informe uma quantidade" aparecer onde a pessoa clicou.
- Mantenha `#form-loja`, `.item_produto`, os inputs `type=number`, `#valor_total` e as abas de
  `#tipos_de_pagamentos`. As abas de pagamento ficam com `nav-tabs` (o tema reestiliza) ou
  viram `ss-choices`.

## Páginas de erro (`Error/*`, layout `error`)

`ss-empty` centralizado num `ss-container--narrow`, com ícone (`fa-compass` para 404,
`fa-exclamation-triangle` para 500), título simples ("Página não encontrada"), uma frase e o
botão "Voltar ao início".

Como ficou (2026-10-24): `Layout/error.ctp` tem o próprio `<head>` (o `ErrorController` padrão não
passa pelo `AppController`) com o mesmo `ss-theme.css?v=` de `head.ctp`: **suba os dois juntos**.
`error400.ctp` escolhe o texto pelo `$code`: 404 (`fa-compass`), 401/403 "Acesso negado" (`fa-lock`)
e os demais 4xx "Não foi possível abrir a página". Com debug ligado continua o `dev_error` do Cake.

## E-mail (`Layout/Email/html/default.ctp`)

Única exceção à regra "só tokens": clientes de e-mail não leem `<link>` nem variáveis CSS. Use
tabelas (`role="presentation"`, até 600px) e estilo inline com os valores dos tokens, anotados no
topo do layout. Imagens e links com URL completa (`$this->Url->build('/img/…', true)`).
