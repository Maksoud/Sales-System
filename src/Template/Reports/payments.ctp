<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/payments.ctp */

$totais = ['P' => 0, 'F' => 0, 'C' => 0];
foreach ($saques as $saque) {
    $totais[$saque->status] += $saque->total;
}
?>

<div class="container">
    <?= $this->element('report-header', ['titulo' => __('Relatório de Pagamentos de Comissões'), 'periodo' => $periodo]) ?>

    <?php if (!$saques): ?>
        <div class="alert alert-info"><?= __('Nenhum saque encontrado com os filtros informados.') ?></div>
    <?php else: ?>
        <div class="row text-center bottom-10">
            <div class="col-xs-4"><div class="panel panel-default"><div class="panel-body"><small><?= __('Pagos') ?></small><h4><?= $this->Number->currency($totais['F'], 'BRL') ?></h4></div></div></div>
            <div class="col-xs-4"><div class="panel panel-default"><div class="panel-body"><small><?= __('Aguardando pagamento') ?></small><h4><?= $this->Number->currency($totais['P'], 'BRL') ?></h4></div></div></div>
            <div class="col-xs-4"><div class="panel panel-default"><div class="panel-body"><small><?= __('Cancelados') ?></small><h4><?= $this->Number->currency($totais['C'], 'BRL') ?></h4></div></div></div>
        </div>

        <table class="table table-bordered table-condensed">
            <thead>
                <tr class="bg-gray">
                    <th class="text-center">#</th>
                    <th><?= __('Fatura') ?></th>
                    <th><?= __('Solicitado em') ?></th>
                    <th><?= __('Associado') ?></th>
                    <th><?= __('Dados bancários') ?></th>
                    <th><?= __('Pago em') ?></th>
                    <th><?= __('Status') ?></th>
                    <th class="text-right"><?= __('Valor') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($saques as $saque): ?>
                    <tr>
                        <th class="text-center"><?= $i++ ?></th>
                        <td><?= str_pad($saque->id, 6, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-nowrap"><?= $saque->created->format('d/m/Y') ?></td>
                        <td><?= h($saque->usuario->nome) ?><br><small><?= h($saque->usuario->plano->title) ?></small></td>
                        <td><small><?= h($saque->usuario->banco) ?><br><?= __('Ag.') ?> <?= h($saque->usuario->agencia) ?> - <?= h($saque->usuario->conta) ?></small></td>
                        <td class="text-nowrap"><?= $saque->pagamento ? $saque->pagamento->format('d/m/Y') : '-' ?></td>
                        <td><?= $saque->status == 'F' ? __('Pago') : ($saque->status == 'P' ? __('Aguardando') : __('Cancelado')) ?></td>
                        <td class="text-right text-nowrap"><?= $this->Number->currency($saque->total, 'BRL') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
