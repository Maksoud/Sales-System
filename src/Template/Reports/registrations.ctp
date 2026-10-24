<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/registrations.ctp */

//Uma série por plano, na cor do selo do plano (--ss-plan-*)
$tokens = [3 => '--ss-plan-sm', 4 => '--ss-plan-master', 5 => '--ss-plan-vip', 6 => '--ss-plan-cliente'];
$categorias = $series = [];
$totais = [3 => 0, 4 => 0, 5 => 0, 6 => 0, 'taxas' => 0];
foreach ($meses as $mes => $linha) {
    $categorias[] = $this->MyHtml->MesAbreviado((int)substr($mes, 5, 2)) . '/' . substr($mes, 2, 2);
    foreach ($totais as $chave => $valor) $totais[$chave] += $linha[$chave];
}
foreach ($tokens as $plano => $token) {
    $series[] = ['name' => $planos[$plano], 'token' => $token, 'data' => array_values(array_map(function ($l) use ($plano) { return $l[$plano]; }, $meses))];
}
?>

<?= $this->element('report-header', ['titulo' => __('Relatório de cadastros (últimos 12 meses)'), 'periodo' => [null, null]]) ?>

<section class="ss-report-section">
    <h2 class="ss-section-title"><?= __('Novos cadastros por mês') ?></h2>
    <div id="grafico-cadastros" class="ss-report-chart ss-report-chart--lg" role="img" aria-label="<?= __('Gráfico de novos cadastros por mês e plano') ?>"></div>
    <div class="ss-table-wrap">
        <table class="table ss-table">
            <thead>
                <tr>
                    <th scope="col"><?= __('Mês') ?></th>
                    <?php foreach ($tokens as $plano => $token): ?>
                        <th scope="col" class="ss-num"><?= h($planos[$plano]) ?></th>
                    <?php endforeach; ?>
                    <th scope="col" class="ss-num"><?= __('Total') ?></th>
                    <th scope="col" class="ss-num"><?= __('Taxas recebidas') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; foreach ($meses as $mes => $linha): ?>
                    <tr>
                        <td><?= $categorias[$i++] ?></td>
                        <?php foreach ($tokens as $plano => $token): ?>
                            <td class="ss-num"><?= $this->Number->format($linha[$plano]) ?></td>
                        <?php endforeach; ?>
                        <td class="ss-num"><strong><?= $this->Number->format($linha[3] + $linha[4] + $linha[5] + $linha[6]) ?></strong></td>
                        <td class="ss-num"><?= $this->Number->currency($linha['taxas'], 'BRL') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td><?= __('Total') ?></td>
                    <?php foreach ($tokens as $plano => $token): ?>
                        <td class="ss-num"><?= $this->Number->format($totais[$plano]) ?></td>
                    <?php endforeach; ?>
                    <td class="ss-num"><?= $this->Number->format($totais[3] + $totais[4] + $totais[5] + $totais[6]) ?></td>
                    <td class="ss-num"><?= $this->Number->currency($totais['taxas'], 'BRL') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

<script>
    Highcharts.chart('grafico-cadastros', {
        chart: { type: 'column' },
        xAxis: { categories: <?= json_encode($categorias) ?> },
        yAxis: { title: { text: '<?= __('Cadastros') ?>' }, allowDecimals: false },
        plotOptions: { column: { stacking: 'normal', borderWidth: 0 } },
        series: <?= json_encode($series) ?>.map(function (serie) { serie.color = ssCor(serie.token); return serie; })
    });
</script>
