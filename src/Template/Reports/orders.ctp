<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/orders.ctp */

//Resumo por status (na ordem do fluxo) e totais
$porStatus = array_fill_keys(array_keys($this->Pedidos->statusLista()), ['qtd' => 0, 'valor' => 0]);
$soma = $frete = 0;
foreach ($pedidos as $pedido) {
    $porStatus[$pedido->status]['qtd']++;
    $porStatus[$pedido->status]['valor'] += $pedido->total;
    $soma  += $pedido->total;
    $frete += $pedido->valor_frete;
}
$porStatus = array_filter($porStatus, function ($linha) { return $linha['qtd'] > 0; });
$vazio = '<span class="ss-muted">—</span>';
?>

<?= $this->element('report-header', ['titulo' => __('Relatório de pedidos'), 'periodo' => $periodo]) ?>

<?php if (!$pedidos): ?>
    <div class="ss-empty">
        <div class="ss-empty-icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
        <p class="ss-empty-title"><?= __('Nenhum pedido encontrado') ?></p>
        <p class="ss-empty-text"><?= __('Ajuste o período ou os filtros e gere o relatório de novo.') ?></p>
    </div>
<?php else: ?>
    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Resumo por status') ?></h2>
        <div class="ss-report-summary">
            <div class="ss-table-wrap">
                <table class="table ss-table">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('Status') ?></th>
                            <th scope="col" class="ss-num"><?= __('Pedidos') ?></th>
                            <th scope="col" class="ss-num"><?= __('Valor') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($porStatus as $status => $linha): ?>
                            <tr>
                                <td><?= $this->Pedidos->statusLabel($status) ?></td>
                                <td class="ss-num"><?= $this->Number->format($linha['qtd']) ?></td>
                                <td class="ss-num"><?= $this->Number->currency($linha['valor'], 'BRL') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><?= __('Total') ?></td>
                            <td class="ss-num"><?= $this->Number->format(count($pedidos)) ?></td>
                            <td class="ss-num"><?= $this->Number->currency($soma, 'BRL') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div id="grafico-status" class="ss-report-chart" role="img" aria-label="<?= __('Gráfico de pedidos por status') ?>"></div>
        </div>
    </section>

    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Pedidos') ?> <span class="ss-count"><?= count($pedidos) ?></span></h2>
        <div class="ss-table-wrap">
            <table class="table ss-table">
                <thead>
                    <tr>
                        <th scope="col" class="ss-col-id"><?= __('Pedido') ?></th>
                        <th scope="col"><?= __('Data') ?></th>
                        <th scope="col"><?= __('Associado') ?></th>
                        <th scope="col"><?= __('Itens') ?></th>
                        <th scope="col"><?= __('Status') ?></th>
                        <th scope="col" class="ss-num"><?= __('Frete') ?></th>
                        <th scope="col" class="ss-num"><?= __('Total') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td class="ss-col-id"><span class="ss-id">#<?= str_pad($pedido->id, 6, '0', STR_PAD_LEFT) ?></span></td>
                            <td class="ss-nowrap"><?= $pedido->created->format('d/m/Y') ?></td>
                            <td>
                                <span class="ss-cell-title"><?= h($pedido->usuario->nome) ?></span>
                                <span class="ss-cell-sub">
                                    <?= h($pedido->usuario->plano->title) ?><?= $pedido->tipo != 'N' ? ' · ' . h($this->Pedidos->tipo($pedido->tipo)) : '' ?>
                                </span>
                            </td>
                            <td class="ss-text-sm">
                                <?php foreach ($pedido->pedidos_produtos as $item): ?>
                                    <span class="ss-nowrap"><?= $this->Number->format($item->quantidade) ?> × <?= h($item->produto->title) ?></span><br>
                                <?php endforeach; ?>
                            </td>
                            <td><?= $this->Pedidos->statusLabel($pedido->status) ?></td>
                            <td class="ss-num"><?= $pedido->valor_frete ? $this->Number->currency($pedido->valor_frete, 'BRL') : $vazio ?></td>
                            <td class="ss-num"><?= $this->Number->currency($pedido->total, 'BRL') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5"><?= __('Total') ?></td>
                        <td class="ss-num"><?= $this->Number->currency($frete, 'BRL') ?></td>
                        <td class="ss-num"><?= $this->Number->currency($soma, 'BRL') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <script>
        Highcharts.chart('grafico-status', {
            chart: { type: 'pie' },
            tooltip: { pointFormat: '{point.y} <?= __('pedido(s)') ?>' },
            plotOptions: { pie: { innerSize: '55%', dataLabels: { enabled: false }, showInLegend: true } },
            series: [{ name: '<?= __('Pedidos') ?>', data: <?= json_encode(array_map(function ($s, $l) { return ['name' => $this->Pedidos->status($s), 'y' => $l['qtd']]; }, array_keys($porStatus), $porStatus)) ?> }]
        });
    </script>
<?php endif; ?>
