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

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Identificação') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-8 form-group">
                <label for="title" class="ss-required"><?= __('Nome') ?></label>
                <?= $this->Form->text('title', ['class' => 'form-control focus', 'id' => 'title', 'required' => true,
                        'value' => $produto ? $produto->title : '', 'aria-describedby' => 'title-help']) ?>
                <span class="help-block" id="title-help"><?= __('Aparece na loja e nos pedidos.') ?></span>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="status"><?= __('Status') ?></label>
                <?= $this->Form->select('status', $this->Produtos->statusLista(),
                        ['class' => 'form-control', 'id' => 'status', 'value' => $produto ? $produto->status : 'A',
                         'aria-describedby' => 'status-help']) ?>
                <span class="help-block" id="status-help"><?= __('Inativo sai da loja.') ?></span>
            </div>
            <div class="col-xs-12 form-group">
                <label for="descricao"><?= __('Descrição') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
                <?= $this->Form->textarea('descricao', ['class' => 'form-control', 'id' => 'descricao', 'rows' => 3,
                        'value' => $produto ? $produto->descricao : '']) ?>
            </div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Venda') ?></h4>
        <p class="ss-form-section-desc"><?= __('Preço e posição do produto na loja.') ?></p>
        <div class="row">
            <div class="col-xs-6 col-sm-4 form-group">
                <label for="valor" class="ss-required"><?= __('Preço') ?></label>
                <div class="input-group">
                    <span class="input-group-addon">R$</span>
                    <?= $this->Form->text('valor', ['class' => 'form-control valuemask', 'id' => 'valor', 'required' => true,
                            'inputmode' => 'decimal', 'autocomplete' => 'off',
                            'value' => $produto ? number_format($produto->valor, 2, ',', '.') : '']) ?>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 form-group">
                <label for="ordem"><?= __('Ordem na loja') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
                <?= $this->Form->number('ordem', ['class' => 'form-control', 'id' => 'ordem', 'inputmode' => 'numeric',
                        'value' => $produto ? $produto->ordem : '']) ?>
            </div>
            <div class="col-xs-12 form-group">
                <div class="checkbox ss-mb-0">
                    <label><?= $this->Form->checkbox('comissoes', ['checked' => $produto ? $produto->comissoes : true]) ?> <?= __('Gera comissões para a rede') ?></label>
                </div>
            </div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Imagem') ?></h4>
        <div class="ss-cell-media">
            <?php if ($produto): ?>
                <?= $this->Html->image('produtos/' . $produto->imagem, ['class' => 'ss-thumb ss-thumb--lg', 'alt' => __('Imagem atual')]) ?>
            <?php endif; ?>
            <div class="form-group ss-mb-0 ss-grow">
                <label for="imagem">
                    <?= $produto ? __('Trocar imagem') : __('Imagem') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span>
                </label>
                <?= $this->Form->file('imagem', ['id' => 'imagem', 'accept' => 'image/*', 'aria-describedby' => 'imagem-help']) ?>
                <span class="help-block" id="imagem-help"><?= __('Prefira uma imagem quadrada.') ?></span>
            </div>
        </div>
    </section>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?php if ($produto): ?>
        <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i> ' . __('Excluir'),
                ['action' => 'delete', $produto->id],
                ['confirm' => __('Excluir o produto {0}? Esta ação não pode ser desfeita.', $produto->title),
                 'class' => 'btn ss-btn-danger-soft ss-footer-start', 'escape' => false, 'block' => true]) ?>
    <?php endif; ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button($produto ? __('Salvar') : __('Cadastrar'),
            ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->fetch('postLink') ?>
