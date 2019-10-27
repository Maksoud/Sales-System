<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */ 

/* File: src/Template/Pages/GoalPlans/add.ctp */

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
            <div class="<?= $double ?>">
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Nome'); ?>
                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="<?= __('Informe o nome do plano, mas será necessários ajustes para o correto funcionamento. Procure o desenvolvedor.'); ?>"></i>
                        </label>
                        <?= $this->Form->control('title', ['label' => false, 'class' => $input . ' focus', 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Taxa de Inscrição'); ?>
                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="<?= __('Valor que será pago pelo associado para se ativar no sistema'); ?>"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"><?= __('R$'); ?></span>
                            <?= $this->Form->control('fee', ['label' => false, 'type' => 'text', 'class' => 'form-control valuemask']) ?>
                        </div>
                    </div>
                    
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Meta Mínima de Vendas'); ?>
                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="<?= __('Quantidade mínima de produtos a serem vendidos mensalmente para associados deste plano'); ?>"></i>
                        </label>
                        <?= $this->Form->control('salesGoals', ['label' => false, 'type' => 'number', 'pattern' => "[0-9]", 'onkeyup' => "this.value=this.value.replace(/[^0-9]/g,'');", 'class' => 'form-control form-group', 'placeholder' => 'Ex: 100']) ?>
                    </div>
                </div>
            </div>
            <div class="<?= $double ?> well">
                <div class="row">
                    <label class="<?= $label ?>"><?= __('BONIFICAÇÃO PELA INSCRIÇÃO'); ?></label>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Produto'); ?>
                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="<?= __('Selecione o produto que o usuário ganhará ao entrar nesse plano'); ?>"></i>
                        </label>
                        <?= $this->Form->control('products_id', ['label' => false, 'class' => $input, 'options' => ['opção 1', 'opção 2', 'opção 3', 'opção 4'], 'empty' => __('Escolha um produto')]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Quantidade de Produtos'); ?>
                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="<?= __('Informe a quantidade do produtos selecionado que o usuário ganhará'); ?>"></i>
                        </label>
                        <?= $this->Form->control('qtyproducts', ['label' => false, 'class' => $input]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(' Cancelar', ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->button(' Gravar', ['type' => 'submit', 'class' => 'btn btn-primary scroll-modal', 'data-loading-text' => __('Gravando...'), 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>