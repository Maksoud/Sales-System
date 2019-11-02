<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */ 

/* File: src/Template/Pages/SaleCommissions/add.ctp */

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
        
        <!-- Aviso vindo do AJAX em caso de erro -->
        <div class="row">
            <div id="ajax-retorno" class="col-xs-12"></div>
        </div>
        <!-- Fim aviso vindo do AJAX -->
        
        
        <div class="top-10 row">
            <div class="col-xs-12 col-sm-6">
                <label class="<?= $label ?>">
                    <?= __('Plano que irá receber a comissão (de)'); ?>
                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="<?= __('Basicamente é quem está cadastrando outro usuario no sistema'); ?>"></i>
                </label>
                <?= $this->Form->control('from_plans_id', ['label' => false, 'class' => $input, 'options' => ['opção 1', 'opção 2', 'opção 3', 'opção 4'], 'empty' => __('Escolha uma opção'), 'required' => 'required']) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <label class="<?= $label ?>">
                    <?= __('Plano que irá executar ação (para)'); ?>
                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="<?= __('Basicamente é ou está sendo cadastrado ou está realizando uma compra no sistema'); ?>"></i>
                </label>
                <?= $this->Form->control('to_plans_id', ['label' => false, 'class' => $input, 'options' => ['opção 1', 'opção 2', 'opção 3', 'opção 4'], 'empty' => __('Escolha uma opção'), 'required' => 'required']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <label class="<?= $label ?>">
                        <?= __('Valor a ser pago'); ?>
                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="<?= __('Valor que será como comissão'); ?>"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"><?= __('R$'); ?></span>
                            <?= $this->Form->input('value', ['label' => false, 'class' => 'form-control valuemask', 'type' => 'text', 'required' => 'required']); ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <label class="<?= $label ?>">
                            <?= __('Tipo de comissão'); ?>
                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="<?= __('Se é por venda, por cadastro, direta e indiretamente, etc'); ?>"></i>
                        </label>   
                        <?= $this->Form->control('type', ['required' => 'required', 'label' => false, 'class' => $input, 'options' => ['ID' => __('Indicação Direta'), 
                                                                                                                                       'II' => __('Indicação Indireta'),
                                                                                                                                       'IM' => __('Indicação Multinível'),
                                                                                                                                       'VD' => __('Venda Direta'),
                                                                                                                                       'VI' => __('Venda Indireta'),
                                                                                                                                       'VM' => __('Venda Multinível')
                                                                                                                                      ], 'empty' => __('Escolha uma opção')]) ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <label class="<?= $label ?>">
                    <?= __('Produto'); ?>
                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="<?= __('Em caso de comissões de vendas, selecione um produto'); ?>"></i>
                </label>
                <?= $this->Form->control('products_id', ['label' => false, 'class' => $input, 'options' => ['opção 1', 'opção 2', 'opção 3', 'opção 4'], 'empty' => __('Escolha uma opção')]) ?>
            </div>
                
        </div>
        <div class="row">
            <div class="left-20">
                <div class="col-xs-12 col-sm-6">
                    <label class="<?= $label ?>">
                        <?= $this->Form->control('multi', ['label' => false, 'type' => 'checkbox', 'hiddenField' => false, 'div' => false]) ?>
                        <?= __('Multinível'); ?>
                        <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="<?= __('Esta é uma comissão muiltinível, onde o patrocinador do patrocinador ganha comissão/bonificação.'); ?>"></i>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'btn btn-primary scroll-modal', 'data-loading-text' => __('Gravando...'), 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>