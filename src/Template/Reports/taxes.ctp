<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/taxes.ctp */
?>

<?= $this->element('report-header', ['titulo' => __('Tabela de ICMS por estado de destino'), 'periodo' => [null, null]]) ?>

<div class="ss-note">
    <span class="ss-note-title"><?= __('Referência') ?></span>
    <?= __('Alíquotas usadas no cálculo dos pedidos enviados a partir de Alagoas. Confirme os valores com a contabilidade antes de usar.') ?>
</div>

<section class="ss-report-section">
    <h2 class="ss-section-title"><?= __('Alíquotas') ?> <span class="ss-count"><?= count($impostos) ?></span></h2>
    <div class="ss-table-wrap">
        <table class="table ss-table">
            <thead>
                <tr>
                    <th scope="col"><?= __('Origem') ?></th>
                    <th scope="col"><?= __('Destino') ?></th>
                    <th scope="col" class="ss-num"><?= __('Alíquota') ?></th>
                    <th scope="col"><?= __('ICMS antecipado') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($impostos as $imposto): ?>
                    <tr>
                        <td><?= h($imposto['origem']) ?></td>
                        <td><strong><?= h($imposto['destino']) ?></strong></td>
                        <td class="ss-num"><?= $this->Number->toPercentage($imposto['valor'], 0) ?></td>
                        <td><?= $imposto['antecipado'] ? __('Sim') : '<span class="ss-muted">' . __('Não') . '</span>' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
