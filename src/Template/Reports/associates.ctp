<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/associates.ctp */

$porPlano = [];
$totais = ['A' => 0, 'P' => 0, 'I' => 0, 'C' => 0];
foreach ($associados as $associado) {
    $plano = $associado->plano->title;
    if (!isset($porPlano[$plano])) $porPlano[$plano] = ['A' => 0, 'P' => 0, 'I' => 0, 'C' => 0];
    $porPlano[$plano][$associado->status]++;
    $totais[$associado->status]++;
}
$vazio = '<span class="ss-muted">—</span>';
?>

<?= $this->element('report-header', ['titulo' => __('Relatório de associados'), 'periodo' => $periodo]) ?>

<?php if (!$associados): ?>
    <div class="ss-empty">
        <div class="ss-empty-icon"><i class="fa fa-users" aria-hidden="true"></i></div>
        <p class="ss-empty-title"><?= __('Nenhum associado encontrado') ?></p>
        <p class="ss-empty-text"><?= __('Ajuste o período ou os filtros e gere o relatório de novo.') ?></p>
    </div>
<?php else: ?>
    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Resumo por plano') ?></h2>
        <div class="ss-table-wrap">
            <table class="table ss-table">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Plano') ?></th>
                        <th scope="col" class="ss-num"><?= __('Ativos') ?></th>
                        <th scope="col" class="ss-num"><?= __('Pendentes') ?></th>
                        <th scope="col" class="ss-num"><?= __('Inativos') ?></th>
                        <th scope="col" class="ss-num"><?= __('Total') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($porPlano as $plano => $linha): ?>
                        <tr>
                            <td><?= h($plano) ?></td>
                            <td class="ss-num"><?= $this->Number->format($linha['A']) ?></td>
                            <td class="ss-num"><?= $this->Number->format($linha['P']) ?></td>
                            <td class="ss-num"><?= $this->Number->format($linha['I']) ?></td>
                            <td class="ss-num"><strong><?= $this->Number->format(array_sum($linha)) ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><?= __('Total') ?></td>
                        <td class="ss-num"><?= $this->Number->format($totais['A']) ?></td>
                        <td class="ss-num"><?= $this->Number->format($totais['P']) ?></td>
                        <td class="ss-num"><?= $this->Number->format($totais['I']) ?></td>
                        <td class="ss-num"><?= $this->Number->format(count($associados)) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <section class="ss-report-section">
        <h2 class="ss-section-title"><?= __('Associados') ?> <span class="ss-count"><?= count($associados) ?></span></h2>
        <div class="ss-table-wrap">
            <table class="table ss-table">
                <thead>
                    <tr>
                        <th scope="col" class="ss-col-id"><?= __('Código') ?></th>
                        <th scope="col"><?= __('Associado') ?></th>
                        <th scope="col"><?= __('Plano') ?></th>
                        <th scope="col"><?= __('Patrocinador') ?></th>
                        <th scope="col"><?= __('Cidade/UF') ?></th>
                        <th scope="col"><?= __('Telefone') ?></th>
                        <th scope="col"><?= __('Cadastro') ?></th>
                        <th scope="col"><?= __('Status') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($associados as $associado): ?>
                        <tr>
                            <td class="ss-col-id"><span class="ss-id">#<?= str_pad($associado->id, 6, '0', STR_PAD_LEFT) ?></span></td>
                            <td>
                                <span class="ss-cell-title"><?= h($associado->nome) ?></span>
                                <span class="ss-cell-sub"><?= h($associado->login) ?></span>
                            </td>
                            <td><?= h($associado->plano->title) ?></td>
                            <td><?= $associado->Patrocinador ? h($associado->Patrocinador->nome) : $vazio ?></td>
                            <td><?= h($associado->cidade) ?>/<?= h($associado->estado) ?></td>
                            <td class="ss-nowrap"><?= $associado->telefone ? h($associado->telefone) : $vazio ?></td>
                            <td class="ss-nowrap"><?= $associado->created->format('d/m/Y') ?></td>
                            <td><?= $this->Usuarios->statusLabel($associado->status) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
<?php endif; ?>
