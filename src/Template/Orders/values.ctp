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

    <div class="container-fluid">
        <p>
            <?= __('Pedido de') ?> <strong><?= h($pedido->usuario->nome) ?></strong><br>
            <small class="text-cinza"><?= __('Entrega em') ?> <?= h($pedido->usuario->cidade) ?>/<?= h($pedido->usuario->estado) ?></small>
        </p>
        <div class="alert alert-info">
            <?= __('Produtos:') ?> <strong><?= $this->Number->currency($produtos, 'BRL') ?></strong>
        </div>
        <div class="form-group">
            <label for="valor_frete"><?= __('Valor do frete') ?></label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <?= $this->Form->text('valor_frete', ['class' => 'form-control valuemask focus', 'id' => 'valor_frete', 'required']) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="valor_icms"><?= __('ICMS antecipado') ?></label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <?= $this->Form->text('valor_icms', ['class' => 'form-control valuemask', 'id' => 'valor_icms', 'placeholder' => '0,00']) ?>
            </div>
            <small class="text-cinza"><?= __('Somente para associados contribuintes de ICMS em outro estado.') ?></small>
        </div>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Gravar e Enviar Fatura'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Gravando...')]) ?>
    <?= $this->Form->end() ?>
</div>
