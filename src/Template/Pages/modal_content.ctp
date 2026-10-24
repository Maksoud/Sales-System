<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Pages/modal_content.ctp */

//Modelo de conteúdo de modal (PagesController::modalContent). Os dois botões só fecham o modal.
$this->layout = 'ajax';
?>

<?= $this->Form->create('form', ['type' => 'file']) ?>

    <div id="ajax-retorno"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="title" class="ss-required"><?= __('Título') ?></label>
                <?= $this->Form->text('title', ['class' => 'form-control focus', 'id' => 'title', 'required' => true,
                        'aria-describedby' => 'title-help']) ?>
                <span class="help-block" id="title-help"><?= __('Linha principal da apresentação do produto.') ?></span>
            </div>
            <div class="form-group">
                <label for="imagem"><?= __('Imagem') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
                <?= $this->Form->file('imagem', ['id' => 'imagem', 'accept' => 'image/*', 'aria-describedby' => 'imagem-help']) ?>
                <span class="help-block" id="imagem-help"><?= __('Imagem do produto.') ?></span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 form-group">
            <label for="descricao" class="ss-required"><?= __('Descrição') ?></label>
            <?= $this->Form->textarea('descricao', ['class' => 'form-control', 'id' => 'descricao', 'rows' => 5, 'required' => true]) ?>
        </div>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Salvar'), ['type' => 'button', 'class' => 'btn btn-primary', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->end() ?>
</div>
