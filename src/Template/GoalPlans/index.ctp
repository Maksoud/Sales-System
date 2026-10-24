<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

/* File: src/Template/GoalPlans/index.ctp */
?>

<div class="container-fluid noPadding">

    <?= $this->element('navbar-side-system') ?>
    
    <div class="col-xs-12 col-sm-9 col-md-10">
        <div class="no-padding-lat">
            <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'GoalPlans', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => __('Novo Plano')]) ?></div>
            <h3 class="page-header top-20"><?= __('Planos') ?></h3>
        </div>
        
        <?= $this->element('msg-alert') ?>
        
        <div class="scrolling bottom-40 col-xs-12 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="text-nowrap width-50"><?= __('#') ?></th>
                        <th class="text-nowrap col-xs-1"><?= __('Data de Cadastro') ?></th>
                        <th class="text-nowrap col-xs-1"><?= __('Descrição') ?></th>
                        <th class="text-nowrap col-xs-1"><?= __('Taxa Plano') ?></th>
                        <th class="text-nowrap"><?= __('Produto') ?></th>
                        <th class="text-nowrap col-xs-1"><?= __('Qtd.Produto') ?></th>
                        <th class="text-nowrap col-xs-1"><?= __('Meta de Vendas') ?></th>
                        <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $plano): ?>
                        <?php if (in_array($plano->id, [1, 2])) continue; //Dev e Admin não são planos de venda ?>
                        <?php $produto = $plano->produtos_id ? \App\Lib\DemoData::produto($plano->produtos_id) : null; ?>
                        <tr>
                            <td><?= str_pad($plano->id, 6, '0', STR_PAD_LEFT) ?></td>
                            <td data-order="<?= $plano->created->format('Ymd') ?>"><?= $this->MyHtml->date($plano->created) ?></td>
                            <td><span class="plano<?= $plano->id ?> text-nowrap"><label class="fa"></label> <?= h($plano->title) ?></span></td>
                            <td data-order="<?= $plano->taxa ?>"><?= $plano->taxa > 0 ? $this->Number->currency($plano->taxa, 'BRL') : __('Sem taxa') ?></td>
                            <td><?= $produto ? $this->Html->link(h($produto->title), ['controller' => 'Products', 'action' => 'view', $produto->id], ['class' => 'btn_modal', 'data-title' => __('Visualizar Produto')]) : '-' ?></td>
                            <td><?= $plano->qtprodutos ? $this->Number->format($plano->qtprodutos) : '-' ?></td>
                            <td>-</td>
                            <td class="col-xs-1">
                                <?= $this->Html->link(('<i class="fa fa-eye"></i> '.__('Ver/Editar')), ['controller' => 'GoalPlans', 'action' => 'edit', $plano->id], ['class' => 'top-5 btn btn-default btn-block btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar / Editar'), 'aria-hidden' => true, 'escape' => false]) ?>
                                <div class="clearfix"></div>
                                <?= $this->Form->postLink(('<i class="fa fa-trash"></i> '.__('Apagar')), ['controller' => 'GoalPlans', 'action' => 'delete', $plano->id], ['confirm' => __('Você tem certeza que deseja excluir o registro?'), 'class' => 'top-5 btn btn-danger btn-block', 'title' => __('Excluir'), 'aria-hidden' => true, 'escape' => false]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
</div>