<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/orders.ctp */

$porStatus = [];
$soma = 0;
foreach ($pedidos as $pedido) {
    $status = $this->Pedidos->status($pedido->status);
    if (!isset($porStatus[$status])) $porStatus[$status] = ['qtd' => 0, 'valor' => 0];
    $porStatus[$status]['qtd']++;
    $porStatus[$status]['valor'] += $pedido->total;
    $soma += $pedido->total;
}
?>

<div class="container">
    <?= $this->element('report-header', ['titulo' => __('Relatório de Pedidos'), 'periodo' => $periodo]) ?>

    <?php if (!$pedidos): ?>
        <div class="alert alert-info"><?= __('Nenhum pedido encontrado com os filtros informados.') ?></div>
    <?php else: ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <table class="table table-bordered">
                    <thead><tr class="bg-gray"><th><?= __('Status') ?></th><th class="text-center"><?= __('Pedidos') ?></th><th class="text-right"><?= __('Valor') ?></th></tr></thead>
                    <tbody>
                        <?php foreach ($porStatus as $status => $linha): ?>
                            <tr><td><?= $status ?></td><td class="text-center"><?= $linha['qtd'] ?></td><td class="text-right"><?= $this->Number->currency($linha['valor'], 'BRL') ?></td></tr>
                        <?php endforeach; ?>
                        <tr><th><?= __('Total') ?></th><th class="text-center"><?= count($pedidos) ?></th><th class="text-right"><?= $this->Number->currency($soma, 'BRL') ?></th></tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div id="grafico-status" style="height: 260px;"></div>
            </div>
        </div>

        <table class="table table-bordered table-condensed">
            <thead>
                <tr class="bg-gray">
                    <th class="text-center">#</th>
                    <th><?= __('Pedido') ?></th>
                    <th><?= __('Data') ?></th>
                    <th><?= __('Associado') ?></th>
                    <th><?= __('Plano') ?></th>
                    <th><?= __('Tipo') ?></th>
                    <th><?= __('Itens') ?></th>
                    <th><?= __('Status') ?></th>
                    <th class="text-right"><?= __('Frete') ?></th>
                    <th class="text-right"><?= __('Total') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($pedidos as $pedido): ?>
                    <tr>
                        <th class="text-center"><?= $i++ ?></th>
                        <td><?= str_pad($pedido->id, 6, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-nowrap"><?= $pedido->created->format('d/m/Y') ?></td>
                        <td><?= h($pedido->usuario->nome) ?></td>
                        <td><?= h($pedido->usuario->plano->title) ?></td>
                        <td><?= $this->Pedidos->tipo($pedido->tipo) ?></td>
                        <td><small><?php foreach ($pedido->pedidos_produtos as $item) echo $item->quantidade . 'x ' . h($item->produto->title) . '<br>'; ?></small></td>
                        <td><?= $this->Pedidos->status($pedido->status) ?></td>
                        <td class="text-right text-nowrap"><?= $this->Number->currency($pedido->valor_frete, 'BRL') ?></td>
                        <td class="text-right text-nowrap"><?= $this->Number->currency($pedido->total, 'BRL') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr><th colspan="10" class="text-right font-16"><?= __('Valor total:') ?> <?= $this->Number->currency($soma, 'BRL') ?></th></tr>
            </tbody>
        </table>

        <script>
            Highcharts.chart('grafico-status', {
                chart: { type: 'pie' }, title: { text: '<?= __('Pedidos por status') ?>' }, credits: { enabled: false },
                tooltip: { pointFormat: '{point.y} pedido(s)' },
                series: [{ name: 'Pedidos', data: <?= json_encode(array_map(function ($s, $l) { return ['name' => $s, 'y' => $l['qtd']]; }, array_keys($porStatus), $porStatus)) ?> }]
            });
        </script>
    <?php endif; ?>
</div>
