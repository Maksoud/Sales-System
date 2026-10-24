<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/payments.ctp */

$totais = ['P' => 0, 'F' => 0, 'C' => 0];
$qtd    = ['P' => 0, 'F' => 0, 'C' => 0];
foreach ($saques as $saque) {
    $totais[$saque->status] += $saque->total;
    $qtd[$saque->status]++;
}
$vazio = '<span class="ss-muted">—</span>';
?>

<?= $this->element('report-header', ['titulo' => __('Relatório de pagamentos de comissões'), 'periodo' => $periodo]) ?>

<?php if (!$saques): ?>
    <div class="ss-empty">
        <div class="ss-empty-icon"><i class="fa fa-money" aria-hidden="true"></i></div>
        <p class="ss-empty-title"><?= __('Nenhum saque encontrado') ?></p>
        <p class="ss-empty-text"><?= __('Ajuste o período ou os filtros e gere o relatório de novo.') ?></p>
    </div>
<?php else: ?>
    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Resumo') ?></h2>
        <div class="ss-grid-stats">
            <div class="ss-stat ss-tone-success">
                <span class="ss-stat-icon"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                <span class="ss-stat-label"><?= __('Pagos') ?></span>
                <span class="ss-stat-value"><?= $this->Number->currency($totais['F'], 'BRL') ?></span>
                <span class="ss-stat-meta"><?= __('{0} saque(s)', $qtd['F']) ?></span>
            </div>
            <div class="ss-stat ss-tone-warning">
                <span class="ss-stat-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                <span class="ss-stat-label"><?= __('Aguardando pagamento') ?></span>
                <span class="ss-stat-value"><?= $this->Number->currency($totais['P'], 'BRL') ?></span>
                <span class="ss-stat-meta"><?= __('{0} saque(s)', $qtd['P']) ?></span>
            </div>
            <div class="ss-stat ss-tone-neutral">
                <span class="ss-stat-icon"><i class="fa fa-ban" aria-hidden="true"></i></span>
                <span class="ss-stat-label"><?= __('Cancelados') ?></span>
                <span class="ss-stat-value"><?= $this->Number->currency($totais['C'], 'BRL') ?></span>
                <span class="ss-stat-meta"><?= __('{0} saque(s)', $qtd['C']) ?></span>
            </div>
        </div>
    </section>

    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Saques') ?> <span class="ss-count"><?= count($saques) ?></span></h2>
        <div class="ss-table-wrap">
            <table class="table ss-table">
                <thead>
                    <tr>
                        <th scope="col" class="ss-col-id"><?= __('Fatura') ?></th>
                        <th scope="col"><?= __('Solicitado em') ?></th>
                        <th scope="col"><?= __('Associado') ?></th>
                        <th scope="col"><?= __('Dados bancários') ?></th>
                        <th scope="col"><?= __('Pago em') ?></th>
                        <th scope="col"><?= __('Status') ?></th>
                        <th scope="col" class="ss-num"><?= __('Valor') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($saques as $saque): ?>
                        <tr>
                            <td class="ss-col-id"><span class="ss-id">#<?= str_pad($saque->id, 6, '0', STR_PAD_LEFT) ?></span></td>
                            <td class="ss-nowrap"><?= $saque->created->format('d/m/Y') ?></td>
                            <td>
                                <span class="ss-cell-title"><?= h($saque->usuario->nome) ?></span>
                                <span class="ss-cell-sub"><?= h($saque->usuario->plano->title) ?></span>
                            </td>
                            <td class="ss-text-sm">
                                <?= h($saque->usuario->banco) ?>
                                <span class="ss-cell-sub ss-mono"><?= __('Ag.') ?> <?= h($saque->usuario->agencia) ?> · <?= __('C/C') ?> <?= h($saque->usuario->conta) ?></span>
                            </td>
                            <td class="ss-nowrap"><?= $saque->pagamento ? $saque->pagamento->format('d/m/Y') : $vazio ?></td>
                            <td><?= $this->Faturas->saqueLabel($saque->status) ?></td>
                            <td class="ss-num"><?= $this->Number->currency($saque->total, 'BRL') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6"><?= __('Valor total') ?></td>
                        <td class="ss-num"><?= $this->Number->currency(array_sum($totais), 'BRL') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
<?php endif; ?>
