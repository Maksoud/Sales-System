<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/clients.ctp */

$semCompra = ['pedidos' => 0, 'total' => 0, 'ultimo' => null];
$soma = $qtdPedidos = 0;
foreach ($clientes as $cliente) {
    $compra = isset($compras[$cliente->id]) ? $compras[$cliente->id] : $semCompra;
    $soma += $compra['total'];
    $qtdPedidos += $compra['pedidos'];
}
$vazio = '<span class="ss-muted">—</span>';
?>

<?= $this->element('report-header', ['titulo' => __('Relatório de clientes'), 'periodo' => $periodo]) ?>

<?php if (!$clientes): ?>
    <div class="ss-empty">
        <div class="ss-empty-icon"><i class="fa fa-users" aria-hidden="true"></i></div>
        <p class="ss-empty-title"><?= __('Nenhum cliente encontrado') ?></p>
        <p class="ss-empty-text"><?= __('Ajuste o período ou os filtros e gere o relatório de novo.') ?></p>
    </div>
<?php else: ?>
    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Clientes') ?> <span class="ss-count"><?= count($clientes) ?></span></h2>
        <div class="ss-table-wrap">
            <table class="table ss-table">
                <thead>
                    <tr>
                        <th scope="col" class="ss-col-id"><?= __('Código') ?></th>
                        <th scope="col"><?= __('Cliente') ?></th>
                        <th scope="col"><?= __('Contato') ?></th>
                        <th scope="col"><?= __('Associado responsável') ?></th>
                        <th scope="col" class="ss-num"><?= __('Pedidos') ?></th>
                        <th scope="col"><?= __('Última compra') ?></th>
                        <th scope="col" class="ss-num"><?= __('Total comprado') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <?php $compra = isset($compras[$cliente->id]) ? $compras[$cliente->id] : $semCompra; ?>
                        <tr>
                            <td class="ss-col-id"><span class="ss-id">#<?= str_pad($cliente->id, 6, '0', STR_PAD_LEFT) ?></span></td>
                            <td>
                                <span class="ss-cell-title"><?= h($cliente->nome) ?></span>
                                <span class="ss-cell-sub"><?= h($cliente->cidade) ?>/<?= h($cliente->estado) ?> · <?= __('desde {0}', $cliente->created->format('d/m/Y')) ?></span>
                            </td>
                            <td class="ss-text-sm">
                                <?= $cliente->telefone ? h($cliente->telefone) : $vazio ?>
                                <span class="ss-cell-sub"><?= h($cliente->email) ?></span>
                            </td>
                            <td><?= $cliente->Patrocinador ? h($cliente->Patrocinador->nome) : $vazio ?></td>
                            <td class="ss-num"><?= $this->Number->format($compra['pedidos']) ?></td>
                            <td class="ss-nowrap"><?= $compra['ultimo'] ? $compra['ultimo']->format('d/m/Y') : $vazio ?></td>
                            <td class="ss-num"><?= $this->Number->currency($compra['total'], 'BRL') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"><?= __('Total') ?></td>
                        <td class="ss-num"><?= $this->Number->format($qtdPedidos) ?></td>
                        <td></td>
                        <td class="ss-num"><?= $this->Number->currency($soma, 'BRL') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
<?php endif; ?>
