<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Orders/my_orders.ctp */

$temFiltro = $this->request->getQuery('iniciar_busca');
$total = count($pedidos);
$titulo = $gestao ? __('Bonificações lançadas') : __('Meus pedidos');

//Nomes dos produtos do pedido, para a identificação da linha
$produtosDoPedido = function ($pedido) {
    $nomes = [];
    foreach ($pedido->pedidos_produtos as $item) {
        $nomes[] = ($item->quantidade > 1 ? $item->quantidade . '× ' : '') . $item->produto->title;
    }
    return implode(', ', $nomes);
};
?>

<div class="ss-container ss-page">
    <header class="ss-page-header">
        <div class="ss-page-header-main">
            <ol class="ss-breadcrumb">
                <li><?= __('Pedidos') ?></li>
                <li><?= $titulo ?></li>
            </ol>
            <h1 class="ss-page-title"><?= $titulo ?></h1>
            <p class="ss-page-subtitle">
                <?php if ($temFiltro): ?>
                    <?= __n('{0} encontrado', '{0} encontrados', $total, $total) ?>
                <?php elseif ($gestao): ?>
                    <?= __n('{0} bonificação', '{0} bonificações', $total, $total) ?>
                <?php else: ?>
                    <?= __n('{0} pedido', '{0} pedidos', $total, $total) ?>
                <?php endif; ?>
            </p>
        </div>
        <div class="ss-page-actions">
            <?= $this->Html->link('<i class="fa fa-cart-plus" aria-hidden="true"></i> ' . ($gestao ? __('Nova bonificação') : __('Novo pedido')),
                    ['action' => 'store'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
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
                    <div class="form-group">
                        <label for="f-id" class="sr-only"><?= __('Nº do pedido') ?></label>
                        <?= $this->Form->text('id', ['id' => 'f-id', 'class' => 'form-control', 'inputmode' => 'numeric',
                                'placeholder' => __('Nº do pedido'), 'value' => $this->request->getQuery('id')]) ?>
                    </div>
                    <div class="form-group">
                        <label for="f-ano" class="sr-only"><?= __('Ano') ?></label>
                        <?= $this->MyForm->select_ultimos_anos('ano', ['id' => 'f-ano', 'class' => 'form-control',
                                'empty' => __('Qualquer ano'), 'value' => $this->request->getQuery('ano')], 2018) ?>
                    </div>
                    <div class="form-group">
                        <label for="f-mes" class="sr-only"><?= __('Mês') ?></label>
                        <?= $this->MyForm->select_meses('mes', ['id' => 'f-mes', 'class' => 'form-control',
                                'empty' => __('Qualquer mês'), 'value' => $this->request->getQuery('mes')]) ?>
                    </div>
                    <div class="form-group">
                        <label for="f-status" class="sr-only"><?= __('Status') ?></label>
                        <?= $this->Form->select('status', $this->Pedidos->statusLista(), ['id' => 'f-status', 'class' => 'form-control',
                                'empty' => __('Todos os status'), 'value' => $this->request->getQuery('status')]) ?>
                    </div>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <div class="ss-filters-actions">
                        <?= $this->Html->link(__('Limpar'), ['action' => 'myOrders'],
                                ['class' => 'btn btn-link', 'id' => 'btn-resetar-form', 'style' => 'display:none;']) ?>
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?>
                        </button>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <?php if ($total): ?>
        <div class="ss-table-wrap">
            <table class="table ss-table ss-table--stack" id="adjustable">
                <thead>
                    <tr>
                        <th class="ss-col-id"><?= __('Código') ?></th>
                        <th><?= $gestao ? __('Associado') : __('Produtos') ?></th>
                        <th><?= __('Data') ?></th>
                        <th><?= __('Fatura') ?></th>
                        <th class="ss-num"><?= __('Total') ?></th>
                        <th><?= __('Status') ?></th>
                        <th class="ss-actions" data-orderable="false"><span class="sr-only"><?= __('Ações') ?></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <?php
                    $numero = str_pad($pedido->id, 6, '0', STR_PAD_LEFT);
                    $produtos = $produtosDoPedido($pedido);
                    ?>
                    <tr>
                        <td class="ss-col-id" data-label="<?= __('Código') ?>" data-order="<?= $pedido->id ?>">
                            <span class="ss-id">#<?= $numero ?></span>
                        </td>
                        <td class="ss-cell-primary">
                            <?php if ($gestao): ?>
                                <?= $this->Html->link(h($pedido->usuario->nome), ['action' => 'view', $pedido->id],
                                        ['class' => 'ss-cell-title btn_modal', 'data-title' => __('Pedido #{0}', $numero),
                                         'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                <span class="ss-cell-sub ss-truncate" title="<?= h($produtos) ?>"><?= h($produtos) ?></span>
                            <?php else: ?>
                                <?= $this->Html->link(h($produtos), ['action' => 'view', $pedido->id],
                                        ['class' => 'ss-cell-title ss-truncate btn_modal', 'title' => $produtos,
                                         'data-title' => __('Pedido #{0}', $numero),
                                         'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                <span class="ss-cell-sub">
                                    <?php if ($pedido->tipo != 'N'): ?>
                                        <?= h($this->Pedidos->tipo($pedido->tipo)) ?>
                                    <?php elseif ($pedido->fatura): ?>
                                        <?= h($this->Faturas->forma_pagamento($pedido->fatura->forma_pagamento)) ?>
                                        <?= $pedido->fatura->qt_parcelas > 1 ? __('em {0}x', $pedido->fatura->qt_parcelas) : __('à vista') ?>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td data-label="<?= __('Data') ?>" data-order="<?= $pedido->created->format('YmdHi') ?>">
                            <?= $this->MyHtml->tinyDate($pedido->created) ?>
                        </td>
                        <td data-label="<?= __('Fatura') ?>">
                            <?php if ($pedido->fatura): ?>
                                <?= $this->Html->link('#' . str_pad($pedido->fatura->id, 6, '0', STR_PAD_LEFT),
                                        ['controller' => 'Invoices', 'action' => 'view', $pedido->fatura->id],
                                        ['class' => 'ss-mono btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Detalhes da fatura'),
                                         'data-loading-text' => __('Carregando...')]) ?>
                            <?php else: ?>
                                <span class="ss-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="ss-num" data-label="<?= __('Total') ?>" data-order="<?= $pedido->status == 'V' ? -1 : $pedido->total ?>">
                            <?= $this->Pedidos->total($pedido) ?>
                        </td>
                        <td data-label="<?= __('Status') ?>">
                            <?= $this->Pedidos->statusLabel($pedido->status) ?>
                        </td>
                        <td class="ss-actions">
                            <?php if ($pedido->status == 'P' && $pedido->fatura && $pedido->fatura->boleto): ?>
                                <?= $this->Html->link('<i class="fa fa-barcode" aria-hidden="true"></i> ' . __('Ver boleto'),
                                        ['controller' => 'Invoices', 'action' => 'view', $pedido->fatura->id],
                                        ['class' => 'btn btn-sm ss-btn-ghost btn_modal', 'data-tamanho' => 'sm',
                                         'data-title' => __('Detalhes da fatura'), 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                            <?php elseif ($pedido->status == 'P' && $pedido->fatura): ?>
                                <?= $this->Html->link('<i class="fa fa-university" aria-hidden="true"></i> ' . __('Pagar agora'),
                                        ['controller' => 'Invoices', 'action' => 'bankDetails', $pedido->fatura->id],
                                        ['class' => 'btn btn-sm ss-btn-ghost btn_modal', 'data-tamanho' => 'sm',
                                         'data-title' => __('Dados para pagamento'), 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                            <?php elseif ($pedido->status == 'T' && !$gestao): ?>
                                <?= $this->Form->postLink('<i class="fa fa-check" aria-hidden="true"></i> ' . __('Marcar como recebido'),
                                        ['action' => 'markReceived', $pedido->id],
                                        ['class' => 'btn btn-sm ss-btn-ghost', 'escape' => false]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php elseif ($temFiltro): ?>
        <div class="ss-empty">
            <div class="ss-empty-icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
            <p class="ss-empty-title"><?= $gestao ? __('Nenhuma bonificação encontrada') : __('Nenhum pedido encontrado') ?></p>
            <p class="ss-empty-text"><?= __('Ajuste os filtros para ver outros períodos ou status.') ?></p>
            <?= $this->Html->link(__('Limpar filtros'), ['action' => 'myOrders'], ['class' => 'btn btn-default']) ?>
        </div>
        <?php else: ?>
        <div class="ss-empty">
            <div class="ss-empty-icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
            <p class="ss-empty-title"><?= $gestao ? __('Nenhuma bonificação lançada') : __('Você ainda não fez pedidos') ?></p>
            <p class="ss-empty-text"><?= $gestao ? __('As bonificações lançadas pela loja aparecem aqui.') : __('Os pedidos feitos na loja aparecem aqui.') ?></p>
            <?= $this->Html->link(__('Ir para a loja'), ['action' => 'store'], ['class' => 'btn btn-default']) ?>
        </div>
        <?php endif; ?>
    </section>
</div>
