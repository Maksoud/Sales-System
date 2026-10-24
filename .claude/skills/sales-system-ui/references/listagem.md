# Listagem (index)

Telas que listam registros: `*/index.ctp`, `Orders/my_orders.ctp`, `Invoices/statement.ctp`,
`Orders/store.ctp` (lista de produtos), `GoalPlans/index.ctp` etc.

## Estrutura

De cima para baixo, sempre nesta ordem (pule o que não se aplica):

1. **Cabeçalho da página** (`ss-page-header`): breadcrumb opcional, título, subtítulo com a
   contagem ou o contexto, ações à direita (uma primária).
2. **Alertas** de contexto (`msg-alert`, `ss-alert`), se houver.
3. **Métricas** (`ss-grid-stats`), só em listas financeiras ou operacionais com totais.
4. **Filtros rápidos** (`ss-segmented`) por tipo/status, se houver.
5. **Card da lista** (`ss-card ss-card--flush`):
   - header com filtros de busca (`ss-filters`) ou título da lista;
   - tabela (`ss-table ss-table--stack`) ou estado vazio;
   - rodapé com contagem e paginação (`ss-table-footer`).
6. **Nota/legenda** (`ss-note`) abaixo do card, se houver.

Com navegação lateral (módulo Sistema, filtros de pedidos), tudo acima vai na coluna da direita
de `ss-layout`.

## Esqueleto

```php
<?php
/* File: src/Template/Products/index.ctp */
$ctrl = $this->request->getParam('controller');
$temFiltro = $this->request->getQuery('iniciar_busca');
?>
<div class="ss-container ss-page">
    <div class="ss-layout">

        <?= $this->element('navbar-side-system') ?>  <?php /* ss-subnav; omita se o módulo não tiver */ ?>

        <div>
            <header class="ss-page-header">
                <div class="ss-page-header-main">
                    <ol class="ss-breadcrumb">
                        <li><?= __('Sistema') ?></li>
                        <li><?= __('Produtos') ?></li>
                    </ol>
                    <h1 class="ss-page-title"><?= __('Produtos') ?></h1>
                    <p class="ss-page-subtitle"><?= __('{0} produtos cadastrados', count($produtos)) ?></p>
                </div>
                <div class="ss-page-actions">
                    <?= $this->Html->link('<i class="fa fa-file-text-o" aria-hidden="true"></i> ' . __('Relatório'), ['action' => 'report'],
                            ['class' => 'btn btn-default btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Relatório de produtos'),
                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                    <?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('Novo produto'), ['action' => 'add'],
                            ['class' => 'btn btn-primary btn_modal', 'data-title' => __('Novo produto'),
                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                </div>
            </header>

            <?= $this->element('msg-alert') ?>

            <section class="ss-card ss-card--flush">
                <div class="ss-card-header">
                    <button type="button" class="btn btn-default ss-filters-toggle" data-toggle="collapse"
                            data-target="#filtros" aria-expanded="false" aria-controls="filtros">
                        <i class="fa fa-sliders" aria-hidden="true"></i> <?= __('Filtros') ?>
                        <?php if ($temFiltro): ?><span class="ss-filters-count">!</span><?php endif; ?>
                    </button>
                    <div id="filtros" class="ss-filters-panel collapse">
                        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'ss-filters']) ?>
                            <div class="form-group ss-filters-grow">
                                <label for="f-title" class="sr-only"><?= __('Buscar') ?></label>
                                <?= $this->Form->text('title', ['id' => 'f-title', 'class' => 'form-control',
                                        'placeholder' => __('Buscar por nome ou descrição'),
                                        'value' => $this->request->getQuery('title')]) ?>
                            </div>
                            <div class="form-group">
                                <label for="f-status" class="sr-only"><?= __('Status') ?></label>
                                <?= $this->Form->select('status', ['A' => __('Ativo'), 'I' => __('Inativo')],
                                        ['id' => 'f-status', 'class' => 'form-control', 'empty' => __('Todos os status'),
                                         'value' => $this->request->getQuery('status')]) ?>
                            </div>
                            <input type="hidden" name="iniciar_busca" value="true">
                            <div class="ss-filters-actions">
                                <?= $this->Html->link(__('Limpar'), ['action' => 'index'],
                                        ['class' => 'btn btn-link', 'id' => 'btn-resetar-form', 'style' => 'display:none;']) ?>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?>
                                </button>
                            </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>

                <?php if (count($produtos)): ?>
                <div class="ss-table-wrap">
                    <table class="table ss-table ss-table--stack" id="adjustable">
                        <thead>
                            <tr>
                                <th class="ss-col-id"><?= __('Código') ?></th>
                                <th><?= __('Produto') ?></th>
                                <th class="ss-num"><?= __('Preço') ?></th>
                                <th class="ss-num"><?= __('Vendidos') ?></th>
                                <th><?= __('Cadastro') ?></th>
                                <th><?= __('Status') ?></th>
                                <th class="ss-actions"><span class="sr-only"><?= __('Ações') ?></span></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td class="ss-col-id" data-label="<?= __('Código') ?>" data-order="<?= $produto->id ?>">
                                    <span class="ss-id">#<?= str_pad($produto->id, 6, '0', STR_PAD_LEFT) ?></span>
                                </td>
                                <td class="ss-cell-primary">
                                    <div class="ss-cell-media">
                                        <?= $this->Html->image('produtos/' . $produto->imagem, ['class' => 'ss-thumb', 'alt' => '']) ?>
                                        <div>
                                            <?= $this->Html->link(h($produto->title), ['action' => 'edit', $produto->id],
                                                    ['class' => 'ss-cell-title btn_modal', 'data-title' => __('Editar produto'),
                                                     'data-loading-text' => h($produto->title), 'escape' => false]) ?>
                                            <span class="ss-cell-sub"><?= h($produto->descricao) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="ss-num" data-label="<?= __('Preço') ?>" data-order="<?= $produto->valor ?>">
                                    <?= $this->Number->currency($produto->valor, 'BRL') ?>
                                </td>
                                <td class="ss-num" data-label="<?= __('Vendidos') ?>">…</td>
                                <td data-label="<?= __('Cadastro') ?>" data-order="<?= $produto->created->format('Ymd') ?>">
                                    <?= $this->MyHtml->tinyDate($produto->created) ?>
                                </td>
                                <td data-label="<?= __('Status') ?>">…badge…</td>
                                <td class="ss-actions">…botões discretos…</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <div class="ss-empty">…</div>
                <?php endif; ?>

                <?php /* Só quando usa o Paginator do Cake (não em #adjustable): */ ?>
                <?php /* echo $this->element('paginator-footer'); */ ?>
            </section>

            <?php /* Legenda opcional: card e nota ficam dentro de um <div class="ss-stack"> */ ?>
            <?php /* <div class="ss-note">…</div> */ ?>
        </div>
    </div>
</div>
```

> O `style="display:none;"` do `#btn-resetar-form` é a exceção permitida (o JS o alterna).

Sem navegação lateral, remova o `ss-layout` e a `<div>` interna.

## Colunas

Ordem: **código → identificação → dados → datas → status → ações**.

| Tipo de coluna | Markup | Regras |
|---|---|---|
| Código | `th/td.ss-col-id` + `span.ss-id` | Sempre a 1ª coluna (o DataTables ordena por ela). `#000123`. |
| Identificação | `td.ss-cell-primary` com `ss-cell-title` + `ss-cell-sub` | Nome em destaque, uma linha de apoio (descrição, login, e-mail). Imagem com `ss-cell-media` + `ss-thumb` ou `ss-avatar--sm`. No celular vira o título do card. |
| Valor / quantidade | `ss-num` no `th` e no `td` | Alinhado à direita, `data-order` com o número cru. |
| Data | texto | `tinyDate` na tabela; `data-order="Ymd"`. |
| Status | badge | Pelo helper. Coluna sem largura fixa. |
| Ações | `ss-actions` | Última coluna, cabeçalho só para leitor de tela. |

- No máximo **7 colunas** visíveis. Dados extras vão para a linha de apoio (`ss-cell-sub`)
  ou para a view.
- Colunas secundárias que podem sumir no celular: `ss-hide-xs` no `td` (e `ss-hide-xs` no `th`).
- Todo `<td>` (menos `ss-cell-primary` e `ss-actions`) tem `data-label` igual ao cabeçalho.
- Texto longo: `ss-truncate` com `title` contendo o texto completo.
- Vazio: `<span class="ss-muted">—</span>`.
- Totais no fim: `<tfoot>` com `ss-num`.

## Ações da linha

| Quantidade | Padrão |
|---|---|
| 1–2 ações | Botões `btn-sm ss-btn-ghost` (com texto curto) ou `ss-btn-icon` |
| 3 ou mais | Ação mais usada visível + menu "Mais ações" (`fa-ellipsis-h`) com as demais |
| Excluir | Sempre a última, `ss-btn-danger-soft`, com `confirm` específico |

A identificação (`ss-cell-title`) já é o link para ver/editar; não repita um botão "Ver/Editar"
de largura total. Botões empilhados com `btn-block` dentro da célula **não** fazem parte do padrão.

## Filtros

- **Rápidos** (`ss-segmented`): opções fixas e frequentes (tipo, status). Fora do card, acima.
- **Busca** (`ss-filters`, dentro do `ss-card-header`): texto livre, períodos, selects.
  - Campo de texto principal primeiro, com `ss-filters-grow`.
  - Selects com opção vazia escrita por extenso ("Todos os status", "Qualquer mês"), não "- status -".
  - Labels `sr-only` (o placeholder/opção vazia descreve o campo); se houver mais de 5 campos,
    use labels visíveis e quebre em duas linhas.
  - Botões: "Limpar" (`btn-link`, `#btn-resetar-form`) e "Buscar" (primário) à direita.
  - No celular ficam recolhidos atrás do botão "Filtros".
- Regras sobre a lista ("Faturas vencidas há mais de 30 dias são canceladas") vão em `ss-help`
  abaixo da tabela ou em `ss-note`, não ao lado dos filtros.

## Métricas no topo

Use quando a lista tiver totais úteis (faturas, extrato, saques). Até 4 cards; cada card pode ser
link para a própria lista filtrada. Elementos como `invoice-summary.ctp` devem gerar
`ss-grid-stats` + `ss-stat` (ver [componentes.md](componentes.md#métricas)).

## Celular

`ss-table--stack` transforma cada linha em um card: o `ss-cell-primary` vira o título, as demais
colunas viram pares "rótulo: valor" e as ações vão para o rodapé do card.

Use rolagem horizontal (`ss-table-wrap` sem `--stack`) só em tabelas de comparação com muitas
colunas numéricas (relatórios, extratos detalhados). Nesse caso mantenha a 1ª coluna curta.

## Lista em cards (alternativa)

Quando o registro é visual e tem poucos dados (produtos da loja, planos de metas), use
`ss-grid-auto` com `ss-card` por item em vez de tabela. Cada card: imagem/ícone, título, 1–2
dados, ação.
