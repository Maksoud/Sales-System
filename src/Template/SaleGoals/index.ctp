<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Pages/SaleGoals/index.ctp */
?>

<div class="container-fluid noPadding">

    <?= $this->element('navbar-side-system') ?>
    
    <div class="col-xs-12 col-sm-9 col-md-10">
        <div class="no-padding-lat">
            <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'SaleGoals', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => __('Nova Meta')]) ?></div>
            <h3 class="page-header top-20"><?= __('Metas') ?></h3>
        </div>
        
        <?= $this->element('msg-alert') ?>
        
        <div class="scrolling bottom-40 col-xs-12 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="text-nowrap width-50"><?= __('#') ?></th>
                        <th><?= __('Descrição') ?></th>
                        <th class="col-xs-1"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $planosMeta   = \App\Lib\DemoData::planos();
                        $produtosMeta = \App\Lib\DemoData::produtosLista();
                    ?>
                    <?php foreach ($data as $meta): ?>
                        <?php
                            $de     = $planosMeta[$meta->de_planos_id];
                            $ganho  = $meta->qtganha . ' ' . $produtosMeta[$meta->bonificacao_produtos_id];
                        ?>
                        <tr>
                            <td><?= str_pad($meta->id, 6, '0', STR_PAD_LEFT) ?></td>
                            <td style="white-space: normal">
                                <?php if ($meta->tipo == 'I'): ?>
                                    <?php $para = $planosMeta[$meta->para_planos_id]; ?>
                                    <i class="fa fa-users" aria-hidden="true" title="<?= __('Meta de Indicações') ?>"></i>
                                    <?= __('O') ?> <strong title="<?= h($de->title) ?>"><?= h($de->slug) ?></strong> <?= __('ganha') ?> <strong><?= h($ganho) ?></strong>
                                    <?= __('ao indicar') ?> <strong><?= $meta->meta ?> <?= __('novos') ?> <span title="<?= h($para->title) ?>"><?= h($para->slug) ?></span></strong>
                                    <?= __('por meta de') ?> <strong><?= __('INDICAÇÕES DIRETAS') ?></strong>
                                <?php else: ?>
                                    <i class="fa fa-handshake-o fa-fw" aria-hidden="true" title="<?= __('Meta de Vendas') ?>"></i>
                                    <?= __('O') ?> <strong title="<?= h($de->title) ?>"><?= h($de->slug) ?></strong> <?= __('ganha') ?> <strong><?= h($ganho) ?></strong>
                                    <?= __('ao comprar') ?> <strong><?= $meta->meta ?> <?= h($produtosMeta[$meta->produtos_id]) ?></strong>
                                    <?= __('por meta de') ?> <strong><?= __('VENDAS') ?></strong>
                                <?php endif; ?>
                            </td>
                            <td class="col-xs-1">
                                <?= $this->Html->link(('<i class="fa fa-eye"></i> '.__('Ver/Editar')), ['controller' => 'SaleGoals', 'action' => 'edit', $meta->id], ['class' => 'top-5 btn btn-default btn-block btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar / Editar'), 'aria-hidden' => true, 'escape' => false]) ?>
                                <div class="clearfix"></div>
                                <?= $this->Form->postLink(('<i class="fa fa-trash"></i> '.__('Apagar')), ['controller' => 'SaleGoals', 'action' => 'delete', $meta->id], ['confirm' => __('Você tem certeza que deseja excluir o registro?'), 'class' => 'top-5 btn btn-danger btn-block', 'title' => __('Excluir'), 'aria-hidden' => true, 'escape' => false]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        
            <div class="panel-heading" style="font-size: 11px;">
                <strong><?= __('Legenda:') ?></strong><br />
                <span><i class="fa fa-users" aria-hidden="true" title="<?= __('Meta de Indicações'); ?>"></i> <?= __('Meta de Indicações') ?> </span><br>
                <span><i class="fa fa-handshake-o fa-fw" aria-hidden="true" title="<?= __('Meta de Vendas'); ?>"></i> <?= __('Meta de Vendas') ?></span><br>
            </div>
        </div>
    </div>