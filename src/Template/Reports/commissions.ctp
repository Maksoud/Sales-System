<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/commissions.ctp */

$porTipo = [];
$soma = 0;
foreach ($faturas as $fatura) {
    $tipo = $this->Comissoes->tipo($fatura->comissao->tipo);
    if (!isset($porTipo[$tipo])) $porTipo[$tipo] = ['qtd' => 0, 'liberado' => 0, 'bloqueado' => 0];
    $porTipo[$tipo]['qtd']++;
    $porTipo[$tipo][$fatura->status == 'F' ? 'liberado' : 'bloqueado'] += $fatura->total;
    $soma += $fatura->total;
}
?>

<div class="container">
    <?= $this->element('report-header', ['titulo' => __('Relatório de Comissões'), 'periodo' => $periodo]) ?>

    <?php if (!$faturas): ?>
        <div class="alert alert-info"><?= __('Nenhuma comissão encontrada com os filtros informados.') ?></div>
    <?php else: ?>
        <div class="row">
            <div class="col-xs-12 col-sm-7">
                <table class="table table-bordered">
                    <thead><tr class="bg-gray"><th><?= __('Tipo') ?></th><th class="text-center"><?= __('Qtd.') ?></th><th class="text-right"><?= __('Liberado') ?></th><th class="text-right"><?= __('Bloqueado') ?></th></tr></thead>
                    <tbody>
                        <?php foreach ($porTipo as $tipo => $linha): ?>
                            <tr>
                                <td><?= $tipo ?></td>
                                <td class="text-center"><?= $linha['qtd'] ?></td>
                                <td class="text-right"><?= $this->Number->currency($linha['liberado'], 'BRL') ?></td>
                                <td class="text-right"><?= $this->Number->currency($linha['bloqueado'], 'BRL') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr><th><?= __('Total') ?></th><th class="text-center"><?= count($faturas) ?></th><th colspan="2" class="text-right"><?= $this->Number->currency($soma, 'BRL') ?></th></tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 col-sm-5">
                <div id="grafico-tipos" style="height: 260px;"></div>
            </div>
        </div>

        <table class="table table-bordered table-condensed">
            <thead>
                <tr class="bg-gray">
                    <th class="text-center">#</th>
                    <th><?= __('Fatura') ?></th>
                    <th><?= __('Data') ?></th>
                    <th><?= __('Beneficiário') ?></th>
                    <th><?= __('Plano') ?></th>
                    <th><?= __('Tipo') ?></th>
                    <th class="text-center"><?= __('Origem') ?></th>
                    <th><?= __('Associado de origem') ?></th>
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
                        <td><?= h($fatura->usuario->plano->title) ?></td>
                        <td><?= $this->Comissoes->tipo($fatura->comissao->tipo) ?> (<?= $fatura->comissao->porcentagem ?>%)</td>
                        <td class="text-center"><?= str_pad($fatura->faturas_id, 6, '0', STR_PAD_LEFT) ?></td>
                        <td><?= h($fatura->ParentFaturas->usuario->nome) ?></td>
                        <td><?= $fatura->status == 'F' ? __('Liberada') : __('Bloqueada') ?></td>
                        <td class="text-right text-nowrap"><?= $this->Number->currency($fatura->total, 'BRL') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr><th colspan="10" class="text-right font-16"><?= __('Valor total:') ?> <?= $this->Number->currency($soma, 'BRL') ?></th></tr>
            </tbody>
        </table>

        <script>
            Highcharts.chart('grafico-tipos', {
                chart: { type: 'pie' }, title: { text: '<?= __('Comissões por tipo') ?>' }, credits: { enabled: false },
                tooltip: { pointFormat: 'R$ {point.y:.2f}' },
                series: [{ name: 'Valor', data: <?= json_encode(array_map(function ($t, $l) { return ['name' => $t, 'y' => round($l['liberado'] + $l['bloqueado'], 2)]; }, array_keys($porTipo), $porTipo)) ?> }]
            });
        </script>
    <?php endif; ?>
</div>
