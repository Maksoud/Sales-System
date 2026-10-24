<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/SaleGoals/index.ctp */

$total = count($data);
?>

<div class="ss-container ss-page">
    <div class="ss-layout">

        <?= $this->element('navbar-side-system') ?>

        <div>
            <header class="ss-page-header">
                <div class="ss-page-header-main">
                    <ol class="ss-breadcrumb">
                        <li><?= __('Sistema') ?></li>
                        <li><?= __('Metas') ?></li>
                    </ol>
                    <h1 class="ss-page-title"><?= __('Metas') ?></h1>
                    <p class="ss-page-subtitle"><?= __n('{0} meta cadastrada', '{0} metas cadastradas', $total, $total) ?></p>
                </div>
                <div class="ss-page-actions">
                    <?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('Nova meta'), ['action' => 'add'],
                            ['class' => 'btn btn-primary btn_modal', 'data-title' => __('Nova meta'),
                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                </div>
            </header>

            <?= $this->element('msg-alert') ?>

            <section class="ss-card ss-card--flush">
                <?php if ($total): ?>
                <div class="ss-table-wrap">
                    <table class="table ss-table ss-table--stack" id="adjustable">
                        <thead>
                            <tr>
                                <th class="ss-col-id"><?= __('Código') ?></th>
                                <th><?= __('Meta') ?></th>
                                <th><?= __('Plano') ?></th>
                                <th><?= __('Prêmio') ?></th>
                                <th><?= __('Cadastro') ?></th>
                                <th class="ss-actions" data-orderable="false"><span class="sr-only"><?= __('Ações') ?></span></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data as $meta): ?>
                            <?php
                                $de    = $planos[$meta->de_planos_id];
                                $premio = isset($produtos[$meta->bonificacao_produtos_id]) ? $produtos[$meta->bonificacao_produtos_id] : null;
                                if ($meta->tipo == 'I') {
                                    $para   = $planos[$meta->para_planos_id];
                                    $titulo = __n('Indicar {0} novo {1}', 'Indicar {0} novos {1}', $meta->meta,
                                            $this->Number->format($meta->meta), $para->title);
                                    $tipo   = ['fa-users', __('Meta de indicações diretas')];
                                } else {
                                    $vendido = isset($produtos[$meta->produtos_id]) ? $produtos[$meta->produtos_id] : '';
                                    $titulo = __('Comprar {0} × {1}', $this->Number->format($meta->meta), $vendido);
                                    $tipo   = ['fa-shopping-cart', __('Meta de vendas')];
                                }
                            ?>
                            <tr>
                                <td class="ss-col-id" data-label="<?= __('Código') ?>" data-order="<?= $meta->id ?>">
                                    <span class="ss-id">#<?= str_pad($meta->id, 6, '0', STR_PAD_LEFT) ?></span>
                                </td>
                                <td class="ss-cell-primary">
                                    <?= $this->Html->link(h($titulo), ['action' => 'edit', $meta->id],
                                            ['class' => 'ss-cell-title btn_modal', 'data-title' => __('Editar meta'),
                                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                    <span class="ss-cell-sub">
                                        <i class="fa <?= $tipo[0] ?> fa-fw" aria-hidden="true"></i> <?= $tipo[1] ?>
                                    </span>
                                </td>
                                <td data-label="<?= __('Plano') ?>" data-order="<?= $de->id ?>">
                                    <span class="ss-plan ss-plan--<?= (int)$de->id ?>" title="<?= h($de->title) ?>"><?= h($de->slug) ?></span>
                                </td>
                                <td data-label="<?= __('Prêmio') ?>">
                                    <?php if ($premio): ?>
                                        <span><span class="ss-num"><?= $this->Number->format($meta->qtganha) ?></span> × <?= h($premio) ?></span>
                                    <?php else: ?>
                                        <span class="ss-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="<?= __('Cadastro') ?>" data-order="<?= $meta->created->format('Ymd') ?>">
                                    <?= $this->MyHtml->tinyDate($meta->created) ?>
                                </td>
                                <td class="ss-actions">
                                    <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>',
                                            ['action' => 'edit', $meta->id],
                                            ['class' => 'btn btn-sm ss-btn-ghost ss-btn-icon btn_modal', 'title' => __('Editar'),
                                             'aria-label' => __('Editar {0}', $titulo), 'data-title' => __('Editar meta'),
                                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i>',
                                            ['action' => 'delete', $meta->id],
                                            ['confirm' => __('Excluir a meta "{0}" do plano {1}? Esta ação não pode ser desfeita.', $titulo, $de->title),
                                             'class' => 'btn btn-sm ss-btn-danger-soft ss-btn-icon', 'title' => __('Excluir'),
                                             'aria-label' => __('Excluir {0}', $titulo), 'escape' => false]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="ss-empty">
                    <div class="ss-empty-icon"><i class="fa fa-bullseye" aria-hidden="true"></i></div>
                    <p class="ss-empty-title"><?= __('Nenhuma meta cadastrada') ?></p>
                    <p class="ss-empty-text"><?= __('Cadastre uma meta de indicação ou de venda para premiar os associados.') ?></p>
                </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>
