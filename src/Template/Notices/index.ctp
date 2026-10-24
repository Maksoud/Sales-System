<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Notices/index.ctp */

$temFiltro = $this->request->getQuery('iniciar_busca');
$destino   = (string)$this->request->getQuery('planos_id');
$total     = count($avisos);
?>

<div class="ss-container ss-page">
    <div class="ss-layout">

        <?= $this->element('navbar-side-avisos', ['planos' => $planos]) ?>

        <div>
            <header class="ss-page-header">
                <div class="ss-page-header-main">
                    <ol class="ss-breadcrumb">
                        <li><?= __('Gerenciar') ?></li>
                        <li><?= __('Avisos') ?></li>
                    </ol>
                    <h1 class="ss-page-title"><?= __('Avisos') ?></h1>
                    <p class="ss-page-subtitle">
                        <?= $temFiltro
                            ? __n('{0} aviso encontrado', '{0} avisos encontrados', $total, $total)
                            : __n('{0} aviso enviado', '{0} avisos enviados', $total, $total) ?>
                    </p>
                </div>
                <div class="ss-page-actions">
                    <?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('Novo aviso'), ['action' => 'add'],
                            ['class' => 'btn btn-primary btn_modal', 'data-title' => __('Novo aviso'),
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
                                <label for="f-busca" class="sr-only"><?= __('Buscar') ?></label>
                                <?= $this->Form->text('busca', ['id' => 'f-busca', 'class' => 'form-control',
                                        'placeholder' => __('Buscar pelo título'),
                                        'value' => $this->request->getQuery('busca')]) ?>
                            </div>
                            <div class="form-group">
                                <label for="f-mes" class="sr-only"><?= __('Mês') ?></label>
                                <?= $this->MyForm->select_meses('mes', ['id' => 'f-mes', 'class' => 'form-control',
                                        'empty' => __('Qualquer mês'), 'value' => $this->request->getQuery('mes')]) ?>
                            </div>
                            <div class="form-group">
                                <label for="f-ano" class="sr-only"><?= __('Ano') ?></label>
                                <?= $this->MyForm->select_ultimos_anos('ano', ['id' => 'f-ano', 'class' => 'form-control',
                                        'empty' => __('Qualquer ano'), 'value' => $this->request->getQuery('ano')], 2018) ?>
                            </div>
                            <?php if ($destino !== ''): ?><input type="hidden" name="planos_id" value="<?= h($destino) ?>"><?php endif; ?>
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
                                <th><?= __('Aviso') ?></th>
                                <th><?= __('Destino') ?></th>
                                <th><?= __('Enviado') ?></th>
                                <th><?= __('Validade') ?></th>
                                <th><?= __('Status') ?></th>
                                <th class="ss-actions" data-orderable="false"><span class="sr-only"><?= __('Ações') ?></span></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($avisos as $aviso): ?>
                            <tr>
                                <td class="ss-col-id" data-label="<?= __('Código') ?>" data-order="<?= $aviso->id ?>">
                                    <span class="ss-id">#<?= str_pad($aviso->id, 6, '0', STR_PAD_LEFT) ?></span>
                                </td>
                                <td class="ss-cell-primary">
                                    <?= $this->Html->link(h($aviso->title), ['action' => 'view', $aviso->id],
                                            ['class' => 'ss-cell-title btn_modal', 'data-title' => __('Aviso'),
                                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                    <?php $resumo = $this->Avisos->resumo($aviso); ?>
                                    <span class="ss-cell-sub ss-truncate" title="<?= h($resumo) ?>">
                                        <?php if ($aviso->banner): ?>
                                            <i class="fa fa-picture-o fa-fw" aria-hidden="true" title="<?= __('Com imagem') ?>"></i><span class="sr-only"><?= __('Com imagem.') ?></span>
                                        <?php endif; ?>
                                        <?= h($resumo) ?>
                                    </span>
                                </td>
                                <td data-label="<?= __('Destino') ?>" data-order="<?= (int)$aviso->planos_id ?>">
                                    <?= $this->Avisos->destino($aviso) ?>
                                </td>
                                <td data-label="<?= __('Enviado') ?>" data-order="<?= $aviso->created->format('YmdHi') ?>">
                                    <?= $this->MyHtml->tinyDate($aviso->created) ?>
                                </td>
                                <td data-label="<?= __('Validade') ?>" data-order="<?= $aviso->validade ? $aviso->validade->format('Ymd') : '99999999' ?>">
                                    <?= $aviso->validade ? $this->MyHtml->tinyDate($aviso->validade) : '<span class="ss-muted">' . __('Sem validade') . '</span>' ?>
                                </td>
                                <td data-label="<?= __('Status') ?>">
                                    <?= $this->Avisos->statusLabel($aviso) ?>
                                </td>
                                <td class="ss-actions">
                                    <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>',
                                            ['action' => 'edit', $aviso->id],
                                            ['class' => 'btn btn-sm ss-btn-ghost ss-btn-icon btn_modal', 'title' => __('Editar'),
                                             'aria-label' => __('Editar {0}', $aviso->title), 'data-title' => __('Editar aviso'),
                                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i>',
                                            ['action' => 'delete', $aviso->id],
                                            ['confirm' => __('Excluir o aviso "{0}"? Esta ação não pode ser desfeita.', $aviso->title),
                                             'class' => 'btn btn-sm ss-btn-danger-soft ss-btn-icon', 'title' => __('Excluir'),
                                             'aria-label' => __('Excluir {0}', $aviso->title), 'escape' => false]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="ss-empty">
                    <div class="ss-empty-icon"><i class="fa fa-bell-o" aria-hidden="true"></i></div>
                    <?php if ($temFiltro): ?>
                        <p class="ss-empty-title"><?= __('Nenhum aviso encontrado') ?></p>
                        <p class="ss-empty-text"><?= __('Ajuste os filtros ou envie um novo aviso.') ?></p>
                        <?= $this->Html->link(__('Limpar filtros'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
                    <?php else: ?>
                        <p class="ss-empty-title"><?= __('Nenhum aviso enviado') ?></p>
                        <p class="ss-empty-text"><?= __('Os avisos aparecem no sino do cabeçalho de quem recebe.') ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>
