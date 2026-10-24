<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Regions/index.ctp */

$temFiltro = $this->request->getQuery('iniciar_busca');
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
                        <li><?= __('Regiões') ?></li>
                    </ol>
                    <h1 class="ss-page-title"><?= __('Regiões') ?></h1>
                    <p class="ss-page-subtitle">
                        <?= $temFiltro
                            ? __n('{0} região encontrada', '{0} regiões encontradas', $total, $total)
                            : __n('{0} região cadastrada', '{0} regiões cadastradas', $total, $total) ?>
                    </p>
                </div>
                <div class="ss-page-actions">
                    <?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i> ' . __('Nova região'), ['action' => 'add'],
                            ['class' => 'btn btn-primary btn_modal', 'data-title' => __('Nova região'),
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
                                            'placeholder' => __('Buscar por região, UF ou cidade'),
                                            'value' => $this->request->getQuery('title')]) ?>
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
                                    <th><?= __('Região') ?></th>
                                    <th><?= __('Cidades') ?></th>
                                    <th><?= __('Exclusividade') ?></th>
                                    <th class="ss-hide-xs"><?= __('Cadastro') ?></th>
                                    <th><?= __('Atualização') ?></th>
                                    <th class="ss-actions" data-orderable="false"><span class="sr-only"><?= __('Ações') ?></span></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data as $regiao): ?>
                                <?php
                                    $qtCidades   = count($regiao->cidades);
                                    $responsavel = isset($responsaveis[$regiao->id]) ? $responsaveis[$regiao->id] : null;
                                    $cidades     = implode(', ', $regiao->cidades);
                                ?>
                                <tr>
                                    <td class="ss-col-id" data-label="<?= __('Código') ?>" data-order="<?= $regiao->id ?>">
                                        <span class="ss-id">#<?= str_pad($regiao->id, 6, '0', STR_PAD_LEFT) ?></span>
                                    </td>
                                    <td class="ss-cell-primary">
                                        <?= $this->Html->link(h($regiao->title), ['action' => 'edit', $regiao->id],
                                                ['class' => 'ss-cell-title btn_modal', 'data-title' => __('Editar região'),
                                                 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                        <span class="ss-cell-sub">
                                            <?= h($regiao->uf) ?> · <?= __n('{0} cidade', '{0} cidades', $qtCidades, $qtCidades) ?>
                                        </span>
                                    </td>
                                    <td data-label="<?= __('Cidades') ?>">
                                        <?php if ($qtCidades): ?>
                                            <span><?= h($cidades) ?></span>
                                        <?php else: ?>
                                            <span class="ss-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="<?= __('Exclusividade') ?>">
                                        <?php if ($responsavel): ?>
                                            <span class="ss-cluster">
                                                <span class="ss-nowrap"><?= h($responsavel->nome) ?></span>
                                                <?= $this->Usuarios->plano($responsavel) ?>
                                            </span>
                                        <?php elseif ($regiao->exclusiva == 'Sim'): ?>
                                            <?= __('Exclusiva') ?>
                                        <?php else: ?>
                                            <span class="ss-muted"><?= __('Aberta a todos') ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="ss-hide-xs" data-label="<?= __('Cadastro') ?>" data-order="<?= $regiao->created->format('Ymd') ?>">
                                        <?= $this->MyHtml->tinyDate($regiao->created) ?>
                                    </td>
                                    <td data-label="<?= __('Atualização') ?>" data-order="<?= $regiao->modified->format('Ymd') ?>">
                                        <?= $this->MyHtml->tinyDate($regiao->modified) ?>
                                    </td>
                                    <td class="ss-actions">
                                        <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>',
                                                ['action' => 'edit', $regiao->id],
                                                ['class' => 'btn btn-sm ss-btn-ghost ss-btn-icon btn_modal', 'title' => __('Editar'),
                                                 'aria-label' => __('Editar {0}', $regiao->title), 'data-title' => __('Editar região'),
                                                 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i>',
                                                ['action' => 'delete', $regiao->id],
                                                ['confirm' => __('Excluir a região {0}? Esta ação não pode ser desfeita.', $regiao->title),
                                                 'class' => 'btn btn-sm ss-btn-danger-soft ss-btn-icon', 'title' => __('Excluir'),
                                                 'aria-label' => __('Excluir {0}', $regiao->title), 'escape' => false]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="ss-empty">
                        <div class="ss-empty-icon"><i class="fa fa-globe" aria-hidden="true"></i></div>
                        <?php if ($temFiltro): ?>
                            <p class="ss-empty-title"><?= __('Nenhuma região encontrada') ?></p>
                            <p class="ss-empty-text"><?= __('Ajuste a busca ou cadastre uma nova.') ?></p>
                            <?= $this->Html->link(__('Limpar filtros'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
                        <?php else: ?>
                            <p class="ss-empty-title"><?= __('Nenhuma região cadastrada') ?></p>
                            <p class="ss-empty-text"><?= __('Cadastre a primeira região para organizar a atuação dos associados.') ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </section>

                <div class="ss-note">
                    <span class="ss-note-title"><?= __('Exclusividade') ?></span>
                    <?= __('Só o associado responsável atua numa região exclusiva. Nas demais, qualquer associado atua conforme o plano.') ?>
                </div>
            </div>
        </div>
    </div>
</div>
