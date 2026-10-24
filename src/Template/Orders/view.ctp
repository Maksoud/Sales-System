<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Orders/view.ctp */

$this->layout = 'ajax';
$usuario = $pedido->usuario;
?>

<div class="container-fluid">
    <div class="row">

        <div class="col-xs-12 col-sm-4 box bg-yellow padding-15" style="min-height: 230px;">
            <h4><strong><?= __('Destinatário') ?></strong></h4>
            <strong><?= h($usuario->nome) ?></strong> (<?= h($usuario->login) ?>)<br>
            <?= h($usuario->endereco) ?>, Nº <?= h($usuario->numero) ?> <?= h($usuario->complemento) ?><br>
            <?= h($usuario->bairro) ?> - CEP <?= h($usuario->cep) ?><br>
            <?= h($usuario->cidade) ?>/<?= h($usuario->estado) ?> - <?= h($usuario->pais) ?><br>
            <i class="fa fa-phone fa-fw" aria-hidden="true"></i> <?= h($usuario->telefone) ?><br>
            <i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i> <?= h($usuario->email) ?>
        </div>

        <div class="col-xs-12 col-sm-4 box bg-info padding-15" style="min-height: 230px;">
            <h4><strong><?= __('Status do Pedido') ?></strong></h4>
            <?= $this->Pedidos->etapas($pedido->status) ?>
            <hr class="top-10 bottom-10">
            <strong><?= __('Tipo:') ?></strong> <?= $this->Pedidos->tipo($pedido->tipo) ?><br>
            <strong><?= __('Pagamento:') ?></strong>
            <?php if ($pedido->tipo != 'N'): ?>
                <?= $pedido->tipo == 'E' ? __('incluso na taxa de inscrição') : __('bonificação, sem custo') ?>
            <?php else: ?>
                <?= $this->Faturas->forma_pagamento($pedido->fatura->forma_pagamento) ?>
                <?= $pedido->fatura->qt_parcelas > 1 ? '(' . $pedido->fatura->qt_parcelas . 'x)' : __('(à vista)') ?>
            <?php endif; ?>
        </div>

        <div class="col-xs-12 col-sm-4 box bg-primary padding-15" style="min-height: 230px;">
            <h4><strong><?= __('Entrega') ?></strong></h4>
            <?= __('Pedido feito em') ?> <?= $this->MyHtml->time($pedido->created) ?><br>
            <?php if ($pedido->status == 'V'): ?>
                <?= __('Frete e impostos em cálculo. Verifique novamente mais tarde.') ?>
            <?php elseif ($pedido->status == 'C'): ?>
                <?= __('Pedido cancelado.') ?>
            <?php else: ?>
                <?= __('Enviado em:') ?> <?= $pedido->dtdespacho ? $this->MyHtml->date($pedido->dtdespacho) : __('ainda não enviado') ?><br>
                <?= __('Previsão de entrega:') ?> <?= $pedido->dtentrega ? $this->MyHtml->date($pedido->dtentrega) : __('não informada') ?><br>
                <?php if ($pedido->cod_rastreio): ?>
                    <?= __('Rastreio:') ?> <strong><?= h($pedido->cod_rastreio) ?></strong><br>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($pedido->obs): ?>
                <hr class="top-10 bottom-10">
                <small><?= h($pedido->obs) ?></small>
            <?php endif; ?>
        </div>

    </div>

    <div class="top-20 row">
        <div class="col-xs-12 scrolling">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 80px;">&nbsp;</th>
                        <th><?= __('Produto') ?></th>
                        <th class="text-center"><?= __('Preço Unit.') ?></th>
                        <th class="text-center"><?= __('Quantidade') ?></th>
                        <th class="text-right"><?= __('Total') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedido->pedidos_produtos as $item): ?>
                        <tr>
                            <td><?= $this->Html->image('produtos/' . $item->produto->imagem, ['class' => 'img-responsive img-circle', 'style' => 'height: 55px; width: 55px;', 'alt' => $item->produto->title]) ?></td>
                            <td style="white-space: normal">
                                <?= h($item->produto->title) ?><br>
                                <small class="text-cinza"><?= h($item->produto->descricao) ?></small>
                            </td>
                            <td class="text-center text-nowrap"><?= $item->valor_unitario > 0 ? $this->Number->currency($item->valor_unitario, 'BRL') : __('bonificação') ?></td>
                            <td class="text-center"><?= $item->quantidade ?></td>
                            <td class="text-right text-nowrap"><?= $this->Number->currency($item->valor_unitario * $item->quantidade, 'BRL') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="5" class="text-right">
                            <?php if ($pedido->status == 'V'): ?>
                                <h4><small><?= __('Total do pedido:') ?> </small><?= __('aguardando cálculo do frete e impostos') ?></h4>
                            <?php else: ?>
                                <?php if ($pedido->valor_frete > 0): ?>
                                    <h5><small><?= __('Frete:') ?> </small><?= $this->Number->currency($pedido->valor_frete, 'BRL') ?></h5>
                                <?php endif; ?>
                                <h4><small><?= __('Total do pedido:') ?> </small><?= $this->Number->currency($pedido->total, 'BRL') ?></h4>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
