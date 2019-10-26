<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Pages/Users/index.ctp */
?>

<div class="container-fluid noPadding">

    <?= $this->element('navbar-side-system') ?>
    
    <div class="col-xs-12 col-sm-9 col-md-10">
        <div class="no-padding-lat">
            <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Usuarios', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Novo Usuário']) ?></div>
            <h3 class="page-header top-20"><?= __('Usuários') ?></h3>
        </div>
        
        <?= $this->element('msg-alert') ?>
        
        <div class="row form-busca bottom-10">
            <div class="col-md-12">
                <?=$this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']);?>    
                <?=$this->Form->text('nome', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Digite o nome ou login', 'value' => @$this->request->query['nome']]);?>
                <?=$this->Form->text('patrocinador', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Digite o patrocinador', 'value' => @$this->request->query['patrocinador']]);?>
                <?=$this->Form->select('planos_id', [3 => __('Super Master'), 
                                                     4 => __('Master'), 
                                                     5 => __('VIP')
                                                    ], ['class' => 'form-control', 'label' => false, 'empty' => '- plano -', 'value' => @$this->request->query['planos_id']]);?>
                <?=$this->Form->select('status', ['A' => __('Ativo'),
                                                  'P' => __('Pendente'),
                                                  'I' => __('Inativo')
                                                 ], ['class' => 'form-control', 'label' => false, 'empty' => '- status -', 'value' => @$this->request->query['status']]);?> 
                <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                <?=$this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> Listar Todos', ['action' => 'index'], ['class'=>'btn btn-default', 'escape' => false]);?>
                <?=$this->Form->end();?>        
            </div>
        </div>
        
        <div class="scrolling bottom-40 col-xs-12 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="text-nowrap"><?= __('Data de Cadastro') ?></th>
                        <th class="text-nowrap" style="width: 1%"><?= __('Foto') ?></th>
                        <th class="text-nowrap"><?= __('Nome') ?></th>
                        <th class="text-nowrap"><?= __('Útimo Acesso') ?></th>
                        <th class="text-nowrap"><?= __('Usuário') ?></th>
                        <th class="text-nowrap"><?= __('Plano') ?></th>
                        <th class="text-nowrap"><?= __('Status') ?></th>
                        <th class="text-center"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $this->MyHtml->date('2019-09-23') ?></td>
                        <td><?=$this->Html->image('usuarios/img.jpg', ['class' => 'img-responsive img-circle', 'style' => 'height: 40px; width: 40px;']);?></td>
                        <td><?= 'Nome do Usuário' ?></td>
                        <td><?= $this->MyHtml->date('2019-09-23') ?></td>
                        <td><?= 'Login do Usuário' ?></td>
                        <td><?= 'Descrição do Plano' ?></td>
                        <td><?= 'Ativo' ?></td>
                        <td class="col-xs-1">
                            <?= $this->Html->link('<i class="fa fa-eye"></i> Ver/Editar', ['controller' => 'Usuarios', 'action' => 'edit'], ['class' => 'top-5 btn btn-default btn-block btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Dados do Cadastro', 'title' => 'Visualizar / Editar', 'aria-hidden' => true, 'escape' => false]) ?>
                            <?= $this->Html->link('<i class="fa fa-usd"></i> Mudar Plano', ['controller' => 'Usuarios', 'action' => 'mudar_plano'], ['class' => 'top-5 btn btn-default btn-block btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Selecione um plano', 'title' => 'Mudar Plano do Usuário', 'aria-hidden' => true, 'escape' => false]) ?>
                            <div class="clearfix"></div>
                            <?= $this->Form->postLink('<i class="fa fa-trash"></i> Apagar', ['controller' => 'Usuarios', 'action' => 'delete'], ['confirm' => 'Você tem certeza que deseja excluir o registro?', 'class' => 'top-5 btn btn-danger btn-block', 'title' => 'Excluir', 'aria-hidden' => true, 'escape' => false]) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</div>