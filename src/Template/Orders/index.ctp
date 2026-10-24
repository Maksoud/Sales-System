<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Orders/index.ctp */

$temFiltro = $this->request->getQuery('iniciar_busca');
$total = count($pedidos);
$tipos = ['N' => __('Normal'), 'E' => __('Bonificação de Inscrição'), 'B' => __('Bonificação por Meta')];
?>

<div class="ss-container ss-page">
    <div class="ss-layout">

        <?= $this->element('navbar-side-pedidos') ?>

        <div>
            <header class="ss-page-header">
                <div class="ss-page-header-main">
                    <ol class="ss-breadcrumb">
                        <li><?= __('Gerenciar') ?></li>
                        <li><?= __('Pedidos da loja') ?></li>
                    </ol>
                    <h1 class="ss-page-title"><?= __('Pedidos da loja') ?></h1>
                    <p class="ss-page-subtitle">
                        <?= $temFiltro
                            ? __n('{0} pedido encontrado', '{0} pedidos encontrados', $total, $total)
                            : __n('{0} pedido', '{0} pedidos', $total, $total) ?>
                    </p>
                </div>
                <div class="ss-page-actions">
                    <?= $this->Html->link('<i class="fa fa-file-text-o" aria-hidden="true"></i> ' . __('Relatório'), ['action' => 'report'],
                            ['class' => 'btn btn-default btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Relatório de pedidos'),
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
                                <?= $this->Form->select('status', ['M' => __('Aguardando a empresa')] + $this->Pedidos->statusLista(),
                                        ['id' => 'f-status', 'class' => 'form-control', 'empty' => __('Todos os status'),
                                         'value' => $this->request->getQuery('status')]) ?>
                            </div>
                            <div class="form-group">
                                <label for="f-tipo" class="sr-only"><?= __('Tipo') ?></label>
                                <?= $this->Form->select('tipo', $tipos, ['id' => 'f-tipo', 'class' => 'form-control',
                                        'empty' => __('Todos os tipos'), 'value' => $this->request->getQuery('tipo')]) ?>
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

                <?php if ($total): ?>
                <div class="ss-table-wrap">
                    <table class="table ss-table ss-table--stack" id="adjustable">
                        <thead>
                            <tr>
                                <th class="ss-col-id"><?= __('Código') ?></th>
                                <th><?= __('Associado') ?></th>
                                <th><?= __('Data') ?></th>
                                <th><?= __('Fatura') ?></th>
                                <th class="ss-num"><?= __('Total') ?></th>
                                <th><?= __('Status') ?></th>
                                <th class="ss-actions" data-orderable="false"><span class="sr-only"><?= __('Ações') ?></span></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <?php $numero = str_pad($pedido->id, 6, '0', STR_PAD_LEFT); ?>
                            <tr>
                                <td class="ss-col-id" data-label="<?= __('Código') ?>" data-order="<?= $pedido->id ?>">
                                    <span class="ss-id">#<?= $numero ?></span>
                                </td>
                                <td class="ss-cell-primary">
                                    <?= $this->Html->link(h($pedido->usuario->nome), ['action' => 'view', $pedido->id],
                                            ['class' => 'ss-cell-title btn_modal', 'data-title' => __('Pedido #{0}', $numero),
                                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                    <span class="ss-cell-sub">
                                        <?= $this->Usuarios->plano($pedido->usuario) ?>
                                        <?php if ($pedido->tipo != 'N'): ?>
                                            · <?= h($this->Pedidos->tipo($pedido->tipo)) ?>
                                        <?php endif; ?>
                                    </span>
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
                                    <?php if ($pedido->status == 'V'): ?>
                                        <?= $this->Html->link('<i class="fa fa-calculator" aria-hidden="true"></i> ' . __('Informar valores'),
                                                ['action' => 'values', $pedido->id],
                                                ['class' => 'btn btn-sm ss-btn-ghost btn_modal', 'data-tamanho' => 'sm',
                                                 'data-title' => __('Valores do pedido #{0}', $numero),
                                                 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                    <?php elseif ($pedido->status == 'S'): ?>
                                        <?= $this->Html->link('<i class="fa fa-truck" aria-hidden="true"></i> ' . __('Registrar envio'),
                                                ['action' => 'delivery', $pedido->id],
                                                ['class' => 'btn btn-sm ss-btn-ghost btn_modal', 'data-tamanho' => 'sm',
                                                 'data-title' => __('Envio do pedido #{0}', $numero),
                                                 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                    <?php elseif ($pedido->status == 'T'): ?>
                                        <?= $this->Form->postLink('<i class="fa fa-check" aria-hidden="true"></i> ' . __('Entrega feita'),
                                                ['action' => 'finishDelivery', $pedido->id],
                                                ['class' => 'btn btn-sm ss-btn-ghost', 'escape' => false]) ?>
                                    <?php endif; ?>
                                    <?= $this->Html->link('<i class="fa fa-file-text-o" aria-hidden="true"></i>',
                                            ['controller' => 'Invoices', 'action' => 'index', '?' => ['pedido' => $pedido->id, 'iniciar_busca' => 'true']],
                                            ['class' => 'btn btn-sm ss-btn-ghost ss-btn-icon', 'title' => __('Faturas do pedido'),
                                             'aria-label' => __('Faturas do pedido #{0}', $numero), 'escape' => false]) ?>
                                    <?= $this->Html->link('<i class="fa fa-user" aria-hidden="true"></i>',
                                            ['controller' => 'Users', 'action' => 'view', $pedido->usuario->id],
                                            ['class' => 'btn btn-sm ss-btn-ghost ss-btn-icon btn_modal', 'title' => __('Dados do associado'),
                                             'aria-label' => __('Dados de {0}', $pedido->usuario->nome), 'data-title' => __('Dados do associado'),
                                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                    <?php if ($pedido->status == 'T'): ?>
                                        <?= $this->Form->postLink('<i class="fa fa-ban" aria-hidden="true"></i>',
                                                ['action' => 'cancelDelivery', $pedido->id],
                                                ['confirm' => __('Cancelar o envio do pedido #{0}? Ele volta para a preparação.', $numero),
                                                 'class' => 'btn btn-sm ss-btn-danger-soft ss-btn-icon', 'title' => __('Cancelar envio'),
                                                 'aria-label' => __('Cancelar envio do pedido #{0}', $numero), 'escape' => false]) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="ss-empty">
                    <div class="ss-empty-icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
                    <p class="ss-empty-title"><?= __('Nenhum pedido encontrado') ?></p>
                    <p class="ss-empty-text"><?= __('Ajuste os filtros ou escolha outro status.') ?></p>
                    <?= $this->Html->link(__('Limpar filtros'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
                </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>
