<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Pages/Regions/add.ctp */

$this->layout = 'ajax';
?>

<?= $this->Form->create('data') ?>

<?php 
    $single = 'col-xs-12';
    $double = 'col-xs-12 col-sm-6';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control form-group';
?>

    <div class="container-fluid">
        <div class="row">
            <div id="ajax-retorno" class="col-xs-12"></div>
        </div>
        
        
        <div class="row">
            <div class="col-xs-12 col-sm-6">
            	<label class="<?= $label ?>"><?= __('Descrição'); ?></label>
                <?= $this->Form->control('title', ['label' => false, 'class' => $input . ' focus', 'required' => true, 'placeholder' => __('Ex.: São Paulo (011)')]) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <label class="<?= $label ?>">
                <?= __('Exclusiva?'); ?>
                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="<?= __('Caso escolha um usuário essa região será somente dele, caso não seja exclusiva qualquer usuário poderá atuar na região de acordo com seu o plano'); ?>"></i>
                </label>
                <?= $this->Form->control('exclusive', ['label' => false, 'class' => $input, 'type' => 'select', 'options' => ['Sim', 'Não'], 'empty' => __('Não')]) ?>
            </div>
        </div>
        
        <div class="top-10 well row">
            <div class="col-xs-12 col-sm-3">
                <label class="<?= $label ?>"><?= __('País'); ?></label>
                <?= $this->Form->input('country', ['label' => false, 'class' => $input, 'options' => ['opção 1', 'opção 2', 'opção 3', 'opção 4'], 'empty' => __('Escolha um país')]); ?>
            </div>
            <div class="col-xs-12 col-sm-3">
                <label class="<?= $label ?>"><?= __('Estado'); ?></label>
                <select id="states" name="states" class="form-control">
                    <option><?= __('Escolha primeiro um país'); ?></option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-3">
                <label class="<?= $label ?>"><?= __('Cidade'); ?></label>
                <select id="cities" name="cities" class="form-control">
                    <option><?= __('Escolha primeiro um país e um estado'); ?></option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-3">
                <button id="btn_add_cidade" class="btn btn-default top-25" disabled="disabled">
                    <?= __('Adicionar Cidade'); ?>
            	</button>
            </div>
        </div>
        
        <div class="bottom-10 row">
            <div id="lista_cidades" class="col-xs-12">
                <!-- LISTA CIDADES -->
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(' Cancelar', ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->button(' Gravar', ['type' => 'submit', 'class' => 'btn btn-primary scroll-modal', 'data-loading-text' => __('Gravando...'), 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>