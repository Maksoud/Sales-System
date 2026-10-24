<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Orders/values.ctp */

$this->layout = 'ajax';
$produtos = 0;
foreach ($pedido->pedidos_produtos as $item) {
    $produtos += $item->quantidade * $item->valor_unitario;
}
?>

<?= $this->Form->create(null, ['url' => ['action' => 'values', $pedido->id]]) ?>

    <dl class="ss-dl ss-mb-4">
        <dt><?= __('Associado') ?></dt>
        <dd><?= h($pedido->usuario->nome) ?></dd>
        <dt><?= __('Entrega em') ?></dt>
        <dd><?= h($pedido->usuario->cidade) ?>/<?= h($pedido->usuario->estado) ?></dd>
        <dt><?= __('Produtos') ?></dt>
        <dd><span class="ss-money"><?= $this->Number->currency($produtos, 'BRL') ?></span></dd>
    </dl>

    <div class="form-group">
        <label for="valor_frete" class="ss-required"><?= __('Valor do frete') ?></label>
        <div class="input-group">
            <span class="input-group-addon">R$</span>
            <?= $this->Form->text('valor_frete', ['class' => 'form-control valuemask focus', 'id' => 'valor_frete',
                    'required' => true, 'inputmode' => 'decimal', 'placeholder' => '0,00', 'autocomplete' => 'off']) ?>
        </div>
    </div>
    <div class="form-group ss-mb-0">
        <label for="valor_icms"><?= __('ICMS antecipado') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
        <div class="input-group">
            <span class="input-group-addon">R$</span>
            <?= $this->Form->text('valor_icms', ['class' => 'form-control valuemask', 'id' => 'valor_icms',
                    'inputmode' => 'decimal', 'placeholder' => '0,00', 'autocomplete' => 'off', 'aria-describedby' => 'valor_icms-help']) ?>
        </div>
        <span class="help-block" id="valor_icms-help"><?= __('Somente para associados contribuintes de ICMS em outro estado.') ?></span>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Salvar e enviar fatura'),
            ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
