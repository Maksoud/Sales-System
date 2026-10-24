<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Invoices/index.ctp */

$tipo      = (string)$this->request->getQuery('tipo');
$status    = (string)$this->request->getQuery('status');
$temFiltro = $this->request->getQuery('iniciar_busca');
$total     = count($faturas);

$titulos = ['S' => __('Solicitações de saque'), 'T' => __('Taxas de inscrição'),
            'P' => __('Faturas de pedidos'),    'C' => __('Faturas de comissões')];
$titulo  = isset($titulos[$tipo]) ? $titulos[$tipo] : __('Extrato geral');

//Filtro rápido de status: mantém os demais filtros e troca só o status
$query = $this->request->getQueryParams();
unset($query['status'], $query['iniciar_busca']);
$query = array_filter($query, 'strlen');
$situacoes = ['' => __('Todas'), 'P' => __('Pendentes'), 'F' => __('Finalizadas'), 'C' => __('Canceladas')];
?>

<div class="ss-container ss-page">
    <div class="ss-layout">

        <?= $this->element('navbar-side-faturas') ?>

        <div class="ss-stack">
            <header class="ss-page-header">
                <div class="ss-page-header-main">
                    <ol class="ss-breadcrumb">
                        <li><?= __('Gerenciar') ?></li>
                        <li><?= $tipo !== '' ? $this->Html->link(__('Extrato geral'), ['action' => 'index']) : __('Financeiro') ?></li>
                    </ol>
                    <h1 class="ss-page-title"><?= $titulo ?></h1>
                    <p class="ss-page-subtitle">
                        <?= $temFiltro
                            ? __n('{0} fatura encontrada', '{0} faturas encontradas', $total, $total)
                            : __n('{0} fatura', '{0} faturas', $total, $total) ?>
                    </p>
                </div>
                <div class="ss-page-actions">
                    <?= $this->Html->link('<i class="fa fa-file-text-o" aria-hidden="true"></i> ' . __('Relatório'), ['action' => 'report'],
                            ['class' => 'btn btn-default btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Relatório de faturas'),
                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                </div>
            </header>

            <?= $this->element('msg-alert') ?>

            <?= $this->element('invoice-summary', ['resumo' => $resumo]) ?>

            <nav class="ss-segmented" aria-label="<?= __('Filtrar por status') ?>">
                <?php foreach ($situacoes as $chave => $rotulo): ?>
                    <?php
                    $filtros = $chave === '' ? $query : $query + ['status' => $chave];
                    if ($filtros) $filtros['iniciar_busca'] = 'true';
                    $ativo = $status === (string)$chave;
                    ?>
                    <?= $this->Html->link($rotulo, ['action' => 'index', '?' => $filtros],
                            ['class' => $ativo ? 'is-active' : '', 'aria-current' => $ativo ? 'page' : 'false']) ?>
                <?php endforeach; ?>
            </nav>

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
                                <label for="f-busca"><?= __('Associado') ?></label>
                                <?= $this->Form->text('busca', ['id' => 'f-busca', 'class' => 'form-control',
                                        'placeholder' => __('Nome ou login'), 'value' => $this->request->getQuery('busca')]) ?>
                            </div>
                            <div class="form-group">
                                <label for="f-id"><?= __('Nº da fatura') ?></label>
                                <?= $this->Form->text('id', ['id' => 'f-id', 'class' => 'form-control', 'inputmode' => 'numeric',
                                        'placeholder' => __('Ex.: 123'), 'value' => $this->request->getQuery('id')]) ?>
                            </div>
                            <div class="form-group">
                                <label for="f-pedido"><?= __('Nº do pedido') ?></label>
                                <?= $this->Form->text('pedido', ['id' => 'f-pedido', 'class' => 'form-control', 'inputmode' => 'numeric',
                                        'placeholder' => __('Ex.: 45'), 'value' => $this->request->getQuery('pedido')]) ?>
                            </div>
                            <div class="form-group">
                                <label for="f-mes"><?= __('Mês') ?></label>
                                <?= $this->MyForm->select_meses('mes', ['id' => 'f-mes', 'class' => 'form-control',
                                        'empty' => __('Qualquer mês'), 'value' => $this->request->getQuery('mes')]) ?>
                            </div>
                            <div class="form-group">
                                <label for="f-ano"><?= __('Ano') ?></label>
                                <?= $this->MyForm->select_ultimos_anos('ano', ['id' => 'f-ano', 'class' => 'form-control',
                                        'empty' => __('Qualquer ano'), 'value' => $this->request->getQuery('ano')], 2018) ?>
                            </div>
                            <div class="form-group">
                                <label for="f-forma"><?= __('Forma de pagamento') ?></label>
                                <?= $this->Form->select('forma_pagamento', $this->Faturas->formaPagamentoLista(),
                                        ['id' => 'f-forma', 'class' => 'form-control', 'empty' => __('Todas as formas'),
                                         'value' => $this->request->getQuery('forma_pagamento')]) ?>
                            </div>
                            <?php /* Tipo e status vêm da navegação lateral e do filtro rápido */ ?>
                            <?php if ($tipo !== ''): ?><input type="hidden" name="tipo" value="<?= h($tipo) ?>"><?php endif; ?>
                            <?php if ($status !== ''): ?><input type="hidden" name="status" value="<?= h($status) ?>"><?php endif; ?>
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

                <?= $this->element('invoice-table', ['faturas' => $faturas, 'gerenciar' => true]) ?>
            </section>

            <p class="ss-help"><?= __('Faturas vencidas há mais de 30 dias são canceladas automaticamente.') ?></p>
        </div>
    </div>
</div>
