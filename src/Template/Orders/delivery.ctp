<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Orders/delivery.ctp */

$this->layout = 'ajax';
?>

<?= $this->Form->create(null, ['url' => ['action' => 'delivery', $pedido->id]]) ?>
<?= $this->Html->script('maksoud-datepicker') ?>

    <div class="container-fluid">
        <p>
            <?= __('Pedido de') ?> <strong><?= h($pedido->usuario->nome) ?></strong><br>
            <small class="text-cinza"><?= h($pedido->usuario->cidade) ?>/<?= h($pedido->usuario->estado) ?></small>
        </p>
        <div class="form-group">
            <label for="dtdespacho"><?= __('Data do envio') ?></label>
            <?= $this->Form->text('dtdespacho', ['class' => 'form-control datepicker datemask focus', 'id' => 'dtdespacho', 'value' => date('d/m/Y'), 'required']) ?>
        </div>
        <div class="form-group">
            <label for="dtentrega"><?= __('Previsão de entrega') ?></label>
            <?= $this->Form->text('dtentrega', ['class' => 'form-control datepicker datemask', 'id' => 'dtentrega', 'value' => date('d/m/Y', strtotime('+7 days')), 'required']) ?>
        </div>
        <div class="form-group">
            <label for="cod_rastreio"><?= __('Código de rastreio') ?></label>
            <?= $this->Form->text('cod_rastreio', ['class' => 'form-control', 'id' => 'cod_rastreio', 'placeholder' => 'QB000000000BR']) ?>
        </div>
        <div class="form-group">
            <label for="nf"><?= __('Nota fiscal (PDF)') ?></label>
            <?= $this->Form->file('nf', ['id' => 'nf']) ?>
        </div>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Registrar Envio'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Gravando...')]) ?>
    <?= $this->Form->end() ?>
</div>
