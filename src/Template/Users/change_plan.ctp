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

    <dl class="ss-dl ss-mb-4">
        <dt><?= __('Associado') ?></dt>
        <dd><?= h($usuario->nome) ?> <span class="ss-muted">(<?= h($usuario->login) ?>)</span></dd>
        <dt><?= __('Plano atual') ?></dt>
        <dd><?= $this->Usuarios->plano($usuario) ?></dd>
    </dl>

    <span class="control-label ss-required" id="planos-label"><?= __('Novo plano') ?></span>
    <ul class="ss-choices" role="radiogroup" aria-labelledby="planos-label">
        <?php foreach ([3, 4, 5] as $id): ?>
        <li>
            <label class="ss-choice">
                <input type="radio" name="planos_id" id="planos_id_<?= $id ?>" value="<?= $id ?>" <?= $id == $usuario->planos_id ? 'checked' : '' ?> required>
                <span class="ss-choice-card">
                    <i class="fa fa-certificate" aria-hidden="true"></i>
                    <span class="ss-choice-title"><?= h($planos[$id]->title) ?></span>
                    <span class="ss-choice-desc">
                        <?= __('Taxa de {0}', $this->Number->currency($planos[$id]->taxa, 'BRL')) ?>
                        <?php if ($id == $usuario->planos_id): ?><br><?= __('Plano atual') ?><?php endif; ?>
                    </span>
                </span>
            </label>
        </li>
        <?php endforeach; ?>
    </ul>

    <p class="ss-help ss-mb-0"><?= __('Na mudança para um plano maior é gerada uma fatura com a diferença entre as taxas.') ?></p>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Mudar plano'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
