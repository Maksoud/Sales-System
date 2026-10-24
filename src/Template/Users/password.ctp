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

    <div class="container-fluid">
        <div class="form-group">
            <label for="senha_atual"><?= __('Senha atual*') ?></label>
            <?= $this->Form->password('senha_atual', ['class' => 'form-control focus', 'id' => 'senha_atual', 'required' => true]) ?>
        </div>
        <div class="form-group">
            <label for="nova_senha"><?= __('Nova senha*') ?></label>
            <?= $this->Form->password('nova_senha', ['class' => 'form-control', 'id' => 'nova_senha', 'required' => true, 'minlength' => 6]) ?>
        </div>
        <div class="form-group">
            <label for="confirma_senha"><?= __('Confirme a nova senha*') ?></label>
            <?= $this->Form->password('confirma_senha', ['class' => 'form-control', 'id' => 'confirma_senha', 'required' => true, 'minlength' => 6]) ?>
        </div>
        <small class="text-cinza"><?= __('Use pelo menos 6 caracteres, misturando letras e números.') ?></small>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Alterar Senha'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Gravando...')]) ?>
    <?= $this->Form->end() ?>
</div>
