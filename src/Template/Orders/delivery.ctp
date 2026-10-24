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

<?= $this->Form->create(null, ['url' => ['action' => 'delivery', $pedido->id], 'type' => 'file']) ?>
<?= $this->Html->script('maksoud-datepicker') ?>

    <dl class="ss-dl ss-mb-4">
        <dt><?= __('Associado') ?></dt>
        <dd><?= h($pedido->usuario->nome) ?></dd>
        <dt><?= __('Destino') ?></dt>
        <dd><?= h($pedido->usuario->cidade) ?>/<?= h($pedido->usuario->estado) ?></dd>
    </dl>

    <div class="row">
        <div class="col-xs-6 form-group">
            <label for="dtdespacho" class="ss-required"><?= __('Data do envio') ?></label>
            <?= $this->Form->text('dtdespacho', ['class' => 'form-control datepicker datemask focus', 'id' => 'dtdespacho',
                    'value' => date('d/m/Y'), 'required' => true, 'placeholder' => 'dd/mm/aaaa',
                    'autocomplete' => 'off', 'inputmode' => 'numeric']) ?>
        </div>
        <div class="col-xs-6 form-group">
            <label for="dtentrega" class="ss-required"><?= __('Previsão de entrega') ?></label>
            <?= $this->Form->text('dtentrega', ['class' => 'form-control datepicker datemask', 'id' => 'dtentrega',
                    'value' => date('d/m/Y', strtotime('+7 days')), 'required' => true, 'placeholder' => 'dd/mm/aaaa',
                    'autocomplete' => 'off', 'inputmode' => 'numeric']) ?>
        </div>
        <div class="col-xs-12 form-group">
            <label for="cod_rastreio"><?= __('Código de rastreio') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
            <?= $this->Form->text('cod_rastreio', ['class' => 'form-control', 'id' => 'cod_rastreio',
                    'placeholder' => __('Ex.: QB000000000BR'), 'autocomplete' => 'off']) ?>
        </div>
        <div class="col-xs-12 form-group ss-mb-0">
            <label for="nf"><?= __('Nota fiscal') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
            <?= $this->Form->file('nf', ['id' => 'nf', 'accept' => 'application/pdf', 'aria-describedby' => 'nf-help']) ?>
            <span class="help-block" id="nf-help"><?= __('Arquivo PDF.') ?></span>
        </div>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button('<i class="fa fa-truck" aria-hidden="true"></i> ' . __('Registrar envio'),
            ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
