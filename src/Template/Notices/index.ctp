<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Notices/index.ctp */
?>

<div class="container-fluid">
    <div class="col-xs-12">
        <div class="no-padding-lat">
            <div class="pull-right top-20">
                <?= $this->Html->link('<i class="fa fa-plus-circle" aria-hidden="true"></i> ' . __('Incluir'), ['action' => 'add'], ['class' => 'btn btn-primary btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Novo Aviso'), 'escape' => false]) ?>
            </div>
            <h3 class="page-header top-20"><?= __('Avisos') ?></h3>
        </div>

        <?= $this->element('msg-alert') ?>

        <div class="row form-busca bottom-10">
            <div class="col-xs-12">
                <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']) ?>
                    <?= $this->Form->text('busca', ['class' => 'form-control', 'placeholder' => __('Título do aviso...'), 'value' => $this->request->getQuery('busca')]) ?>
                    <?= $this->MyForm->select_ultimos_anos('ano', ['class' => 'form-control', 'empty' => __('- ano -'), 'value' => $this->request->getQuery('ano')], 2018) ?>
                    <?= $this->MyForm->select_meses('mes', ['class' => 'form-control', 'empty' => __('- mês -'), 'value' => $this->request->getQuery('mes')]) ?>
                    <?= $this->Form->select('planos_id', ['todos' => __('Enviados para todos')] + $planos, ['class' => 'form-control', 'empty' => __('- destino -'), 'value' => $this->request->getQuery('planos_id')]) ?>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?></button>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('Listar Todos'), ['action' => 'index'], ['class' => 'btn btn-default', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <div class="scrolling bottom-40 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="text-nowrap"><?= __('Data de Cadastro') ?></th>
                        <th class="text-nowrap"><?= __('Título do Aviso') ?></th>
                        <th class="text-nowrap"><?= __('Destino') ?></th>
                        <th class="text-nowrap"><?= __('Validade') ?></th>
                        <th class="text-nowrap"><?= __('Status') ?></th>
                        <th class="text-center"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($avisos as $aviso): ?>
                        <tr>
                            <td data-order="<?= $aviso->created->format('YmdHi') ?>"><?= $this->MyHtml->time($aviso->created) ?></td>
                            <td>
                                <?= $aviso->banner ? '<i class="fa fa-file-image-o" aria-hidden="true" title="' . __('Com imagem') . '"></i> ' : '' ?>
                                <?= h($aviso->title) ?>
                            </td>
                            <td><?= $aviso->plano ? h($aviso->plano->title) : __('Todos') ?></td>
                            <td><?= $aviso->validade ? $this->MyHtml->date($aviso->validade) : __('Sem validade') ?></td>
                            <td>
                                <?= $aviso->ativo ? '<span class="label label-success">' . __('Ativo') . '</span>' : '<span class="label label-danger">' . __('Vencido') . '</span>' ?>
                            </td>
                            <td class="col-xs-1 text-nowrap">
                                <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $aviso->id], ['class' => 'btn btn-default btn_modal', 'data-loading-text' => '...', 'data-title' => h($aviso->title), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $aviso->id], ['class' => 'btn btn-default btn_modal', 'data-loading-text' => '...', 'data-title' => __('Editar Aviso'), 'title' => __('Editar'), 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $aviso->id], ['confirm' => __('Você tem certeza que deseja excluir o aviso?'), 'class' => 'btn btn-danger', 'title' => __('Excluir'), 'escape' => false]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
