<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Products/index.ctp */
?>

<div class="container-fluid noPadding">

    <?= $this->element('navbar-side-system') ?>

    <div class="col-xs-12 col-sm-9 col-md-10">
        <div class="no-padding-lat">
            <div class="pull-right top-20">
                <?= $this->Html->link('<i class="fa fa-plus-circle" aria-hidden="true"></i> ' . __('Incluir'), ['action' => 'add'], ['class' => 'btn btn-primary btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Novo Produto'), 'escape' => false]) ?>
            </div>
            <h3 class="page-header top-20"><?= __('Produtos') ?></h3>
        </div>

        <?= $this->element('msg-alert') ?>

        <div class="row form-busca bottom-10">
            <div class="col-xs-12">
                <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']) ?>
                    <?= $this->Form->text('title', ['class' => 'form-control', 'placeholder' => __('Nome ou descrição'), 'value' => $this->request->getQuery('title')]) ?>
                    <?= $this->Form->select('status', ['A' => __('Ativo'), 'I' => __('Inativo')], ['class' => 'form-control', 'empty' => __('- status -'), 'value' => $this->request->getQuery('status')]) ?>
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
                        <th class="text-nowrap width-50"><?= __('#') ?></th>
                        <th class="text-center width-50"><?= __('Imagem') ?></th>
                        <th class="text-nowrap"><?= __('Produto') ?></th>
                        <th class="text-nowrap"><?= __('Preço') ?></th>
                        <th class="text-nowrap"><?= __('Vendidos') ?></th>
                        <th class="text-nowrap"><?= __('Cadastro') ?></th>
                        <th class="text-nowrap"><?= __('Status') ?></th>
                        <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?= str_pad($produto->id, 6, '0', STR_PAD_LEFT) ?></td>
                            <td><?= $this->Html->image('produtos/' . $produto->imagem, ['class' => 'img-responsive img-circle', 'style' => 'height: 40px; width: 40px;', 'alt' => $produto->title]) ?></td>
                            <td style="white-space: normal">
                                <?= $produto->comissoes ? '<i class="fa fa-sitemap" aria-hidden="true" title="' . __('Gera comissões') . '"></i> ' : '' ?>
                                <?= h($produto->title) ?><br>
                                <small class="text-cinza"><?= h($produto->descricao) ?></small>
                            </td>
                            <td class="text-nowrap" data-order="<?= $produto->valor ?>"><?= $this->Number->currency($produto->valor, 'BRL') ?></td>
                            <td><?= $this->Number->format(isset($vendidos[$produto->id]) ? $vendidos[$produto->id] : 0) ?></td>
                            <td data-order="<?= $produto->created->format('Ymd') ?>"><?= $this->MyHtml->tinyDate($produto->created) ?></td>
                            <td><?= $produto->status == 'A' ? '<span class="label label-success">' . __('Ativo') . '</span>' : '<span class="label label-default">' . __('Inativo') . '</span>' ?></td>
                            <td class="col-xs-1">
                                <?= $this->Html->link('<i class="fa fa-eye"></i> ' . __('Ver/Editar'), ['action' => 'edit', $produto->id], ['class' => 'btn btn-default btn-block btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Produto'), 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="fa fa-trash"></i> ' . __('Apagar'), ['action' => 'delete', $produto->id], ['confirm' => __('Você tem certeza que deseja excluir o registro?'), 'class' => 'top-5 btn btn-danger btn-block', 'escape' => false]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="panel-heading" style="font-size: 11px;">
                <strong><?= __('Legenda:') ?></strong><br>
                <span><i class="fa fa-sitemap" aria-hidden="true"></i> <?= __('Produto que gera comissões na rede') ?></span>
            </div>
        </div>
    </div>

</div>
