<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/report-form.ctp */

/**
 * Formulário de filtros de relatório (conteúdo de modal).
 * O relatório abre em uma nova aba, com layout próprio para impressão.
 *
 * Variáveis:
 *   $url     Destino do relatório, ex.: ['controller' => 'Reports', 'action' => 'orders']
 *   $periodo Exibe as datas de início e fim (padrão: true)
 *   $selects Filtros extras: nome => [rótulo, opções, texto do "todos"]
 */
$periodo = isset($periodo) ? $periodo : true;
$selects = isset($selects) ? $selects : [];
?>

<?= $this->Form->create(null, ['type' => 'get', 'url' => $url, 'target' => '_blank']) ?>
<?= $this->Html->script('maksoud-datepicker') ?>

    <div class="container-fluid">
        <?php if ($periodo): ?>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="data_inicio"><?= __('Data início') ?></label>
                        <?= $this->Form->text('data_inicio', ['class' => 'form-control datepicker datemask', 'id' => 'data_inicio', 'value' => date('01/m/Y', strtotime('-2 months'))]) ?>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="data_final"><?= __('Data final') ?></label>
                        <?= $this->Form->text('data_final', ['class' => 'form-control datepicker datemask', 'id' => 'data_final', 'value' => date('d/m/Y')]) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php foreach ($selects as $nome => $select): ?>
            <div class="form-group">
                <label for="filtro-<?= h($nome) ?>"><?= h($select[0]) ?></label>
                <?= $this->Form->select($nome, $select[1], ['class' => 'form-control', 'id' => 'filtro-' . $nome, 'empty' => isset($select[2]) ? $select[2] : __('- todos -')]) ?>
            </div>
        <?php endforeach; ?>

        <small class="text-cinza"><i class="fa fa-external-link" aria-hidden="true"></i> <?= __('O relatório abre em uma nova aba, pronto para impressão.') ?></small>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Gerar Relatório'), ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>
