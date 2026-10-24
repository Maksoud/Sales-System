<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/commissions.ctp */

$porTipo = [];
$totais = ['liberado' => 0, 'bloqueado' => 0];
foreach ($faturas as $fatura) {
    $tipo = $this->Comissoes->tipo($fatura->comissao->tipo);
    if (!isset($porTipo[$tipo])) $porTipo[$tipo] = ['qtd' => 0, 'liberado' => 0, 'bloqueado' => 0];
    $chave = $fatura->status == 'F' ? 'liberado' : 'bloqueado';
    $porTipo[$tipo]['qtd']++;
    $porTipo[$tipo][$chave] += $fatura->total;
    $totais[$chave] += $fatura->total;
}
$soma = $totais['liberado'] + $totais['bloqueado'];
?>

<?= $this->element('report-header', ['titulo' => __('Relatório de comissões'), 'periodo' => $periodo]) ?>

<?php if (!$faturas): ?>
    <div class="ss-empty">
        <div class="ss-empty-icon"><i class="fa fa-handshake-o" aria-hidden="true"></i></div>
        <p class="ss-empty-title"><?= __('Nenhuma comissão encontrada') ?></p>
        <p class="ss-empty-text"><?= __('Ajuste o período ou os filtros e gere o relatório de novo.') ?></p>
    </div>
<?php else: ?>
    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Resumo por tipo') ?></h2>
        <div class="ss-report-summary">
            <div class="ss-table-wrap">
                <table class="table ss-table">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('Tipo') ?></th>
                            <th scope="col" class="ss-num"><?= __('Qtd.') ?></th>
                            <th scope="col" class="ss-num"><?= __('Liberado') ?></th>
                            <th scope="col" class="ss-num"><?= __('Bloqueado') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($porTipo as $tipo => $linha): ?>
                            <tr>
                                <td><?= h($tipo) ?></td>
                                <td class="ss-num"><?= $this->Number->format($linha['qtd']) ?></td>
                                <td class="ss-num"><?= $this->Number->currency($linha['liberado'], 'BRL') ?></td>
                                <td class="ss-num"><?= $this->Number->currency($linha['bloqueado'], 'BRL') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><?= __('Total') ?></td>
                            <td class="ss-num"><?= $this->Number->format(count($faturas)) ?></td>
                            <td class="ss-num"><?= $this->Number->currency($totais['liberado'], 'BRL') ?></td>
                            <td class="ss-num"><?= $this->Number->currency($totais['bloqueado'], 'BRL') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div id="grafico-tipos" class="ss-report-chart" role="img" aria-label="<?= __('Gráfico do valor das comissões por tipo') ?>"></div>
        </div>
    </section>

    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Comissões') ?> <span class="ss-count"><?= count($faturas) ?></span></h2>
        <div class="ss-table-wrap">
            <table class="table ss-table">
                <thead>
                    <tr>
                        <th scope="col" class="ss-col-id"><?= __('Fatura') ?></th>
                        <th scope="col"><?= __('Data') ?></th>
                        <th scope="col"><?= __('Beneficiário') ?></th>
                        <th scope="col"><?= __('Comissão') ?></th>
                        <th scope="col"><?= __('Origem') ?></th>
                        <th scope="col"><?= __('Status') ?></th>
                        <th scope="col" class="ss-num"><?= __('Valor') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faturas as $fatura): ?>
                        <tr>
                            <td class="ss-col-id"><span class="ss-id">#<?= str_pad($fatura->id, 6, '0', STR_PAD_LEFT) ?></span></td>
                            <td class="ss-nowrap"><?= $fatura->created->format('d/m/Y') ?></td>
                            <td>
                                <span class="ss-cell-title"><?= h($fatura->usuario->nome) ?></span>
                                <span class="ss-cell-sub"><?= h($fatura->usuario->plano->title) ?></span>
                            </td>
                            <td>
                                <?= h($this->Comissoes->tipo($fatura->comissao->tipo)) ?>
                                <span class="ss-cell-sub"><?= $this->Number->toPercentage($fatura->comissao->porcentagem, 1) ?></span>
                            </td>
                            <td>
                                <?= h($fatura->ParentFaturas->usuario->nome) ?>
                                <span class="ss-cell-sub"><?= __('Fatura') ?> <span class="ss-id">#<?= str_pad($fatura->faturas_id, 6, '0', STR_PAD_LEFT) ?></span></span>
                            </td>
                            <td><?= $this->Comissoes->statusLabel($fatura->status) ?></td>
                            <td class="ss-num"><?= $this->Number->currency($fatura->total, 'BRL') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6"><?= __('Valor total') ?></td>
                        <td class="ss-num"><?= $this->Number->currency($soma, 'BRL') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <script>
        Highcharts.chart('grafico-tipos', {
            chart: { type: 'pie' },
            tooltip: { pointFormat: 'R$ {point.y:,.2f}' },
            plotOptions: { pie: { innerSize: '55%', dataLabels: { enabled: false }, showInLegend: true } },
            series: [{ name: '<?= __('Valor') ?>', data: <?= json_encode(array_map(function ($t, $l) { return ['name' => $t, 'y' => round($l['liberado'] + $l['bloqueado'], 2)]; }, array_keys($porTipo), $porTipo)) ?> }]
        });
    </script>
<?php endif; ?>
