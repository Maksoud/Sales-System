<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/index.ctp */
?>

<div class="container-fluid noPadding">

    <?= $this->element('navbar-side-system') ?>

    <div class="col-xs-12 col-sm-9 col-md-10">
        <div class="no-padding-lat">
            <div class="pull-right top-20">
                <?= $this->Html->link('<i class="fa fa-plus-circle" aria-hidden="true"></i> ' . __('Incluir'), ['action' => 'add'], ['class' => 'btn btn-primary btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Novo Usuário'), 'escape' => false]) ?>
            </div>
            <h3 class="page-header top-20"><?= __('Usuários') ?></h3>
        </div>

        <?= $this->element('msg-alert') ?>

        <div class="row form-busca bottom-10">
            <div class="col-xs-12">
                <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']) ?>
                    <?= $this->Form->text('nome', ['class' => 'form-control', 'placeholder' => __('Nome ou login'), 'value' => $this->request->getQuery('nome')]) ?>
                    <?= $this->Form->text('patrocinador', ['class' => 'form-control', 'placeholder' => __('Patrocinador'), 'value' => $this->request->getQuery('patrocinador')]) ?>
                    <?= $this->Form->select('planos_id', $planos, ['class' => 'form-control', 'empty' => __('- plano -'), 'value' => $this->request->getQuery('planos_id')]) ?>
                    <?= $this->Form->select('status', $this->Usuarios->statusLista(), ['class' => 'form-control', 'empty' => __('- status -'), 'value' => $this->request->getQuery('status')]) ?>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?></button>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('Listar Todos'), ['action' => 'index'], ['class' => 'btn btn-default', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <div class="scrolling bottom-40 col-xs-12 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="text-nowrap"><?= __('Cadastro') ?></th>
                        <th class="text-nowrap" style="width: 1%"><?= __('Foto') ?></th>
                        <th class="text-nowrap"><?= __('Nome') ?></th>
                        <th class="text-nowrap"><?= __('Login') ?></th>
                        <th class="text-nowrap"><?= __('Plano') ?></th>
                        <th class="text-nowrap"><?= __('Patrocinador') ?></th>
                        <th class="text-nowrap"><?= __('Último acesso') ?></th>
                        <th class="text-nowrap"><?= __('Status') ?></th>
                        <th class="text-center"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td data-order="<?= $usuario->created->format('YmdHi') ?>"><?= $this->MyHtml->tinyDate($usuario->created) ?></td>
                            <td><?= $this->Html->image('usuarios/' . $usuario->foto, ['class' => 'img-responsive img-circle', 'style' => 'height: 40px; width: 40px;', 'alt' => '']) ?></td>
                            <td><?= h($usuario->nome) ?><br><small class="text-cinza"><?= h($usuario->cidade) ?>/<?= h($usuario->estado) ?></small></td>
                            <td><?= h($usuario->login) ?></td>
                            <td><?= $this->Usuarios->plano($usuario) ?></td>
                            <td><?= $usuario->Patrocinador ? h($usuario->Patrocinador->nome) : '-' ?></td>
                            <td data-order="<?= $usuario->last_login->format('YmdHi') ?>"><small><?= $this->MyHtml->time($usuario->last_login) ?></small></td>
                            <td><?= $this->Usuarios->statusLabel($usuario->status) ?></td>
                            <td class="col-xs-1">
                                <?= $this->Html->link('<i class="fa fa-eye"></i> ' . __('Ver/Editar'), ['action' => 'edit', $usuario->id], ['class' => 'btn btn-default btn-block btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'escape' => false]) ?>
                                <?php if (in_array($usuario->planos_id, [3, 4, 5])): ?>
                                    <?= $this->Html->link('<i class="fa fa-level-up"></i> ' . __('Mudar Plano'), ['action' => 'changePlan', $usuario->id], ['class' => 'top-5 btn btn-default btn-block btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Mudar Plano'), 'escape' => false]) ?>
                                <?php endif; ?>
                                <?= $this->Form->postLink('<i class="fa fa-trash"></i> ' . __('Apagar'), ['action' => 'delete', $usuario->id], ['confirm' => __('Você tem certeza que deseja excluir o registro?'), 'class' => 'top-5 btn btn-danger btn-block', 'escape' => false]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
