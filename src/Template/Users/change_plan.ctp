<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/change_plan.ctp */

$this->layout = 'ajax';
?>

<?= $this->Form->create(null, ['url' => ['action' => 'changePlan', $usuario->id]]) ?>

    <div class="container-fluid">
        <p>
            <strong><?= h($usuario->nome) ?></strong><br>
            <small><?= __('Plano atual:') ?> <?= $this->Usuarios->plano($usuario) ?></small>
        </p>
        <?php foreach ([3, 4, 5] as $id): ?>
            <div class="radio">
                <label>
                    <input type="radio" name="planos_id" value="<?= $id ?>" <?= $id == $usuario->planos_id ? 'checked' : '' ?>>
                    <?= h($planos[$id]->title) ?>
                    <small class="text-cinza">(<?= __('taxa') ?> <?= $this->Number->currency($planos[$id]->taxa, 'BRL') ?>)</small>
                </label>
            </div>
        <?php endforeach; ?>
        <small class="text-cinza"><?= __('Na mudança para um plano maior é gerada uma fatura com a diferença entre as taxas.') ?></small>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Mudar Plano'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Gravando...')]) ?>
    <?= $this->Form->end() ?>
</div>
