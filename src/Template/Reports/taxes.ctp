<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/taxes.ctp */
?>

<div class="container">
    <?= $this->element('report-header', ['titulo' => __('Tabela de ICMS por Estado de Destino'), 'periodo' => [null, null]]) ?>

    <p class="text-cinza">
        <small><?= __('Alíquotas usadas no cálculo dos pedidos enviados a partir de Alagoas. Tabela de referência: confirme os valores com a contabilidade antes de usar.') ?></small>
    </p>

    <table class="table table-bordered table-condensed">
        <thead>
            <tr class="bg-gray">
                <th class="text-center">#</th>
                <th class="text-center"><?= __('Origem') ?></th>
                <th class="text-center"><?= __('Destino') ?></th>
                <th class="text-center"><?= __('Alíquota') ?></th>
                <th class="text-center"><?= __('ICMS antecipado') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($impostos as $i => $imposto): ?>
                <tr>
                    <th class="text-center"><?= $i + 1 ?></th>
                    <td class="text-center"><?= $imposto['origem'] ?></td>
                    <td class="text-center"><?= $imposto['destino'] ?></td>
                    <td class="text-center"><?= $imposto['valor'] ?>%</td>
                    <td class="text-center"><?= $imposto['antecipado'] ? __('Sim') : __('Não') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
