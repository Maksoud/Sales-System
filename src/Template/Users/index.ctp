<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/index.ctp */

$temFiltro = $this->request->getQuery('iniciar_busca');
$total = count($usuarios);
$vazio = '<span class="ss-muted">—</span>';
?>

<div class="ss-container ss-page">
    <div class="ss-layout">

        <?= $this->element('navbar-side-system') ?>

        <div>
            <header class="ss-page-header">
                <div class="ss-page-header-main">
                    <ol class="ss-breadcrumb">
                        <li><?= __('Sistema') ?></li>
                        <li><?= __('Usuários') ?></li>
                    </ol>
                    <h1 class="ss-page-title"><?= __('Usuários') ?></h1>
                    <p class="ss-page-subtitle">
                        <?= $temFiltro
                            ? __n('{0} usuário encontrado', '{0} usuários encontrados', $total, $total)
                            : __n('{0} usuário cadastrado', '{0} usuários cadastrados', $total, $total) ?>
                    </p>
                </div>
                <div class="ss-page-actions">
                    <?= $this->Html->link('<i class="fa fa-user-plus" aria-hidden="true"></i> ' . __('Novo usuário'), ['action' => 'add'],
                            ['class' => 'btn btn-primary btn_modal', 'data-title' => __('Novo usuário'),
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
                                <label for="f-nome" class="sr-only"><?= __('Nome ou login') ?></label>
                                <?= $this->Form->text('nome', ['id' => 'f-nome', 'class' => 'form-control',
                                        'placeholder' => __('Buscar por nome ou login'),
                                        'value' => $this->request->getQuery('nome')]) ?>
                            </div>
                            <div class="form-group">
                                <label for="f-patrocinador" class="sr-only"><?= __('Patrocinador') ?></label>
                                <?= $this->Form->text('patrocinador', ['id' => 'f-patrocinador', 'class' => 'form-control',
                                        'placeholder' => __('Patrocinador'),
                                        'value' => $this->request->getQuery('patrocinador')]) ?>
                            </div>
                            <div class="form-group">
                                <label for="f-plano" class="sr-only"><?= __('Plano') ?></label>
                                <?= $this->Form->select('planos_id', $planos,
                                        ['id' => 'f-plano', 'class' => 'form-control', 'empty' => __('Todos os planos'),
                                         'value' => $this->request->getQuery('planos_id')]) ?>
                            </div>
                            <div class="form-group">
                                <label for="f-status" class="sr-only"><?= __('Status') ?></label>
                                <?= $this->Form->select('status', $this->Usuarios->statusLista(),
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
                                <th><?= __('Usuário') ?></th>
                                <th><?= __('Plano') ?></th>
                                <th><?= __('Patrocinador') ?></th>
                                <th><?= __('Cadastro') ?></th>
                                <th><?= __('Status') ?></th>
                                <th class="ss-actions" data-orderable="false"><span class="sr-only"><?= __('Ações') ?></span></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td class="ss-col-id" data-label="<?= __('Código') ?>" data-order="<?= $usuario->id ?>">
                                    <span class="ss-id">#<?= str_pad($usuario->id, 6, '0', STR_PAD_LEFT) ?></span>
                                </td>
                                <td class="ss-cell-primary">
                                    <div class="ss-cell-media">
                                        <?= $this->Html->image('usuarios/' . $usuario->foto, ['class' => 'ss-avatar ss-avatar--sm', 'alt' => '']) ?>
                                        <div>
                                            <?= $this->Html->link(h($usuario->nome), ['action' => 'edit', $usuario->id],
                                                    ['class' => 'ss-cell-title btn_modal', 'data-title' => __('Dados do cadastro'),
                                                     'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                            <span class="ss-cell-sub"><?= h($usuario->login) ?> · <?= h($usuario->cidade) ?>/<?= h($usuario->estado) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="<?= __('Plano') ?>" data-order="<?= (int)$usuario->planos_id ?>">
                                    <?= $this->Usuarios->plano($usuario) ?>
                                </td>
                                <td data-label="<?= __('Patrocinador') ?>">
                                    <?= $usuario->Patrocinador ? h($usuario->Patrocinador->nome) : $vazio ?>
                                </td>
                                <td data-label="<?= __('Cadastro') ?>" data-order="<?= $usuario->created->format('Ymd') ?>">
                                    <?= $this->MyHtml->tinyDate($usuario->created) ?>
                                </td>
                                <td data-label="<?= __('Status') ?>">
                                    <?= $this->Usuarios->statusLabel($usuario->status) ?>
                                </td>
                                <td class="ss-actions">
                                    <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>',
                                            ['action' => 'edit', $usuario->id],
                                            ['class' => 'btn btn-sm ss-btn-ghost ss-btn-icon btn_modal', 'title' => __('Editar'),
                                             'aria-label' => __('Editar {0}', $usuario->nome), 'data-title' => __('Dados do cadastro'),
                                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                    <?php if (in_array($usuario->planos_id, [3, 4, 5])): ?>
                                        <?= $this->Html->link('<i class="fa fa-level-up" aria-hidden="true"></i>',
                                                ['action' => 'changePlan', $usuario->id],
                                                ['class' => 'btn btn-sm ss-btn-ghost ss-btn-icon btn_modal', 'title' => __('Mudar plano'),
                                                 'aria-label' => __('Mudar plano de {0}', $usuario->nome), 'data-tamanho' => 'sm',
                                                 'data-title' => __('Mudar plano'), 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                                    <?php endif; ?>
                                    <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i>',
                                            ['action' => 'delete', $usuario->id],
                                            ['confirm' => __('Excluir o usuário {0}? Esta ação não pode ser desfeita.', $usuario->nome),
                                             'class' => 'btn btn-sm ss-btn-danger-soft ss-btn-icon', 'title' => __('Excluir'),
                                             'aria-label' => __('Excluir {0}', $usuario->nome), 'escape' => false]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="ss-empty">
                    <div class="ss-empty-icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                    <p class="ss-empty-title"><?= __('Nenhum usuário encontrado') ?></p>
                    <p class="ss-empty-text"><?= __('Ajuste os filtros ou cadastre um novo.') ?></p>
                    <?= $this->Html->link(__('Limpar filtros'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
                </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>
