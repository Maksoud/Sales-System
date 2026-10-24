<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/password.ctp */

$this->layout = 'ajax';
?>

<?= $this->Form->create(null, ['url' => ['action' => 'password']]) ?>

    <div class="form-group">
        <label for="senha_atual" class="ss-required"><?= __('Senha atual') ?></label>
        <?= $this->Form->password('senha_atual', ['class' => 'form-control focus', 'id' => 'senha_atual', 'required' => true,
                'autocomplete' => 'current-password']) ?>
    </div>
    <div class="form-group">
        <label for="nova_senha" class="ss-required"><?= __('Nova senha') ?></label>
        <?= $this->Form->password('nova_senha', ['class' => 'form-control', 'id' => 'nova_senha', 'required' => true, 'minlength' => 6,
                'autocomplete' => 'new-password', 'aria-describedby' => 'nova_senha-help']) ?>
        <span class="help-block" id="nova_senha-help"><?= __('Pelo menos 6 caracteres, misturando letras e números.') ?></span>
    </div>
    <div class="form-group ss-mb-0">
        <label for="confirma_senha" class="ss-required"><?= __('Confirme a nova senha') ?></label>
        <?= $this->Form->password('confirma_senha', ['class' => 'form-control', 'id' => 'confirma_senha', 'required' => true, 'minlength' => 6,
                'autocomplete' => 'new-password']) ?>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Alterar senha'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
