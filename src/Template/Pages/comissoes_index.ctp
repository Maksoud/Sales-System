<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Pages/SaleCommissions/index.ctp */
?>

<div class="container-fluid noPadding">

    <?= $this->element('navbar-side-system') ?>
    
    <div class="col-xs-12 col-sm-9 col-md-10">
        <div class="no-padding-lat">
            <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Pages', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Nova Comissão']) ?></div>
            <h3 class="page-header top-20"><?= __('Comissões') ?></h3>
        </div>
        
        <?= $this->element('msg-alert') ?>
        
        <div class="row form-busca bottom-10">
            <div class="col-md-12">
                <?=$this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']);?>
                <?=$this->Form->text('valor', ['class' => 'form-control valuemask', 'label' => false, 'placeholder' => 'Digite um valor (Ex. 4.950,00)', 'value' => @$this->request->query['valor']]);?> 
                <?=$this->Form->select('de_planos_id', [3 => 'Super Master', 
                                                        4 => 'Master', 
                                                        5 => 'VIP'
                                                       ], ['class' => 'form-control', 'label' => false, 'empty' => '- de -', 'value' => @$this->request->query['de_planos_id']]);?> 
                <?=$this->Form->select('para_planos_id', [3 => 'Super Master', 
                                                          4 => 'Master', 
                                                          5 => 'VIP'
                                                         ], ['class' => 'form-control', 'label' => false, 'empty' => '- para -', 'value' => @$this->request->query['para_planos_id']]);?> 
                <?=$this->Form->select('tipo', ['ID' => 'Indicação Direta',
                                                'II' => 'Indicação Indireta',
                                                'IM' => 'Indicação Multinível',
                                                'VD' => 'Venda Direta',
                                                'VI' => 'Venda Indireta',
                                                'VM' => 'Venda Multinível'
                                               ], ['class' => 'form-control', 'label' => false, 'empty' => '- tipo -', 'value' => @$this->request->query['tipo']]);?> 
                <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?></button>
                <?=$this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> Listar Todos', ['action' => 'index'], ['class'=>'btn btn-default', 'escape' => false]);?>
                <?=$this->Form->end();?>        
            </div>
        </div>
        
        <div class="scrolling bottom-40 col-xs-12 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="width-50"><?= __('#') ?></th>
                        <th><?= __('Descrição') ?></th>
                        <th class="col-xs-1"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= str_pad(1234, 6, '0', STR_PAD_LEFT) ?></td>
                        <td style="white-space: normal">
                            <?= '<i class="fa fa-diamond" title="Produto Vinculado"></i>' ?>
                            <?= 'Descrição da Comissão' ?>
                        </td>
                        <td class="col-xs-1">
                            <?= $this->Html->link('<i class="fa fa-eye"></i> Ver/Editar', ['controller' => 'Pages', 'action' => 'edit'], ['class' => 'top-5 btn btn-default btn-block btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Dados do Cadastro', 'title' => 'Visualizar / Editar', 'aria-hidden' => true, 'escape' => false]) ?>
                            <div class="clearfix"></div>
                            <?= $this->Form->postLink('<i class="fa fa-trash"></i> Apagar', ['controller' => 'Pages', 'action' => 'delete'], ['confirm' => 'Você tem certeza que deseja excluir o registro?', 'class' => 'top-5 btn btn-danger btn-block', 'title' => 'Excluir', 'aria-hidden' => true, 'escape' => false]) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        
            <div class="panel-heading" style="font-size: 11px;">
                <strong><?= __('Legenda:') ?></strong><br />
                <span><i class="fa fa-exchange" aria-hidden="true" title="Indicação Direta"></i> <?= __('Indicação Direta') ?></span><br>
                <span><i class="fa fa-share-alt" aria-hidden="true" title="Indicação Indireta"></i> <?= __('Indicação Indireta') ?></span><br>
                <span><i class="fa fa-code-fork" aria-hidden="true" title="Bonificações Multiníveis"></i> <?= __('Indicação Multinível') ?></span><br>
                <span><i class="fa fa-cube" aria-hidden="true" title="Venda Direta"></i> <?= __('Venda Direta') ?></span><br>
                <span><i class="fa fa-cubes" aria-hidden="true" title="Venda Indireta"></i> <?= __('Venda Indireta') ?></span><br>
                <span><i class="fa fa-sitemap" aria-hidden="true" title="Comissões Multiníveis"></i> <?= __('Venda Multinível') ?></span><br>
                <span><i class="fa fa-diamond" aria-hidden="true" title="Produto Vinculado"></i> <?= __('Produto Vinculado') ?></span>
            </div>
        </div>
        
    </div>

</div>