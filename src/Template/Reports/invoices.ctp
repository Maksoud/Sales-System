<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/invoices.ctp */

//Resumo: tipo x status
$resumo = [];
foreach ($faturas as $fatura) {
    $tipo = $this->Faturas->tipo($fatura->tipo);
    if (!isset($resumo[$tipo])) $resumo[$tipo] = ['P' => 0, 'F' => 0, 'C' => 0, 'qtd' => 0];
    $resumo[$tipo][$fatura->status] += $fatura->total;
    $resumo[$tipo]['qtd']++;
}
?>

<div class="container">
    <?= $this->element('report-header', ['titulo' => __('Relatório de Faturas'), 'periodo' => $periodo]) ?>

    <?php if (!$faturas): ?>
        <div class="alert alert-info"><?= __('Nenhuma fatura encontrada com os filtros informados.') ?></div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-gray">
                    <th><?= __('Tipo') ?></th>
                    <th class="text-center"><?= __('Faturas') ?></th>
                    <th class="text-right"><?= __('Pendentes') ?></th>
                    <th class="text-right"><?= __('Finalizadas') ?></th>
                    <th class="text-right"><?= __('Canceladas') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resumo as $tipo => $linha): ?>
                    <tr>
                        <td><?= $tipo ?></td>
                        <td class="text-center"><?= $linha['qtd'] ?></td>
                        <td class="text-right"><?= $this->Number->currency($linha['P'], 'BRL') ?></td>
                        <td class="text-right"><?= $this->Number->currency($linha['F'], 'BRL') ?></td>
                        <td class="text-right"><?= $this->Number->currency($linha['C'], 'BRL') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <table class="table table-bordered table-condensed">
            <thead>
                <tr class="bg-gray">
                    <th class="text-center">#</th>
                    <th><?= __('Fatura') ?></th>
                    <th><?= __('Cadastro') ?></th>
                    <th><?= __('Associado') ?></th>
                    <th><?= __('Tipo') ?></th>
                    <th><?= __('Forma Pgto') ?></th>
                    <th><?= __('Vencimento') ?></th>
                    <th><?= __('Pagamento') ?></th>
                    <th><?= __('Status') ?></th>
                    <th class="text-right"><?= __('Valor') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($faturas as $fatura): ?>
                    <tr>
                        <th class="text-center"><?= $i++ ?></th>
                        <td><?= str_pad($fatura->id, 6, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-nowrap"><?= $fatura->created->format('d/m/Y') ?></td>
                        <td><?= h($fatura->usuario->nome) ?></td>
                        <td><?= $this->Faturas->tipo($fatura->tipo) ?></td>
                        <td><?= $fatura->tipo == 'C' ? '-' : $this->Faturas->forma_pagamento($fatura->forma_pagamento) ?><?= $fatura->qt_parcelas > 1 ? ' (' . $fatura->parcela_atual . '/' . $fatura->qt_parcelas . ')' : '' ?></td>
                        <td class="text-nowrap"><?= $fatura->vencimento->format('d/m/Y') ?></td>
                        <td class="text-nowrap"><?= $fatura->pagamento ? $fatura->pagamento->format('d/m/Y') : '-' ?></td>
                        <td><?= $this->Faturas->status($fatura->status) ?></td>
                        <td class="text-right text-nowrap"><?= $this->Number->currency($fatura->total, 'BRL') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
