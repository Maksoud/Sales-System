<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Pages/modal-content.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('form', ['type' => 'file']) ?>

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
        
        <div class="bottom-20 row">
            <div class="col-xs-12 col-sm-6">
                <label class="<?= $label ?>">
                    <?= __('Título') ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Linha principal da apresentação do produto"></i>
                </label>
                <?= $this->Form->control('title', ['label' => false, 'class' => $input . ' focus', 'required' => true]) ?>
                
                <label class="<?= $label ?>">
                    <?= __('Imagem') ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Selecione uma imagem produto"></i>
                </label>
                <?= $this->Form->file('imagem', ['label' => false, 'class' => $input, 'placeholder' => 'Selecione a imagem', 'type' => 'image']) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <label class="<?= $label ?>">
                    <?= __('Descrição') ?> <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Descrição do produto"></i>
                </label>
                <?= $this->Form->textarea('descricao', ['label' => false, 'class' => $input, 'rows' => '5', 'required' => true]) ?>
            </div>
            
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'cancel', 'class' => 'btn btn-primary scroll-modal', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>