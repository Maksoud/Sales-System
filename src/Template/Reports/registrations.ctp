<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/registrations.ctp */

$categorias = $series = [];
foreach ($meses as $mes => $linha) {
    $categorias[] = $this->MyHtml->MesAbreviado((int)substr($mes, 5, 2)) . '/' . substr($mes, 2, 2);
}
foreach ([3, 4, 5, 6] as $plano) {
    $series[] = ['name' => $planos[$plano], 'data' => array_values(array_map(function ($l) use ($plano) { return $l[$plano]; }, $meses))];
}
?>

<div class="container">
    <?= $this->element('report-header', ['titulo' => __('Relatório de Cadastros (últimos 12 meses)'), 'periodo' => [null, null]]) ?>

    <div id="grafico-cadastros" style="height: 320px;" class="bottom-20"></div>

    <table class="table table-bordered table-condensed">
        <thead>
            <tr class="bg-gray">
                <th><?= __('Mês') ?></th>
                <?php foreach ([3, 4, 5, 6] as $plano): ?>
                    <th class="text-center"><?= h($planos[$plano]) ?></th>
                <?php endforeach; ?>
                <th class="text-center"><?= __('Total') ?></th>
                <th class="text-right"><?= __('Taxas recebidas') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; $totalTaxas = 0; foreach ($meses as $mes => $linha): $totalTaxas += $linha['taxas']; ?>
                <tr>
                    <td><?= $categorias[$i++] ?></td>
                    <?php foreach ([3, 4, 5, 6] as $plano): ?>
                        <td class="text-center"><?= $linha[$plano] ?></td>
                    <?php endforeach; ?>
                    <th class="text-center"><?= $linha[3] + $linha[4] + $linha[5] + $linha[6] ?></th>
                    <td class="text-right"><?= $this->Number->currency($linha['taxas'], 'BRL') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr><th colspan="6" class="text-right font-16"><?= __('Total em taxas:') ?></th><th class="text-right font-16"><?= $this->Number->currency($totalTaxas, 'BRL') ?></th></tr>
        </tbody>
    </table>
</div>

<script>
    Highcharts.chart('grafico-cadastros', {
        chart: { type: 'column' }, title: { text: '<?= __('Novos cadastros por mês') ?>' }, credits: { enabled: false },
        xAxis: { categories: <?= json_encode($categorias) ?> },
        yAxis: { title: { text: '<?= __('Cadastros') ?>' }, allowDecimals: false },
        plotOptions: { column: { stacking: 'normal' } },
        series: <?= json_encode($series) ?>
    });
</script>
