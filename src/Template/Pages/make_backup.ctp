<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Pages/make_backup.ctp */

//Gerar backup (modal)
$this->layout = 'ajax';

$cadastros = [
    'planos'     => __('Planos'),
    'regioes'    => __('Regiões'),
    'produtos'   => __('Produtos'),
    'associados' => __('Associados'),
    'metas'      => __('Metas'),
    'comissoes'  => __('Comissões'),
    'pedidos'    => __('Pedidos'),
];
$formatos = [
    'csv' => [__('CSV'), __('Abre em planilhas.'), 'fa-file-excel-o'],
    'sql' => [__('SQL'), __('Restaura no banco de dados.'), 'fa-database'],
];
?>

<?= $this->Form->create('Backup', ['type' => 'file']) ?>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Cadastros') ?></h4>
        <p class="ss-form-section-desc"><?= __('Marque o que entra no arquivo.') ?></p>
        <div class="row">
            <?php foreach (array_chunk($cadastros, 4, true) as $coluna): ?>
            <div class="col-xs-12 col-sm-6">
                <?php foreach ($coluna as $campo => $rotulo): ?>
                <div class="checkbox">
                    <label><?= $this->Form->checkbox($campo, ['hiddenField' => false]) ?> <?= $rotulo ?></label>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Formato do arquivo') ?></h4>
        <ul class="ss-choices" role="radiogroup" aria-label="<?= __('Formato do arquivo') ?>">
            <?php foreach ($formatos as $valor => $formato): ?>
            <li>
                <label class="ss-choice">
                    <input type="radio" name="radio" value="<?= $valor ?>" id="radio-<?= $valor ?>" <?= $valor === 'csv' ? 'checked' : '' ?>>
                    <span class="ss-choice-card">
                        <i class="fa <?= $formato[2] ?>" aria-hidden="true"></i>
                        <span class="ss-choice-title"><?= $formato[0] ?></span>
                        <span class="ss-choice-desc"><?= $formato[1] ?></span>
                    </span>
                </label>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button('<i class="fa fa-download" aria-hidden="true"></i> ' . __('Gerar backup'),
            ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Gerando...')]) ?>
    <?= $this->Form->end() ?>
</div>
