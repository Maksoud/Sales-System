<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/balances.ctp */

$totais = ['disponivel' => 0, 'bloqueado' => 0, 'sacado' => 0];
foreach ($saldos as $saldo) {
    foreach ($totais as $chave => $valor) $totais[$chave] += $saldo[$chave];
}
?>

<?= $this->element('report-header', ['titulo' => __('Relatório de saldos dos associados'), 'periodo' => [null, null]]) ?>

<?php if (!$saldos): ?>
    <div class="ss-empty">
        <div class="ss-empty-icon"><i class="fa fa-money" aria-hidden="true"></i></div>
        <p class="ss-empty-title"><?= __('Nenhum associado encontrado') ?></p>
        <p class="ss-empty-text"><?= __('Ajuste os filtros e gere o relatório de novo.') ?></p>
    </div>
<?php else: ?>
    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Resumo') ?></h2>
        <div class="ss-grid-stats">
            <div class="ss-stat ss-tone-success">
                <span class="ss-stat-icon"><i class="fa fa-money" aria-hidden="true"></i></span>
                <span class="ss-stat-label"><?= __('Disponível') ?></span>
                <span class="ss-stat-value"><?= $this->Number->currency($totais['disponivel'], 'BRL') ?></span>
            </div>
            <div class="ss-stat ss-tone-warning">
                <span class="ss-stat-icon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                <span class="ss-stat-label"><?= __('Bloqueado') ?></span>
                <span class="ss-stat-value"><?= $this->Number->currency($totais['bloqueado'], 'BRL') ?></span>
            </div>
            <div class="ss-stat ss-tone-neutral">
                <span class="ss-stat-icon"><i class="fa fa-check" aria-hidden="true"></i></span>
                <span class="ss-stat-label"><?= __('Já sacado') ?></span>
                <span class="ss-stat-value"><?= $this->Number->currency($totais['sacado'], 'BRL') ?></span>
            </div>
        </div>
    </section>

    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Saldo por associado') ?> <span class="ss-count"><?= count($saldos) ?></span></h2>
        <div class="ss-table-wrap">
            <table class="table ss-table">
                <thead>
                    <tr>
                        <th scope="col" class="ss-col-id"><?= __('Código') ?></th>
                        <th scope="col"><?= __('Associado') ?></th>
                        <th scope="col"><?= __('Plano') ?></th>
                        <th scope="col" class="ss-num"><?= __('Disponível') ?></th>
                        <th scope="col" class="ss-num"><?= __('Bloqueado') ?></th>
                        <th scope="col" class="ss-num"><?= __('Já sacado') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($saldos as $id => $saldo): ?>
                        <tr>
                            <td class="ss-col-id"><span class="ss-id">#<?= str_pad($id, 6, '0', STR_PAD_LEFT) ?></span></td>
                            <td><span class="ss-cell-title"><?= h($associados[$id]->nome) ?></span></td>
                            <td><?= h($associados[$id]->plano->title) ?></td>
                            <td class="ss-num"><?= $this->Number->currency($saldo['disponivel'], 'BRL') ?></td>
                            <td class="ss-num"><?= $this->Number->currency($saldo['bloqueado'], 'BRL') ?></td>
                            <td class="ss-num"><?= $this->Number->currency($saldo['sacado'], 'BRL') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><?= __('Total') ?></td>
                        <td class="ss-num"><?= $this->Number->currency($totais['disponivel'], 'BRL') ?></td>
                        <td class="ss-num"><?= $this->Number->currency($totais['bloqueado'], 'BRL') ?></td>
                        <td class="ss-num"><?= $this->Number->currency($totais['sacado'], 'BRL') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
<?php endif; ?>
