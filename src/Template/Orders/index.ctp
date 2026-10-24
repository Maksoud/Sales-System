<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Orders/index.ctp */
?>

<div class="container-fluid">
    <div class="col-xs-12">
        <div class="no-padding-lat">
            <div class="pull-right top-20">
                <?= $this->Html->link('<i class="fa fa-file-text-o" aria-hidden="true"></i> ' . __('Relatório'), ['action' => 'report'], ['class' => 'btn btn-default btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório de Pedidos'), 'escape' => false]) ?>
            </div>
            <h3 class="page-header top-20"><?= __('Pedidos da Loja') ?></h3>
        </div>

        <?= $this->element('msg-alert') ?>

        <div class="row form-busca bottom-10">
            <div class="col-xs-12">
                <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']) ?>
                    <?= $this->Form->text('id', ['class' => 'form-control', 'placeholder' => __('Nº do pedido'), 'value' => $this->request->getQuery('id'), 'style' => 'width:120px']) ?>
                    <?= $this->MyForm->select_ultimos_anos('ano', ['class' => 'form-control', 'empty' => __('- ano -'), 'value' => $this->request->getQuery('ano')], 2018) ?>
                    <?= $this->MyForm->select_meses('mes', ['class' => 'form-control', 'empty' => __('- mês -'), 'value' => $this->request->getQuery('mes')]) ?>
                    <?= $this->Form->select('status', ['M' => __('Aguardando a empresa')] + $this->Pedidos->statusLista(), ['class' => 'form-control', 'empty' => __('- status -'), 'value' => $this->request->getQuery('status')]) ?>
                    <?= $this->Form->select('tipo', ['N' => __('Normal'), 'E' => __('Bonificação de Inscrição'), 'B' => __('Bonificação por Meta')], ['class' => 'form-control', 'empty' => __('- tipo -'), 'value' => $this->request->getQuery('tipo')]) ?>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?></button>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('Listar Todos'), ['action' => 'index'], ['class' => 'btn btn-default', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <div class="scrolling bottom-40 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="text-nowrap"><?= __('#') ?></th>
                        <th class="text-nowrap"><?= __('Data do pedido') ?></th>
                        <th class="text-nowrap"><?= __('Associado') ?></th>
                        <th class="text-nowrap"><?= __('Fatura') ?></th>
                        <th class="text-nowrap"><?= __('Tipo') ?></th>
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
                            <td>
                                <?= $this->Html->link(h($pedido->usuario->nome), ['controller' => 'Users', 'action' => 'view', $pedido->usuario->id], ['class' => 'btn_modal', 'data-title' => __('Dados do Associado')]) ?>
                                <br><small><?= $this->Usuarios->plano($pedido->usuario) ?></small>
                            </td>
                            <td><?= $pedido->fatura ? $this->Html->link(str_pad($pedido->fatura->id, 6, '0', STR_PAD_LEFT), ['controller' => 'Invoices', 'action' => 'view', $pedido->fatura->id], ['class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Detalhes da Fatura')]) : '-' ?></td>
                            <td><?= $this->Pedidos->tipo($pedido->tipo) ?></td>
                            <td class="text-nowrap"><?= $this->Pedidos->total($pedido) ?></td>
                            <td><small><?= $this->Pedidos->etapas($pedido->status) ?></small></td>
                            <td class="col-xs-1">
                                <?= $this->Html->link('<i class="fa fa-eye"></i> ' . __('Visualizar'), ['action' => 'view', $pedido->id], ['class' => 'btn btn-default btn-block btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Detalhes do Pedido #') . $numero, 'escape' => false]) ?>
                                <?php if ($pedido->status == 'V'): ?>
                                    <?= $this->Html->link('<i class="fa fa-usd"></i> ' . __('Informar Valores'), ['action' => 'values', $pedido->id], ['class' => 'top-5 btn btn-warning btn-block btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Valores do Pedido #') . $numero, 'escape' => false]) ?>
                                <?php elseif ($pedido->status == 'S'): ?>
                                    <?= $this->Html->link('<i class="fa fa-truck"></i> ' . __('Produto Enviado'), ['action' => 'delivery', $pedido->id], ['class' => 'top-5 btn btn-primary btn-block btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Entrega do Pedido #') . $numero, 'escape' => false]) ?>
                                <?php elseif ($pedido->status == 'T'): ?>
                                    <?= $this->Form->postLink('<i class="fa fa-check-square-o"></i> ' . __('Entrega Feita'), ['action' => 'finishDelivery', $pedido->id], ['class' => 'top-5 btn btn-primary btn-block', 'escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="fa fa-ban"></i> ' . __('Cancelar Envio'), ['action' => 'cancelDelivery', $pedido->id], ['class' => 'top-5 btn btn-danger btn-block', 'confirm' => __('Cancelar o envio do pedido {0}?', $numero), 'escape' => false]) ?>
                                <?php endif; ?>
                                <?= $this->Html->link('<i class="fa fa-usd"></i> ' . __('Faturas'), ['controller' => 'Invoices', 'action' => 'index', '?' => ['pedido' => $pedido->id, 'iniciar_busca' => 'true']], ['class' => 'top-5 btn btn-default btn-block', 'escape' => false]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
