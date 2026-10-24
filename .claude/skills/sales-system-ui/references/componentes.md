# Componentes

Markup de referência de cada componente. Copie a estrutura como está. O CSS correspondente
está em `webroot/css/ss-theme.css` (o número da seção aparece entre parênteses).

Índice: [Botões](#botões) · [Links](#links) · [Badges e selos](#badges-e-selos) ·
[Alertas e flash](#alertas-e-flash) · [Notas e faixas](#notas-e-faixas) · [Cards](#cards) ·
[Métricas](#métricas) · [Atalhos](#atalhos) · [Metas](#metas-progresso) · [Menus e dropdowns](#menus-e-dropdowns) ·
[Controle segmentado](#controle-segmentado) · [Navegação lateral](#navegação-lateral) ·
[Modal](#modal) · [Paginação](#paginação) · [Mensagens e avisos](#mensagens-e-avisos) ·
[Estado vazio](#estado-vazio) · [Produto da loja](#produto-da-loja) · [Relatório](#relatório) · [Avatar](#avatar) · [Carregamento](#carregamento) ·
[Utilitários de layout](#utilitários-de-layout)

---

## Botões
(seção 5)

| Variante | Classe | Uso |
|---|---|---|
| Primário | `btn btn-primary` | A ação principal da tela ou do modal. **Uma por contexto.** |
| Secundário | `btn btn-default` | Demais ações visíveis (Relatório, Imprimir, Cancelar). |
| Discreto | `btn ss-btn-ghost` | Ações em barras, cards e linhas de tabela (Ver, Editar). |
| Perigo | `btn btn-danger` | Confirmar uma exclusão/cancelamento dentro de um modal. |
| Perigo discreto | `btn ss-btn-danger-soft` | Excluir na linha da tabela ou no rodapé do formulário de edição. |
| Link | `btn btn-link` | Ação terciária ("Limpar filtros", "Ver todos"). |
| Só ícone | `+ ss-btn-icon` | Ações repetidas em tabela. Exige `title` e `aria-label`. |

Tamanhos: padrão (38px), `btn-sm` (32px, em tabelas e barras), `btn-xs` (raro), `btn-lg`
(só login). No celular os botões crescem sozinhos para 42px/36px.

`btn-warning`, `btn-info` e `btn-success` não fazem parte do padrão (o tema transforma os dois
primeiros em `default`). Ícone vem **antes** do texto.

```php
<?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('Novo produto'),
        ['action' => 'add'],
        ['class' => 'btn btn-primary btn_modal', 'data-title' => __('Novo produto'),
         'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>

<?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>',
        ['action' => 'edit', $produto->id],
        ['class' => 'btn btn-sm ss-btn-ghost ss-btn-icon btn_modal', 'title' => __('Editar'),
         'aria-label' => __('Editar'), 'data-title' => __('Editar produto'),
         'data-loading-text' => '…', 'escape' => false]) ?>

<?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i>',
        ['action' => 'delete', $produto->id],
        ['confirm' => __('Excluir o produto {0}? Esta ação não pode ser desfeita.', $produto->title),
         'class' => 'btn btn-sm ss-btn-danger-soft ss-btn-icon', 'title' => __('Excluir'),
         'aria-label' => __('Excluir'), 'escape' => false]) ?>
```

Grupo de botões lado a lado: `<div class="ss-cluster">…</div>`. Botão de largura total no
celular: `btn-block` só dentro de modal/rodapé; na página use `ss-page-actions`.

## Links
(seção 2)

- Link de texto: `<a>` comum. Cor `--ss-link`, sublinhado só no hover.
- Link que não deve parecer link (título de card clicável, nome em tabela): `ss-link-quiet`
  ou `ss-cell-title`.
- Link externo: `class="ss-link-external" target="_blank" rel="noopener"` (ícone automático).
- Link dentro de alerta herda a cor do alerta e fica sublinhado.
- Nunca use "clique aqui": o texto do link diz o destino ("Ver pedido #000123").

## Badges e selos
(seção 7, mapas em [status.md](status.md))

```html
<span class="label label-success">Ativo</span>
<span class="label label-warning ss-badge--dot">Pendente</span>

<!-- Contador -->
<span class="ss-count">12</span>
<span class="ss-count ss-count--alert">3</span>

<!-- Selo do plano (id 1..6 ou nome) -->
<span class="ss-plan ss-plan--<?= (int)$id_planos_usuario ?>"><?= h($planos_usuario) ?></span>
```

`label` e `ss-badge` são equivalentes; nas telas novas prefira `label label-*` porque é o que os
helpers geram. Não coloque ícone dentro de badge de status.

**Itens removíveis** (`ss-chips`/`ss-chip`): valores que a pessoa adiciona e tira de uma lista
dentro do formulário (cidades da região). Cada item leva o campo oculto que é enviado; o botão usa
o `data-dismiss="alert"` do Bootstrap com `data-target`, que remove o item (e o campo) sem JS próprio.

```php
<ul class="ss-chips" aria-label="<?= __('Cidades da região') ?>">
    <li id="cidade<?= $i ?>" class="ss-chip">
        <input type="hidden" name="cidade[]" value="<?= h($cidade) ?>">
        <?= h($cidade) ?>
        <button type="button" class="ss-chip-remove" data-dismiss="alert" data-target="#cidade<?= $i ?>"
                title="<?= __('Remover') ?>" aria-label="<?= __('Remover {0}', $cidade) ?>">
            <span aria-hidden="true">&times;</span>
        </button>
    </li>
</ul>
```

Não use para status nem para categorias (são badges); o chip é só para escolhas que se removem.

## Alertas e flash
(seção 8)

**Flash** (mensagens do controller via `$this->Flash->success()` etc.) usa os elements
`Element/Flash/*.ctp`, que devem gerar:

```php
<div class="alert alert-success" role="status">
    <button type="button" class="close" data-dismiss="alert" aria-label="<?= __('Fechar') ?>">
        <span aria-hidden="true">&times;</span>
    </button>
    <i class="fa fa-check-circle" aria-hidden="true"></i> <?= $message ?>
</div>
```

| Element | Classe | Ícone | `role` |
|---|---|---|---|
| `success.ctp` | `alert-success` | `fa-check-circle` | `status` |
| `warning.ctp` | `alert-warning` | `fa-exclamation-triangle` | `status` |
| `error.ctp` | `alert-danger` | `fa-times-circle` | `alert` |
| `default.ctp` | `alert-info` | `fa-info-circle` | `status` |

O layout imprime o flash dentro de `<div class="ss-flash">` logo acima do conteúdo.

**Alerta dentro da tela** (explicação, regra, aviso de contexto) usa o alerta estruturado:

```html
<div class="ss-alert ss-alert--warning" role="status">
    <i class="fa fa-exclamation-triangle ss-alert-icon" aria-hidden="true"></i>
    <div class="ss-alert-body">
        <p class="ss-alert-title">Cadastro aguardando pagamento</p>
        <p>Assim que a taxa for confirmada, a loja e o cadastro de associados serão liberados.</p>
    </div>
</div>
```

Variantes: `ss-alert` (info, padrão), `--success`, `--warning`, `--danger`. Botão de fechar
opcional: `<button type="button" class="ss-alert-close" data-dismiss="alert" aria-label="Fechar">&times;</button>`
como último filho.

Use alerta só quando a mensagem muda o que a pessoa vai fazer. Regras fixas e legendas vão em
`ss-note`.

## Notas e faixas
(seção 8)

```html
<!-- Legenda, regra de negócio, observação -->
<div class="ss-note">
    <span class="ss-note-title">Legenda</span>
    <i class="fa fa-sitemap fa-fw" aria-hidden="true"></i> Produto que gera comissões na rede
</div>

<!-- Ajuda curta abaixo de um bloco -->
<p class="ss-help">Faturas vencidas há mais de 30 dias são canceladas automaticamente.</p>

<!-- Faixa de destaque no topo da página (um por página, no máximo) -->
<div class="ss-banner">
    <i class="fa fa-clock-o" aria-hidden="true"></i> Aguardando confirmação de pagamento
</div>
```

## Cards
(seção 9)

Todo conteúdo da página fica em card. `panel panel-default` do Bootstrap continua funcionando
com o mesmo visual, mas use `ss-card` nas telas migradas.

```html
<section class="ss-card">
    <header class="ss-card-header">
        <div>
            <h2 class="ss-card-title">Itens do pedido</h2>
            <p class="ss-card-subtitle">3 produtos</p>
        </div>
        <a class="btn btn-sm btn-default" href="#">Ação do card</a>
    </header>
    <div class="ss-card-body">…</div>
    <footer class="ss-card-footer">…</footer>
</section>
```

- `ss-card--flush`: card cujo corpo é uma tabela (sem padding).
- `a.ss-card`: card inteiro clicável.
- Header e footer são opcionais. Não aninhe card dentro de card; use `ss-section`.

## Métricas
(seção 9)

Linha de indicadores no topo de listagens financeiras e do dashboard. Sempre em
`ss-grid-stats` (4 colunas, 2 no celular). No máximo 4 por linha.

```php
<div class="ss-grid-stats">
    <a class="ss-stat ss-tone-warning" href="<?= $this->Url->build([...]) ?>">
        <span class="ss-stat-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
        <span class="ss-stat-label"><?= __('Pendentes') ?></span>
        <span class="ss-stat-value"><?= $this->Number->currency($resumo['P'], 'BRL') ?></span>
        <span class="ss-stat-meta"><?= __('{0} faturas', $qtde) ?></span>
    </a>
    …
</div>
```

Tons: padrão (primária), `ss-tone-success`, `-warning`, `-danger`, `-info`, `-neutral`.
O tom pinta só o ícone; o número fica sempre na cor do texto. Use `div.ss-stat` quando não for link.

## Atalhos
(seção 9)

Blocos do "Acesso rápido" do dashboard.

```php
<div class="ss-grid-auto">
    <?= $this->Html->link(
        '<span class="ss-shortcut-icon"><i class="fa fa-cart-plus" aria-hidden="true"></i></span>'
      . '<span><span class="ss-shortcut-title">' . __('Loja') . '</span>'
      . '<span class="ss-shortcut-desc">' . __('Fazer um novo pedido') . '</span></span>',
        ['controller' => 'Orders', 'action' => 'store'],
        ['class' => 'ss-shortcut', 'escape' => false]) ?>

    <!-- Ainda não implementado -->
    <span class="ss-shortcut is-soon" title="Em breve">
        <span class="ss-shortcut-icon"><i class="fa fa-bullseye" aria-hidden="true"></i></span>
        <span><span class="ss-shortcut-title">Metas <span class="label label-default">Em breve</span></span>
        <span class="ss-shortcut-desc">Acompanhamento de metas</span></span>
    </span>
</div>
```

Tons iguais aos das métricas (`ss-tone-*`), usados com moderação: o padrão é a primária. Use tom
diferente só para separar grupos (ex.: financeiro `ss-tone-info`).

## Metas (progresso)
(seção 17)

Lista de metas do associado no dashboard. A barra é um `<progress>` nativo (`ss-progress`):
nada de `.progress-bar` com `style="width"`. `is-done` (100% ou mais) pinta a barra de verde.

```php
<ul class="ss-goals">
    <li class="ss-goal<?= $porcentagem >= 100 ? ' is-done' : '' ?>">
        <div class="ss-goal-head">
            <span class="ss-goal-title"><?= h($frase) ?></span>
            <span class="ss-goal-value"><?= min($porcentagem, 100) ?>%</span>
        </div>
        <progress class="ss-progress" value="<?= min($porcentagem, 100) ?>" max="100"
                  aria-label="<?= h($frase_meta) ?>"><?= $porcentagem ?>%</progress>
        <span class="ss-goal-meta"><i class="fa fa-bullseye" aria-hidden="true"></i> <?= h($frase_meta) ?></span>
    </li>
</ul>
```

`ss-progress` também serve sozinho para qualquer barra de progresso.

## Menus e dropdowns
(seção 14; estrutura completa do cabeçalho em [telas-especiais.md](telas-especiais.md#layout-base))

**Item do menu principal** (`Element/menus/*.ctp`), com estado ativo:

```php
<?php $ctrl = $this->request->getParam('controller'); ?>
<li class="<?= $ctrl == 'Pages' ? 'active' : '' ?>">
    <?= $this->Html->link('<i class="fa fa-home fa-fw" aria-hidden="true"></i> ' . __('Início'),
            ['controller' => 'Pages', 'action' => 'home'], ['escape' => false]) ?>
</li>
<li class="dropdown <?= in_array($ctrl, ['Orders']) ? 'active' : '' ?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-shopping-cart fa-fw" aria-hidden="true"></i> <?= __('Pedidos') ?> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li class="dropdown-header"><?= __('Loja') ?></li>
        <li><?= $this->Html->link('<i class="fa fa-cart-plus" aria-hidden="true"></i> ' . __('Loja'), [...], ['escape' => false]) ?></li>
        <li role="separator" class="divider"></li>
        <li><?= $this->Html->link('<i class="fa fa-file-text-o" aria-hidden="true"></i> ' . __('Meus pedidos'), [...], ['escape' => false]) ?></li>
    </ul>
</li>
```

Regras: até 7 itens no primeiro nível; agrupe o resto em dropdowns. Use `dropdown-header` para
separar grupos dentro de um dropdown grande (ex.: Relatórios) em vez de muitos `divider`.

**Menu "Mais ações"** (em cabeçalho de página, card ou linha de tabela):

```html
<div class="dropdown">
    <button type="button" class="btn btn-sm ss-btn-ghost ss-btn-icon dropdown-toggle"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            title="Mais ações" aria-label="Mais ações">
        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-right">
        <li><a href="#"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a></li>
        <li role="separator" class="divider"></li>
        <li class="ss-danger-item"><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Excluir</a></li>
    </ul>
</div>
```

Dentro de tabela com rolagem, o dropdown pode ser cortado: prefira `dropup` na última linha ou
use botões soltos.

## Controle segmentado
(seção 14)

Filtros rápidos de uma listagem (tipo, status). Substitui os `btn-group` de filtros.

```php
<nav class="ss-segmented" aria-label="<?= __('Filtrar por tipo') ?>">
    <?php foreach ($atalhos as $chave => $atalho): ?>
        <?= $this->Html->link('<i class="fa ' . $atalho[1] . '" aria-hidden="true"></i> ' . $atalho[0],
                ['action' => 'index', '?' => array_filter(['tipo' => $chave, 'status' => $status])],
                ['class' => $tipo === (string)$chave ? 'is-active' : '', 'escape' => false,
                 'aria-current' => $tipo === (string)$chave ? 'page' : 'false']) ?>
    <?php endforeach; ?>
</nav>
```

Até 6 opções. No celular rola na horizontal. Dois controles na mesma tela ficam em `ss-cluster`.
O seletor "Ver como" do cabeçalho (`.tipo-acesso`) segue o mesmo visual.

## Navegação lateral
(seção 15)

Para módulos com subseções fixas (Sistema, filtros de pedidos). Substitui os
`navbar-side-*.ctp`. Usada dentro de `ss-layout` (ver [listagem.md](listagem.md)).

```php
<nav class="ss-subnav" aria-label="<?= __('Sistema') ?>">
    <p class="ss-subnav-title"><?= __('Sistema') ?></p>
    <ul class="ss-subnav-list">
        <li><?= $this->Html->link('<i class="fa fa-users" aria-hidden="true"></i> ' . __('Usuários'),
                ['controller' => 'Users', 'action' => 'index'],
                ['class' => $ctrl == 'Users' ? 'is-active' : '', 'escape' => false]) ?></li>
        <li><?= $this->Html->link('<i class="fa fa-cube" aria-hidden="true"></i> ' . __('Produtos') . ' <span class="ss-count">12</span>',
                ['controller' => 'Products', 'action' => 'index'],
                ['class' => $ctrl == 'Products' ? 'is-active' : '', 'escape' => false]) ?></li>
    </ul>
</nav>
```

No celular vira uma fileira de pílulas roláveis acima do conteúdo. O relógio (`#timer`) que
existia na barra lateral antiga não faz parte do padrão: remova.

## Modal
(seção 13)

Estrutura única em `Element/modal.ctp`; o conteúdo chega por AJAX via `.btn_modal`.

```html
<div id="modal_item" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal_item_title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_item_title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
            </div>
            <div id="modal_item_body" class="modal-body"></div>
        </div>
    </div>
</div>
```

- Tamanho: padrão `modal-lg` (880px). `data-tamanho="sm"` (420px) para formulários de 1 a 4
  campos (senha, saque, relatório).
- O título vem do `data-title` do botão: substantivo + contexto ("Editar produto", "Pedido #000123").
- Conteúdo com rodapé: o template fecha o `.modal-body` e abre o `.modal-footer`
  (convenção do projeto, ver [formulario.md](formulario.md#formulário-em-modal)).
- Ordem no rodapé: secundário à esquerda, primário à direita. Ação destrutiva de edição fica
  isolada à esquerda com `ss-footer-start`.
- No celular: tela cheia, cabeçalho e rodapé fixos, botões empilhados com o primário por cima.

## Paginação
(seção 12)

`Element/paginator-footer.ctp` deve gerar:

```php
<div class="ss-table-footer">
    <span class="ss-pagination-info"><?= $this->Paginator->counter(__('{{start}}–{{end}} de {{count}}')) ?></span>
    <ul class="pagination">
        <?= $this->Paginator->prev('<i class="fa fa-angle-left" aria-hidden="true"></i><span class="sr-only">' . __('Anterior') . '</span>', ['escape' => false]) ?>
        <?= $this->Paginator->numbers(['modulus' => 4]) ?>
        <?= $this->Paginator->next('<i class="fa fa-angle-right" aria-hidden="true"></i><span class="sr-only">' . __('Próxima') . '</span>', ['escape' => false]) ?>
    </ul>
</div>
```

Fica dentro do card da tabela, logo após ela. Tabelas `#adjustable` usam a paginação do
DataTables, já reestilizada pelo tema.

## Mensagens e avisos
(seção 16)

Lista de avisos (sino do cabeçalho, `Notices/pending`), recados e históricos.

```php
<ul class="ss-messages">
    <?php foreach ($avisos as $aviso): ?>
    <li class="ss-message is-unread">
        <span class="ss-message-icon"><i class="fa fa-bell-o" aria-hidden="true"></i></span>
        <div class="ss-message-body">
            <div class="ss-message-head">
                <h3 class="ss-message-title"><?= h($aviso->titulo) ?></h3>
                <span class="ss-message-meta"><?= h($aviso->remetente) ?> · <?= $this->MyHtml->date($aviso->created) ?></span>
            </div>
            <p class="ss-message-text"><?= h($aviso->mensagem) ?></p>
            <div class="ss-message-actions">
                <button type="button" class="btn btn-sm btn-default btn-descartar">
                    <i class="fa fa-check" aria-hidden="true"></i> <?= __('Marcar como lido') ?>
                </button>
            </div>
        </div>
    </li>
    <?php endforeach; ?>
</ul>
```

Variantes de ícone: padrão (primária), `ss-message--warning`, `ss-message--danger`.
`is-unread` adiciona o ponto antes do título.

**Texto com HTML** (mensagem do aviso, que já vem com `<p>`, `<strong>`): use
`<div class="ss-message-text ss-richtext">` no lugar do `<p>`, para não aninhar parágrafos e
desligar o `pre-line`. `ss-richtext` também serve fora da lista (view do aviso).
Imagem que acompanha o texto (banner do aviso): `$this->Html->image($src, ['class' => 'ss-figure', 'alt' => …])`.

No cabeçalho, o sino usa `ss-icon-btn` com `ss-count ss-count--alert` quando há pendentes.
Sem animação de giro.

## Estado vazio
(seção 16)

Obrigatório em toda lista que pode vir vazia (tabela, avisos, rede).

```php
<div class="ss-empty">
    <div class="ss-empty-icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
    <p class="ss-empty-title"><?= __('Nenhum pedido encontrado') ?></p>
    <p class="ss-empty-text"><?= __('Ajuste os filtros ou faça um novo pedido na loja.') ?></p>
    <?= $this->Html->link(__('Ir para a loja'), ['action' => 'store'], ['class' => 'btn btn-default']) ?>
</div>
```

Em tabela, coloque o `ss-empty` no lugar da `<table>` (não numa linha `colspan`). Com DataTables
(`#adjustable`), deixe a tabela e o texto `zeroRecords` do plugin.

## Produto da loja
(seção 17)

Card de produto da loja (`Orders/store.ctp`), dentro de `ss-grid-auto`. No celular (< 480px) a
imagem vai para a esquerda para a lista ficar mais curta. As classes `item_produto`,
`valor_unit` (só o preço, sem outro markup) e `valor_total_prod` são ganchos do `CalculaTotal`
em `maksoud-custom.js`: não remova.

```php
<article class="ss-card ss-product item_produto">
    <a href="#" class="ss-product-media btn_modal" data-title="<?= h($produto->title) ?>" data-img="true"
       title="<?= __('Ampliar imagem') ?>" aria-label="<?= __('Ampliar imagem de {0}', h($produto->title)) ?>">
        <?= $this->Html->image('produtos/' . $produto->imagem, ['alt' => '']) ?>
    </a>
    <div class="ss-product-body">
        <h2 class="ss-product-title"><?= h($produto->title) ?></h2>
        <p class="ss-product-desc"><?= h($produto->descricao) ?></p>
        <span class="ss-product-price ss-money valor_unit"><?= $this->Number->currency($produto->valor, 'BRL') ?></span>
    </div>
    <div class="ss-product-footer">
        <div class="ss-product-qty">
            <label for="produto-<?= $produto->id ?>"><?= __('Qtd.') ?></label>
            <?= $this->Form->number('produtos.' . $produto->id, ['id' => 'produto-' . $produto->id, 'min' => 0, 'step' => 1,
                    'class' => 'form-control', 'placeholder' => '0', 'inputmode' => 'numeric']) ?>
        </div>
        <span class="ss-product-subtotal">R$ <span class="valor_total_prod">0,00</span></span>
    </div>
</article>
```

## Relatório
(seção 19; regras da tela em [telas-especiais.md](telas-especiais.md#relatórios-reports-reportctp-layout-relatorio))

Folha dos relatórios (`Reports/*`, layout `relatorio`). O layout já monta a página e a folha;
o template só começa pelo `report-header` e empilha `ss-report-section`:

```php
<!-- Layout/relatorio.ctp (pronto, não repetir no template) -->
<body class="ss-report-page">
    <main class="ss-container ss-page">
        <?= $this->fetch('report-toolbar') ?>   <!-- barra "Gerado por" + Imprimir, vem do report-header -->
        <article class="ss-report"><?= $this->fetch('content') ?></article>
    </main>
</body>

<!-- Template do relatório -->
<?= $this->element('report-header', ['titulo' => __('Relatório de pedidos'), 'periodo' => $periodo]) ?>

<section class="ss-report-section">
    <h2 class="ss-section-title"><?= __('Resumo por status') ?></h2>
    <div class="ss-report-summary">                     <!-- tabela + gráfico lado a lado -->
        <div class="ss-table-wrap"><table class="table ss-table">…<tfoot>…</tfoot></table></div>
        <div id="grafico-status" class="ss-report-chart" role="img" aria-label="…"></div>
    </div>
</section>

<section class="ss-report-section">
    <h2 class="ss-section-title"><?= __('Pedidos') ?> <span class="ss-count"><?= count($pedidos) ?></span></h2>
    <div class="ss-table-wrap"><table class="table ss-table">…</table></div>
</section>
```

- Lista vazia: `ss-empty` no lugar das seções.
- Totais em `<tfoot>` com `<td>` (o tema pinta o fundo e põe a borda).
- Indicadores: `ss-grid-stats` com `div.ss-stat` (na folha a grade se ajusta a 3 colunas).
- Progresso em linha de tabela: `<div class="ss-report-progress [is-done]"><progress class="ss-progress">…</progress><span>3/10</span></div>`.
- Gráfico: `ss-report-chart` (260px) ou `--lg` (320px). Cores, fonte e textos dos gráficos já vêm do
  `Highcharts.setOptions` do layout, que lê os tokens com `ssCor('--ss-…')`; para uma série com cor
  própria, use `ssCor()` (ex.: `ssCor('--ss-plan-vip')`), nunca hex.
- Datas em `->format('d/m/Y')` (no papel, "Hoje"/"Ontem" do `MyHtml->date()` não serve).

## Avatar
(seção 14)

```php
<?= $this->Html->image($foto_usuario, ['class' => 'ss-avatar', 'alt' => '']) ?>
<!-- Sem foto: iniciais -->
<span class="ss-avatar" aria-hidden="true">RM</span>
```

Tamanhos: `ss-avatar--sm` (24px, tabelas), padrão (32px, cabeçalho), `ss-avatar--lg` (48px, perfil).

## Carregamento
(seção 13)

O overlay `.bg_ajax` do layout já ganha visual claro e discreto pelo tema. Mantenha o markup:

```html
<div class="bg_ajax hide" role="status" aria-live="polite">
    <i class="fa fa-spinner fa-pulse fa-fw" aria-hidden="true"></i>
    <span>Carregando</span>
</div>
```

Em botões, use `data-loading-text` (o Bootstrap troca o texto e desabilita).

## Utilitários de layout
(seções 3 e 18)

| Classe | Efeito |
|---|---|
| `ss-container` | Largura máxima 1320px com gutter lateral (`--narrow`: 880px) |
| `ss-page` | Espaço vertical padrão da página |
| `ss-layout` | Grade navegação lateral (220px) + conteúdo |
| `ss-split` | Grade conteúdo (2/3) + coluna lateral (1/3); empilha abaixo de 992px |
| `ss-stack` / `-sm` / `-lg` | Coluna com espaço de 16 / 8 / 24px entre filhos |
| `ss-cluster` | Linha com quebra e espaço de 8px |
| `ss-spread` | Linha com itens nas pontas |
| `ss-grid-stats` | Grade de 4 métricas (2 no tablet/celular) |
| `ss-grid-auto` | Grade automática de cards de 240px+ |
| `ss-muted`, `ss-text-xs`, `ss-text-sm`, `ss-nowrap`, `ss-mono` | Texto |
| `ss-mt-0`, `ss-mb-0`, `ss-mb-4`, `ss-mb-6` | Ajustes pontuais de margem (evite) |
| `ss-hide-xs`, `ss-only-xs` | Esconde no celular / mostra só no celular |
| `hidden-print` (Bootstrap) | Não imprime |
