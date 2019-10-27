<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Pages/Regions/index.ctp */

$capitais_do_nordeste = ['Maranhão'            => 'São Luís',
                         'Piauí'               => 'Teresina',
                         'Ceará'               => 'Fortaleza',
                         'Rio Grande do Norte' => 'Natal',
                         'Paraíba'             => 'João Pessoa',
                         'Pernambuco'          => 'Recife',
                         'Alagoas'             => 'Maceió',
                         'Sergipe'             => 'Aracaju',
                         'Bahia'               => 'Salvador',
                        ];

?>
<div class="container-fluid noPadding">

	<?= $this->element('navbar-side-system') ?>
    
    <div class="col-xs-12 col-sm-9 col-md-10">
        <div class="no-padding-lat">
            <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Regions', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Nova Região')]) ?></div>
            <h3 class="page-header top-20"><?= __('Regiões') ?></h3>
        </div>
        
        <?= $this->element('msg-alert') ?>
        
        <div class="row form-busca bottom-10">
            <div class="col-md-12">
                <?=$this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']);?>    
                <?=$this->Form->text('title', ['class' => 'form-control', 'label' => false, 'placeholder' => __('Digite o nome do associado'), 'value' => @$this->request->query['title']]);?> 
                <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?></button>
                <?=$this->Html->link(('<i class="fa fa-list" aria-hidden="true"></i> '.__('Listar Todos')), ['action' => 'index'], ['class'=>'btn btn-default', 'escape' => false]);?>
                <?=$this->Form->end();?>        
            </div>
        </div>
        
        <div class="scrolling bottom-40 col-xs-12 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="text-nowrap"><?= __('#') ?></th>
                        <th class="text-nowrap"><?= __('Data de Cadastro') ?></th>
                        <th class="text-nowrap"><?= __('Data de Modificação') ?></th>
                        <th class="text-nowrap"><?= __('Descrição') ?></th>
                        <th class="text-nowrap"><?= __('Exclusiva') ?></th>
                        <th class="text-nowrap"><?= __('Cidades Vinculadas') ?></th>
                        <th class="text-center"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= str_pad(1234, 6, '0', STR_PAD_LEFT) ?></td>
                        <td><?= $this->MyHtml->date('2019-08-23') ?></td>
                        <td><?= $this->MyHtml->date('2019-08-23') ?></td>
                        <td><?= __('Nordeste') ?></td>
                        <td><?= __('Sim') ?></td>
                        <td><?= implode(', ', array_values($capitais_do_nordeste)); ?></td>
                        <td class="col-xs-1">
                            <?= $this->Html->link(('<i class="fa fa-eye"></i> '.__('Ver/Editar')), ['controller' => 'Regions', 'action' => 'edit', 1234], ['class' => 'top-5 btn btn-default btn-block btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar / Editar'), 'aria-hidden' => true, 'escape' => false]) ?>
                            <div class="clearfix"></div>
                            <?= $this->Form->postLink(('<i class="fa fa-trash"></i> '.__('Apagar')), ['controller' => 'Regions', 'action' => 'delete', 1234], ['confirm' => __('Você tem certeza que deseja excluir o registro?'), 'class' => 'top-5 btn btn-danger btn-block', 'title' => __('Excluir'), 'aria-hidden' => true, 'escape' => false]) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>