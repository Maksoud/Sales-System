<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Products/index.ctp */

$temFiltro = $this->request->getQuery('iniciar_busca');
$total = count($produtos);
?>

<div class="ss-container ss-page">
    <div class="ss-layout">

        <?= $this->element('navbar-side-system') ?>

        <div>
            <header class="ss-page-header">
                <div class="ss-page-header-main">
                    <ol class="ss-breadcrumb">
                        <li><?= __('Sistema') ?></li>
                        <li><?= __('Produtos') ?></li>
                    </ol>
                    <h1 class="ss-page-title"><?= __('Produtos') ?></h1>
                    <p class="ss-page-subtitle">
                        <?= $temFiltro
                            ? __n('{0} produto encontrado', '{0} produtos encontrados', $total, $total)
                            : __n('{0} produto cadastrado', '{0} produtos cadastrados', $total, $total) ?>
                    </p>
                </div>
                <div class="ss-page-actions">
                    <?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('Novo produto'), ['action' => 'add'],
                            ['class' => 'btn btn-primary btn_modal', 'data-title' => __('Novo produto'),
                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                </div>
            </header>

            <?= $this->element('msg-alert') ?>

            <div class="ss-stack">
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
                                    <label for="f-title" class="sr-only"><?= __('Buscar') ?></label>
                                    <?= $this->Form->text('title', ['id' => 'f-title', 'class' => 'form-control',
                                            'placeholder' => __('Buscar por nome ou descrição'),
                                            'value' => $this->request->getQuery('title')]) ?>
                                </div>
                                <div class="form-group">
                                    <label for="f-status" class="sr-only"><?= __('Status') ?></label>
                                    <?= $this->Form->select('status', $this->Produtos->statusLista(),
                                            ['id' => 'f-status', 'class' => 'form-control', 'empty' => __('Todos os status'),
                                             'value' => $this->request->getQuery('status')]) ?>
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
                                    <th><?= __('Produto') ?></th>
                                    <th class="ss-num"><?= __('Preço') ?></th>
                                    <th class="ss-num"><?= __('Vendidos') ?></th>
                                    <th><?= __('Cadastro') ?></th>
                                    <th><?= __('Status') ?></th>
                                    <th class="ss-actions" data-orderable="false"><span class="sr-only"><?= __('Ações') ?></span></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($produtos as $produto): ?>
                                <?php $qtVendida = isset($vendidos[$produto->id]) ? $vendidos[$produto->id] : 0; ?>
                                <tr>
                                    <td class="ss-col-id" data-label="<?= __('Código') ?>" data-order="<?= $produto->id ?>">
                                        <span class="ss-id">#<?= str_pad($produto->id, 6, '0', STR_PAD_LEFT) ?></span>
                                    </td>
                                    <td class="ss-cell-primary">
                                        <div class="ss-cell-media">
                                            <?= $this->Html->image('produtos/' . $produto->imagem, ['class' => 'ss-thumb', 'alt' => '']) ?>
                                            <div>
                                                <?= $this->Html->link(h($produto->title), ['action' => 'edit', $produto->id],
                                                        ['class' => 'ss-cell-title btn_modal', 'data-title' => __('Editar produto'),
                                                         'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                                <span class="ss-cell-sub">
                                                    <?php if ($produto->comissoes): ?>
                                                        <i class="fa fa-sitemap fa-fw" aria-hidden="true" title="<?= __('Gera comissões na rede') ?>"></i><span class="sr-only"><?= __('Gera comissões na rede.') ?></span>
                                                    <?php endif; ?>
                                                    <?= h($produto->descricao) ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="ss-num" data-label="<?= __('Preço') ?>" data-order="<?= $produto->valor ?>">
                                        <?= $this->Number->currency($produto->valor, 'BRL') ?>
                                    </td>
                                    <td class="ss-num" data-label="<?= __('Vendidos') ?>" data-order="<?= $qtVendida ?>">
                                        <?= $this->Number->format($qtVendida) ?>
                                    </td>
                                    <td data-label="<?= __('Cadastro') ?>" data-order="<?= $produto->created->format('Ymd') ?>">
                                        <?= $this->MyHtml->tinyDate($produto->created) ?>
                                    </td>
                                    <td data-label="<?= __('Status') ?>">
                                        <?= $this->Produtos->statusLabel($produto->status) ?>
                                    </td>
                                    <td class="ss-actions">
                                        <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>',
                                                ['action' => 'edit', $produto->id],
                                                ['class' => 'btn btn-sm ss-btn-ghost ss-btn-icon btn_modal', 'title' => __('Editar'),
                                                 'aria-label' => __('Editar {0}', $produto->title), 'data-title' => __('Editar produto'),
                                                 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i>',
                                                ['action' => 'delete', $produto->id],
                                                ['confirm' => __('Excluir o produto {0}? Esta ação não pode ser desfeita.', $produto->title),
                                                 'class' => 'btn btn-sm ss-btn-danger-soft ss-btn-icon', 'title' => __('Excluir'),
                                                 'aria-label' => __('Excluir {0}', $produto->title), 'escape' => false]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="ss-empty">
                        <div class="ss-empty-icon"><i class="fa fa-cube" aria-hidden="true"></i></div>
                        <p class="ss-empty-title"><?= __('Nenhum produto encontrado') ?></p>
                        <p class="ss-empty-text"><?= __('Ajuste os filtros ou cadastre um novo.') ?></p>
                        <?= $this->Html->link(__('Limpar filtros'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
                    </div>
                    <?php endif; ?>
                </section>

                <div class="ss-note">
                    <span class="ss-note-title"><?= __('Legenda') ?></span>
                    <i class="fa fa-sitemap fa-fw" aria-hidden="true"></i> <?= __('Produto que gera comissões na rede') ?>
                </div>
            </div>
        </div>
    </div>
</div>
