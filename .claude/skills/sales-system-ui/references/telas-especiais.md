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

<title><?= h($title) ?> · Reiniciando</title>
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

            <?= $this->Html->link($this->Html->image('Reiniciando.png', ['alt' => 'Reiniciando', 'id' => 'logo',
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
    <span>© <?= date('Y') ?> Reiniciando</span>
    <a href="http://www.make2.com.br" target="_blank" rel="noopener" title="Make2">
        <?= $this->Html->image('logo-make2.png', ['alt' => 'Desenvolvido por Make2']) ?>
    </a>
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

## Login (`Pages/login.ctp`, layout `layout-clean`)

```php
<div class="ss-auth">
    <div class="ss-auth-card">
        <?= $this->Html->image('Reiniciando.png', ['alt' => 'Reiniciando', 'class' => 'ss-auth-logo']) ?>
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

- `Element/report-header.ctp`: barra `hidden-print` com informações de quem gerou (`ss-muted
  ss-text-xs`) e botão "Imprimir" (primário); cabeçalho impresso com logo (36px), título
  (`--ss-text-lg`) e período em `ss-muted`.
- Tabela `table ss-table` **sem** `--stack` (relatório é para papel), com rolagem
  `ss-table-wrap` na tela.
- Totais em `<tfoot>` ou `ss-totals`.
- Gráficos (Highcharts) com as cores: série principal `#0f7f6a`, secundárias `#66756f`,
  `#2e6fe0`, `#e09b00`; fonte Inter; sem fundo.
- A impressão usa as regras `@media print` do tema (fundo branco, sem sombras, badges em contorno).
- Remova o `text-transform: uppercase` de `.prt-report` ao migrar.

## Minha rede (`Users/network.ctp`, `Element/network-node.ctp`)

- Topo: `ss-alert` com a instrução + contagem em `ss-count`.
- Nós: card pequeno com `ss-avatar--sm`, nome (`ss-text-sm`, 600), login em `ss-muted`,
  `ss-plan` e o badge de status só quando não for "Ativo".
- Contagem de indicados com `fa-sitemap` em `ss-muted`.
- O tema já troca o hover vermelho pela primária. A área rola na horizontal no celular.

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
