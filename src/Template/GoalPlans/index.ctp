<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/GoalPlans/index.ctp */

//Dev e Admin não são planos de venda
$planos = array_filter($data, function ($plano) { return !in_array($plano->id, [1, 2]); });
$total = count($planos);
?>

<div class="ss-container ss-page">
    <div class="ss-layout">

        <?= $this->element('navbar-side-system') ?>

        <div>
            <header class="ss-page-header">
                <div class="ss-page-header-main">
                    <ol class="ss-breadcrumb">
                        <li><?= __('Sistema') ?></li>
                        <li><?= __('Planos') ?></li>
                    </ol>
                    <h1 class="ss-page-title"><?= __('Planos') ?></h1>
                    <p class="ss-page-subtitle"><?= __n('{0} plano cadastrado', '{0} planos cadastrados', $total, $total) ?></p>
                </div>
                <div class="ss-page-actions">
                    <?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('Novo plano'), ['action' => 'add'],
                            ['class' => 'btn btn-primary btn_modal', 'data-title' => __('Novo plano'),
                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                </div>
            </header>

            <?= $this->element('msg-alert') ?>

            <?php if ($total): ?>
            <div class="ss-grid-auto">
                <?php foreach ($planos as $plano): ?>
                    <?php $produto = $plano->produtos_id && isset($produtos[$plano->produtos_id]) ? $produtos[$plano->produtos_id] : null; ?>
                    <section class="ss-card">
                        <header class="ss-card-header">
                            <div>
                                <h2 class="ss-card-title"><?= h($plano->title) ?></h2>
                                <p class="ss-card-subtitle">
                                    <span class="ss-id">#<?= str_pad($plano->id, 6, '0', STR_PAD_LEFT) ?></span>
                                </p>
                            </div>
                            <span class="ss-plan ss-plan--<?= (int)$plano->id ?>"><?= h($plano->slug) ?></span>
                        </header>
                        <div class="ss-card-body">
                            <dl class="ss-dl ss-dl--grid">
                                <div>
                                    <dt><?= __('Taxa de inscrição') ?></dt>
                                    <dd>
                                        <?php if ($plano->taxa > 0): ?>
                                            <span class="ss-money"><?= $this->Number->currency($plano->taxa, 'BRL') ?></span>
                                        <?php else: ?>
                                            <span class="ss-muted"><?= __('Sem taxa') ?></span>
                                        <?php endif; ?>
                                    </dd>
                                </div>
                                <div>
                                    <dt><?= __('Bonificação') ?></dt>
                                    <dd>
                                        <?php if ($produto): ?>
                                            <span class="ss-num"><?= $this->Number->format($plano->qtprodutos ?: 1) ?></span> ×
                                            <?= $this->Html->link(h($produto->title), ['controller' => 'Products', 'action' => 'view', $produto->id],
                                                    ['class' => 'btn_modal', 'data-title' => __('Produto'),
                                                     'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                        <?php else: ?>
                                            <span class="ss-muted">—</span>
                                        <?php endif; ?>
                                    </dd>
                                </div>
                                <div>
                                    <dt><?= __('Meta mínima de vendas') ?></dt>
                                    <dd><span class="ss-muted">—</span></dd>
                                </div>
                                <div>
                                    <dt><?= __('Cadastro') ?></dt>
                                    <dd><?= $this->MyHtml->date($plano->created) ?></dd>
                                </div>
                            </dl>
                        </div>
                        <footer class="ss-card-footer ss-spread">
                            <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i> ' . __('Editar'),
                                    ['action' => 'edit', $plano->id],
                                    ['class' => 'btn btn-sm ss-btn-ghost btn_modal', 'data-title' => __('Editar plano'),
                                     'aria-label' => __('Editar {0}', $plano->title),
                                     'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                            <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i>',
                                    ['action' => 'delete', $plano->id],
                                    ['confirm' => __('Excluir o plano {0}? Esta ação não pode ser desfeita.', $plano->title),
                                     'class' => 'btn btn-sm ss-btn-danger-soft ss-btn-icon', 'title' => __('Excluir'),
                                     'aria-label' => __('Excluir {0}', $plano->title), 'escape' => false]) ?>
                        </footer>
                    </section>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <section class="ss-card">
                <div class="ss-empty">
                    <div class="ss-empty-icon"><i class="fa fa-server" aria-hidden="true"></i></div>
                    <p class="ss-empty-title"><?= __('Nenhum plano cadastrado') ?></p>
                    <p class="ss-empty-text"><?= __('Cadastre o primeiro plano de venda.') ?></p>
                </div>
            </section>
            <?php endif; ?>
        </div>
    </div>
</div>
