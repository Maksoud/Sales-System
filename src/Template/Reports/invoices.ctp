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
$totais = ['P' => 0, 'F' => 0, 'C' => 0, 'qtd' => 0];
foreach ($faturas as $fatura) {
    $tipo = $this->Faturas->tipo($fatura->tipo);
    if (!isset($resumo[$tipo])) $resumo[$tipo] = ['P' => 0, 'F' => 0, 'C' => 0, 'qtd' => 0];
    $resumo[$tipo][$fatura->status] += $fatura->total;
    $resumo[$tipo]['qtd']++;
    $totais[$fatura->status] += $fatura->total;
    $totais['qtd']++;
}
$vazio = '<span class="ss-muted">—</span>';
?>

<?= $this->element('report-header', ['titulo' => __('Relatório de faturas'), 'periodo' => $periodo]) ?>

<?php if (!$faturas): ?>
    <div class="ss-empty">
        <div class="ss-empty-icon"><i class="fa fa-file-text-o" aria-hidden="true"></i></div>
        <p class="ss-empty-title"><?= __('Nenhuma fatura encontrada') ?></p>
        <p class="ss-empty-text"><?= __('Ajuste o período ou os filtros e gere o relatório de novo.') ?></p>
    </div>
<?php else: ?>
    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Resumo por tipo') ?></h2>
        <div class="ss-table-wrap">
            <table class="table ss-table">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Tipo') ?></th>
                        <th scope="col" class="ss-num"><?= __('Faturas') ?></th>
                        <th scope="col" class="ss-num"><?= __('Pendentes') ?></th>
                        <th scope="col" class="ss-num"><?= __('Finalizadas') ?></th>
                        <th scope="col" class="ss-num"><?= __('Canceladas') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resumo as $tipo => $linha): ?>
                        <tr>
                            <td><?= h($tipo) ?></td>
                            <td class="ss-num"><?= $this->Number->format($linha['qtd']) ?></td>
                            <td class="ss-num"><?= $this->Number->currency($linha['P'], 'BRL') ?></td>
                            <td class="ss-num"><?= $this->Number->currency($linha['F'], 'BRL') ?></td>
                            <td class="ss-num"><?= $this->Number->currency($linha['C'], 'BRL') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><?= __('Total') ?></td>
                        <td class="ss-num"><?= $this->Number->format($totais['qtd']) ?></td>
                        <td class="ss-num"><?= $this->Number->currency($totais['P'], 'BRL') ?></td>
                        <td class="ss-num"><?= $this->Number->currency($totais['F'], 'BRL') ?></td>
                        <td class="ss-num"><?= $this->Number->currency($totais['C'], 'BRL') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Faturas') ?> <span class="ss-count"><?= count($faturas) ?></span></h2>
        <div class="ss-table-wrap">
            <table class="table ss-table">
                <thead>
                    <tr>
                        <th scope="col" class="ss-col-id"><?= __('Fatura') ?></th>
                        <th scope="col"><?= __('Associado') ?></th>
                        <th scope="col"><?= __('Pagamento') ?></th>
                        <th scope="col"><?= __('Vencimento') ?></th>
                        <th scope="col"><?= __('Pago em') ?></th>
                        <th scope="col"><?= __('Status') ?></th>
                        <th scope="col" class="ss-num"><?= __('Valor') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faturas as $fatura): ?>
                        <tr>
                            <td class="ss-col-id"><span class="ss-id">#<?= str_pad($fatura->id, 6, '0', STR_PAD_LEFT) ?></span></td>
                            <td>
                                <span class="ss-cell-title"><?= h($fatura->usuario->nome) ?></span>
                                <span class="ss-cell-sub"><?= h($this->Faturas->tipo($fatura->tipo)) ?> · <?= __('cadastro em {0}', $fatura->created->format('d/m/Y')) ?></span>
                            </td>
                            <td>
                                <?php if ($fatura->tipo == 'C'): ?>
                                    <?= $vazio ?>
                                <?php else: ?>
                                    <?= h($this->Faturas->forma_pagamento($fatura->forma_pagamento)) ?>
                                    <?php if ($fatura->qt_parcelas > 1): ?>
                                        <span class="ss-cell-sub"><?= h($this->Faturas->parcelas($fatura->parcela_atual, $fatura->qt_parcelas)) ?></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td class="ss-nowrap"><?= $fatura->vencimento->format('d/m/Y') ?></td>
                            <td class="ss-nowrap"><?= $fatura->pagamento ? $fatura->pagamento->format('d/m/Y') : $vazio ?></td>
                            <td><?= $this->Faturas->situacao($fatura) ?></td>
                            <td class="ss-num"><?= $this->Number->currency($fatura->total, 'BRL') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
<?php endif; ?>
