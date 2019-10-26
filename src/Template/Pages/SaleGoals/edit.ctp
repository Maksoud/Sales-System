<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Pages/SaleGoals/edit.ctp */

$this->layout = 'ajax';
?>

<?= $this->Form->create($meta, ['class' => 'ajax', 'data-url' => 'metas/editjson']) ?>
<?= $this->Html->script('add-metas') ?>

<?php 
    $single = 'col-xs-12';
    $double = 'col-xs-12 col-sm-6';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control form-group';
?>

    <div class="container-fluid">
        <div class="row">
            <?= $this->Form->control('id', ['label' => false, 'hidden' => true, 'value' => $meta->id]) ?>
            <div id="ajax-retorno" class="col-xs-12"></div>
        </div>
        
        <div class="row">
            
            <div class="col-xs-12">
                <label class="<?= $label ?>">
                    <?= __('Tipo de meta') ?>
                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Para indicações de associados ou vendas de produtos"></i>
                </label>
                <div class="col-xs-12">
                    <?= $this->Form->radio('tipo', ['I' => 'Indicação', 'V' => 'Venda'], ['legend'  => false, 'default' => 'I', 'label' => ['class' => 'radio-inline btn']]) ?>
                </div>
            </div>
            
            <div class="top-20 col-xs-12">
                <div class="col-xs-12 well">
                    <div class="row">
                        <label class="col-xs-12">
                            <?= __('PLANO E META') ?>
                            <div class="clearfix"></div>
                            <small><?= __('Informe qual plano e quando atingir a meta') ?></small>
                        </label>
                        <div class="col-xs-12 col-sm-4">
                            <label class="<?= $label ?>">
                                <?= __('Quando o') ?>
                                <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Plano que receberá essa meta"></i>
                            </label>
                            <?= $this->Form->control('de_planos_id', ['label' => false, 'class' => $input, 'options' => $dePlanos]) ?>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <label class="<?= $label ?>">
                                <?= __('Atingir') ?>
                                <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Quantidade de indicações/vendas necessárias para atingir a meta"></i>
                            </label>
                            <?= $this->Form->control('meta', ['label' => false, 'type' => 'number', 'pattern' => "[0-9]", 'onkeyup' => "this.value=this.value.replace(/[^0-9]/g,'');", 'class' => 'form-control form-group', 'placeholder' => 'Ex: 100']) ?>
                        </div>
                        
                        <div id="tipo_indicacao" class="col-xs-12 col-sm-4 show">
                            <label class="<?= $label ?>">
                                <?= __('Indicações de') ?>
                                <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Plano que tem que receber os associados da indicação"></i>
                            </label>
                            <?= $this->Form->control('para_planos_id', ['label' => false, 'class' => $input, 'options' => $paraPlanos]) ?>
                        </div>
                        <div id="tipo_venda" class="col-xs-12 col-sm-4 hidden">
                            <label class="<?= $label ?>">
                                <?= __('Vendas de') ?>
                                <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Produto que tem que ser vendido"></i>
                            </label>
                            <?= $this->Form->control('produtos_id', ['label' => false, 'class' => $input, 'options' => $Produtos]) ?>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12">
                <div class="col-xs-12 well">
                    <div class="row">
                        <label class="col-xs-12">
                            <?= __('PRODUTO E QUANTIDADE DA BONIFICAÇÃO') ?>
                            <div class="clearfix"></div>
                            <small><?= __('Informe o que vai ser dado quando a meta for atingida e a quantidade do prêmio') ?></small>
                        </label>
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>">
                                <?= __('Ele vai ganhar') ?>
                                <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Produto que será bonificado ao atingir a meta"></i>
                            </label>
                            <?= $this->Form->control('bonificacao_produtos_id', ['label' => false, 'class' => $input, 'options' => $Bonificacoes]) ?>
                        </div>
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>">
                                <?= __('Quantidade de Produtos') ?>
                                <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Quantidade de produtos que serão bonificados ao atender a meta"></i>
                            </label>
                            <?= $this->Form->control('qtganha', ['label' => false, 'type' => 'number', 'pattern' => "[0-9]", 'onkeyup' => "this.value=this.value.replace(/[^0-9]/g,'');", 'class' => 'form-control form-group', 'placeholder' => 'Ex: 100']) ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(' Cancelar', ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->button(' Gravar', ['type' => 'submit', 'class' => 'btn btn-primary scroll-modal', 'data-loading-text' => 'Gravando...', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>