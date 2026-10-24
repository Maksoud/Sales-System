<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Invoices/index.ctp */

$tipo   = (string)$this->request->getQuery('tipo');
$status = (string)$this->request->getQuery('status');

$titulos = ['S' => __('Solicitações de Saques'), 'T' => __('Taxas de Inscrições'),
            'P' => __('Faturas de Pedidos'),     'C' => __('Faturas de Comissões')];
$titulo  = isset($titulos[$tipo]) ? $titulos[$tipo] : __('Extrato Geral');

//Atalhos de filtro (mesmos destinos do menu e do dashboard)
$atalhos = ['' => [__('Todas'), 'fa-list'], 'S' => [__('Saques'), 'fa-btc'], 'T' => [__('Taxas'), 'fa-line-chart'],
            'P' => [__('Pedidos'), 'fa-file-text-o'], 'C' => [__('Comissões'), 'fa-handshake-o']];
?>

<div class="container-fluid">
    <div class="col-xs-12">
        <div class="no-padding-lat">
            <div class="pull-right top-20">
                <?= $this->Html->link('<i class="fa fa-file-text-o" aria-hidden="true"></i> ' . __('Relatório'), ['action' => 'report'], ['class' => 'btn btn-default btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório de Faturas'), 'escape' => false]) ?>
            </div>
            <h3 class="page-header top-20"><?= $titulo ?></h3>
        </div>

        <?= $this->element('msg-alert') ?>

        <div class="bottom-10">
            <div class="btn-group" role="group">
                <?php foreach ($atalhos as $chave => $atalho): ?>
                    <?= $this->Html->link('<i class="fa ' . $atalho[1] . '" aria-hidden="true"></i> ' . $atalho[0],
                            ['action' => 'index', '?' => array_filter(['tipo' => $chave, 'status' => $status])],
                            ['class' => 'btn btn-sm ' . ($tipo === (string)$chave ? 'btn-primary' : 'btn-default'), 'escape' => false]) ?>
                <?php endforeach; ?>
            </div>
            <div class="btn-group" role="group">
                <?php foreach (['' => __('Qualquer status'), 'P' => __('Pendentes'), 'F' => __('Finalizadas'), 'C' => __('Canceladas')] as $chave => $rotulo): ?>
                    <?= $this->Html->link($rotulo, ['action' => 'index', '?' => array_filter(['tipo' => $tipo, 'status' => $chave])],
                            ['class' => 'btn btn-sm ' . ($status === (string)$chave ? 'btn-primary' : 'btn-default')]) ?>
                <?php endforeach; ?>
            </div>
        </div>

        <?= $this->element('invoice-summary', ['resumo' => $resumo]) ?>

        <div class="row form-busca bottom-10">
            <div class="col-xs-12">
                <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']) ?>
                    <?= $this->Form->text('id', ['class' => 'form-control', 'placeholder' => __('Nº da fatura'), 'value' => $this->request->getQuery('id'), 'style' => 'width:110px']) ?>
                    <?= $this->Form->text('busca', ['class' => 'form-control', 'placeholder' => __('Nome do associado...'), 'value' => $this->request->getQuery('busca')]) ?>
                    <?= $this->Form->text('pedido', ['class' => 'form-control', 'placeholder' => __('Nº do pedido'), 'value' => $this->request->getQuery('pedido'), 'style' => 'width:110px']) ?>
                    <?= $this->MyForm->select_meses('mes', ['class' => 'form-control', 'empty' => __('- mês -'), 'value' => $this->request->getQuery('mes')]) ?>
                    <?= $this->MyForm->select_ultimos_anos('ano', ['class' => 'form-control', 'empty' => __('- ano -'), 'value' => $this->request->getQuery('ano')], 2018) ?>
                    <?= $this->Form->select('tipo', $this->Faturas->tipoLista(), ['class' => 'form-control', 'empty' => __('- tipo -'), 'value' => $tipo]) ?>
                    <?= $this->Form->select('forma_pagamento', $this->Faturas->formaPagamentoLista(), ['class' => 'form-control', 'empty' => __('- forma de pagamento -'), 'value' => $this->request->getQuery('forma_pagamento')]) ?>
                    <?= $this->Form->select('status', $this->Faturas->statusLista(), ['class' => 'form-control', 'empty' => __('- status -'), 'value' => $status]) ?>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?></button>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('Listar Todos'), ['action' => 'index'], ['class' => 'btn btn-default', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]) ?>
                <?= $this->Form->end() ?>
                <small class="text-info"><?= __('Faturas vencidas há mais de 30 dias são canceladas automaticamente.') ?></small>
            </div>
        </div>

        <?= $this->element('invoice-table', ['faturas' => $faturas, 'gerenciar' => true]) ?>
    </div>
</div>
