<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Products/form.ctp */

//Inclusão e edição de produto (modal)
$this->layout = 'ajax';
$url = $produto ? ['action' => 'edit', $produto->id] : ['action' => 'add'];
?>

<?= $this->Form->create(null, ['url' => $url, 'type' => 'file']) ?>

    <div class="container-fluid">
        <div class="row">
            <?php if ($produto): ?>
                <div class="col-xs-12 col-sm-3 text-center bottom-10">
                    <?= $this->Html->image('produtos/' . $produto->imagem, ['class' => 'img-responsive img-rounded center-block', 'alt' => $produto->title]) ?>
                </div>
            <?php endif; ?>
            <div class="col-xs-12 <?= $produto ? 'col-sm-9' : '' ?>">
                <div class="form-group">
                    <label for="title"><?= __('Nome*') ?></label>
                    <?= $this->Form->text('title', ['class' => 'form-control focus', 'id' => 'title', 'required' => true, 'value' => $produto ? $produto->title : '']) ?>
                </div>
                <div class="form-group">
                    <label for="descricao"><?= __('Descrição') ?></label>
                    <?= $this->Form->textarea('descricao', ['class' => 'form-control', 'id' => 'descricao', 'rows' => 3, 'value' => $produto ? $produto->descricao : '']) ?>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 form-group">
                        <label for="valor"><?= __('Preço*') ?></label>
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <?= $this->Form->text('valor', ['class' => 'form-control valuemask', 'id' => 'valor', 'required' => true, 'value' => $produto ? number_format($produto->valor, 2, ',', '.') : '']) ?>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 form-group">
                        <label for="status"><?= __('Status') ?></label>
                        <?= $this->Form->select('status', ['A' => __('Ativo'), 'I' => __('Inativo')], ['class' => 'form-control', 'id' => 'status', 'value' => $produto ? $produto->status : 'A']) ?>
                    </div>
                    <div class="col-xs-12 col-sm-4 form-group">
                        <label for="ordem"><?= __('Ordem na loja') ?></label>
                        <?= $this->Form->number('ordem', ['class' => 'form-control', 'id' => 'ordem', 'value' => $produto ? $produto->ordem : '']) ?>
                    </div>
                </div>
                <div class="checkbox">
                    <label><?= $this->Form->checkbox('comissoes', ['checked' => $produto ? $produto->comissoes : true]) ?> <?= __('Gera comissões para a rede') ?></label>
                </div>
                <div class="form-group">
                    <label for="imagem"><?= __('Imagem') ?></label>
                    <?= $this->Form->file('imagem', ['id' => 'imagem']) ?>
                </div>
            </div>
        </div>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Gravando...')]) ?>
    <?= $this->Form->end() ?>
</div>
