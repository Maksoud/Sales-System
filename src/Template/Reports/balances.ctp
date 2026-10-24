<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/balances.ctp */

$totais = ['disponivel' => 0, 'bloqueado' => 0, 'sacado' => 0];
foreach ($saldos as $saldo) {
    foreach ($totais as $chave => $valor) $totais[$chave] += $saldo[$chave];
}
?>

<div class="container">
    <?= $this->element('report-header', ['titulo' => __('Relatório de Saldos dos Associados'), 'periodo' => [null, null]]) ?>

    <?php if (!$saldos): ?>
        <div class="alert alert-info"><?= __('Nenhum associado encontrado com os filtros informados.') ?></div>
    <?php else: ?>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr class="bg-gray">
                    <th class="text-center">#</th>
                    <th><?= __('Associado') ?></th>
                    <th><?= __('Plano') ?></th>
                    <th class="text-right"><?= __('Disponível') ?></th>
                    <th class="text-right"><?= __('Bloqueado') ?></th>
                    <th class="text-right"><?= __('Já sacado') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($saldos as $id => $saldo): ?>
                    <tr>
                        <th class="text-center"><?= $i++ ?></th>
                        <td><?= h($associados[$id]->nome) ?></td>
                        <td><?= h($associados[$id]->plano->title) ?></td>
                        <td class="text-right"><?= $this->Number->currency($saldo['disponivel'], 'BRL') ?></td>
                        <td class="text-right"><?= $this->Number->currency($saldo['bloqueado'], 'BRL') ?></td>
                        <td class="text-right"><?= $this->Number->currency($saldo['sacado'], 'BRL') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="font-16">
                    <th colspan="3" class="text-right"><?= __('Totais') ?></th>
                    <th class="text-right"><?= $this->Number->currency($totais['disponivel'], 'BRL') ?></th>
                    <th class="text-right"><?= $this->Number->currency($totais['bloqueado'], 'BRL') ?></th>
                    <th class="text-right"><?= $this->Number->currency($totais['sacado'], 'BRL') ?></th>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>
</div>
