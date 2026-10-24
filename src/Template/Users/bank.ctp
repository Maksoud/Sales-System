<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/bank.ctp */

$this->layout = 'ajax';
?>

<?= $this->Form->create(null, ['url' => ['action' => 'bank']]) ?>

    <div class="container-fluid">
        <div class="form-group">
            <label for="banco"><?= __('Banco') ?></label>
            <?= $this->Form->text('banco', ['class' => 'form-control focus', 'id' => 'banco', 'value' => $usuario->banco]) ?>
        </div>
        <div class="row">
            <div class="col-xs-5 form-group">
                <label for="agencia"><?= __('Agência') ?></label>
                <?= $this->Form->text('agencia', ['class' => 'form-control', 'id' => 'agencia', 'value' => $usuario->agencia]) ?>
            </div>
            <div class="col-xs-7 form-group">
                <label for="conta"><?= __('Conta') ?></label>
                <?= $this->Form->text('conta', ['class' => 'form-control', 'id' => 'conta', 'value' => $usuario->conta]) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="tipo_conta"><?= __('Tipo de conta') ?></label>
            <?= $this->Form->select('tipo_conta', ['C' => __('Corrente'), 'P' => __('Poupança')], ['class' => 'form-control', 'id' => 'tipo_conta', 'value' => $usuario->tipo_conta]) ?>
        </div>
        <div class="form-group">
            <label for="pix"><?= __('Chave PIX') ?></label>
            <?= $this->Form->text('pix', ['class' => 'form-control', 'id' => 'pix', 'value' => $usuario->pix]) ?>
        </div>
        <small class="text-cinza">
            <?= __('Titular:') ?> <?= h($usuario->nome) ?><br>
            <?= __('A conta precisa estar no mesmo CPF/CNPJ do cadastro.') ?>
        </small>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Gravando...')]) ?>
    <?= $this->Form->end() ?>
</div>
