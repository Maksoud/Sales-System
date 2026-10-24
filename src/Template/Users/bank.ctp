<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/bank.ctp */

$this->layout = 'ajax';
$juridica = $usuario->tipo_de_pessoa == 'J';
?>

<?= $this->Form->create(null, ['url' => ['action' => 'bank']]) ?>

    <dl class="ss-dl ss-mb-4">
        <dt><?= __('Titular') ?></dt>
        <dd><?= h($usuario->nome) ?></dd>
        <dt><?= $juridica ? __('CNPJ') : __('CPF') ?></dt>
        <dd><span class="ss-mono"><?= h($juridica ? $usuario->cnpj : $usuario->cpf) ?></span></dd>
    </dl>

    <div class="form-group">
        <label for="banco"><?= __('Banco') ?></label>
        <?= $this->Form->text('banco', ['class' => 'form-control focus', 'id' => 'banco', 'value' => $usuario->banco,
                'placeholder' => __('Ex.: 001 - Banco do Brasil')]) ?>
    </div>
    <div class="row">
        <div class="col-xs-5 form-group">
            <label for="agencia"><?= __('Agência') ?></label>
            <?= $this->Form->text('agencia', ['class' => 'form-control', 'id' => 'agencia', 'value' => $usuario->agencia, 'inputmode' => 'numeric']) ?>
        </div>
        <div class="col-xs-7 form-group">
            <label for="conta"><?= __('Conta') ?></label>
            <?= $this->Form->text('conta', ['class' => 'form-control', 'id' => 'conta', 'value' => $usuario->conta, 'inputmode' => 'numeric']) ?>
        </div>
    </div>
    <div class="form-group">
        <label for="tipo_conta"><?= __('Tipo de conta') ?></label>
        <?= $this->Form->select('tipo_conta', ['C' => __('Corrente'), 'P' => __('Poupança')],
                ['class' => 'form-control', 'id' => 'tipo_conta', 'value' => $usuario->tipo_conta]) ?>
    </div>
    <div class="form-group">
        <label for="pix"><?= __('Chave PIX') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
        <?= $this->Form->text('pix', ['class' => 'form-control', 'id' => 'pix', 'value' => $usuario->pix, 'autocapitalize' => 'none']) ?>
    </div>

    <p class="ss-help ss-mb-0"><?= __('A conta precisa estar no mesmo CPF/CNPJ do cadastro.') ?></p>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Salvar'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
