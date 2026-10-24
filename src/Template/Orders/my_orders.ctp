<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Orders/my_orders.ctp */
?>

<div class="container-fluid">
    <div class="col-xs-12">
        <div class="no-padding-lat">
            <div class="pull-right top-20">
                <?= $this->Html->link('<i class="fa fa-cart-plus" aria-hidden="true"></i> ' . ($gestao ? __('Nova Bonificação') : __('Novo Pedido')), ['action' => 'store'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
            </div>
            <h3 class="page-header top-20">
                <?= $gestao ? __('Bonificações Lançadas') : __('Meus Pedidos') ?>
            </h3>
        </div>

        <?= $this->element('msg-alert') ?>

        <div class="row form-busca bottom-10">
            <div class="col-xs-12">
                <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']) ?>
                    <?= $this->Form->text('id', ['class' => 'form-control', 'placeholder' => __('Nº do pedido'), 'value' => $this->request->getQuery('id'), 'style' => 'width:120px']) ?>
                    <?= $this->MyForm->select_ultimos_anos('ano', ['class' => 'form-control', 'empty' => __('- ano -'), 'value' => $this->request->getQuery('ano')], 2018) ?>
                    <?= $this->MyForm->select_meses('mes', ['class' => 'form-control', 'empty' => __('- mês -'), 'value' => $this->request->getQuery('mes')]) ?>
                    <?= $this->Form->select('status', $this->Pedidos->statusLista(), ['class' => 'form-control', 'empty' => __('- status -'), 'value' => $this->request->getQuery('status')]) ?>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?></button>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('Listar Todos'), ['action' => 'myOrders'], ['class' => 'btn btn-default', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <div class="scrolling bottom-40 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="text-nowrap"><?= __('#') ?></th>
                        <th class="text-nowrap"><?= __('Data do pedido') ?></th>
                        <?php if ($gestao): ?>
                            <th class="text-nowrap"><?= __('Associado') ?></th>
                        <?php endif; ?>
                        <th class="text-nowrap"><?= __('Fatura') ?></th>
                        <th class="text-nowrap"><?= __('Tipo') ?></th>
                        <th class="text-center text-nowrap"><?= __('Forma Pgto') ?></th>
                        <th class="text-nowrap"><?= __('Valor Total') ?></th>
                        <th class="text-nowrap"><?= __('Status') ?></th>
                        <th class="text-center"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <?php $numero = str_pad($pedido->id, 6, '0', STR_PAD_LEFT); ?>
                        <tr>
                            <td><?= $numero ?></td>
                            <td data-order="<?= $pedido->created->format('YmdHi') ?>"><?= $this->MyHtml->date($pedido->created) ?></td>
                            <?php if ($gestao): ?>
                                <td><?= h($pedido->usuario->nome) ?></td>
                            <?php endif; ?>
                            <td><?= $pedido->fatura ? $this->Html->link(str_pad($pedido->fatura->id, 6, '0', STR_PAD_LEFT), ['controller' => 'Invoices', 'action' => 'view', $pedido->fatura->id], ['class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Detalhes da Fatura')]) : '-' ?></td>
                            <td><?= $this->Pedidos->tipo($pedido->tipo) ?></td>
                            <td class="text-center">
                                <?php if ($pedido->tipo != 'N'): ?>
                                    <small class="text-cinza"><?= __('Bonificação') ?></small>
                                <?php else: ?>
                                    <?= $this->Faturas->forma_pagamento($pedido->fatura->forma_pagamento) ?>
                                    <?= $pedido->fatura->qt_parcelas > 1 ? ' (' . $pedido->fatura->qt_parcelas . 'x)' : '' ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-nowrap"><?= $this->Pedidos->total($pedido) ?></td>
                            <td><small><?= $this->Pedidos->etapas($pedido->status) ?></small></td>
                            <td class="col-xs-1">
                                <?= $this->Html->link('<i class="fa fa-eye"></i> ' . __('Visualizar'), ['action' => 'view', $pedido->id], ['class' => 'btn btn-default btn-block btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Detalhes do Pedido #') . $numero, 'escape' => false]) ?>
                                <?php if ($pedido->status == 'P' && $pedido->fatura && $pedido->fatura->boleto): ?>
                                    <?= $this->Html->link('<i class="fa fa-barcode"></i> ' . __('Ver Boleto'), ['controller' => 'Invoices', 'action' => 'view', $pedido->fatura->id], ['class' => 'top-5 btn btn-warning btn-block btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Detalhes da Fatura'), 'escape' => false]) ?>
                                <?php elseif ($pedido->status == 'P' && $pedido->fatura): ?>
                                    <?= $this->Html->link('<i class="fa fa-usd"></i> ' . __('Pagar agora'), ['controller' => 'Invoices', 'action' => 'bankDetails', $pedido->fatura->id], ['class' => 'top-5 btn btn-warning btn-block btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Dados para Pagamento'), 'escape' => false]) ?>
                                <?php elseif ($pedido->status == 'T' && !$gestao): ?>
                                    <?= $this->Form->postLink('<i class="fa fa-check-square-o"></i> ' . __('Marcar como recebido'), ['action' => 'markReceived', $pedido->id], ['class' => 'top-5 btn btn-primary btn-block', 'escape' => false]) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
