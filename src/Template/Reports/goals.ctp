<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/goals.ctp */

$atingidas = 0;
foreach ($linhas as $linha) {
    if ($linha['contador'] >= $linha['meta']->meta) $atingidas++;
}
?>

<?= $this->element('report-header', ['titulo' => __('Relatório de metas dos associados'), 'periodo' => [null, null]]) ?>

<?php if (!$linhas): ?>
    <div class="ss-empty">
        <div class="ss-empty-icon"><i class="fa fa-bullseye" aria-hidden="true"></i></div>
        <p class="ss-empty-title"><?= __('Nenhuma meta encontrada') ?></p>
        <p class="ss-empty-text"><?= __('Ajuste os filtros e gere o relatório de novo.') ?></p>
    </div>
<?php else: ?>
    <section class="ss-report-section">
        <h2 class="ss-section-title">
            <?= __('Metas em andamento') ?> <span class="ss-count"><?= count($linhas) ?></span>
            <span class="ss-muted"><?= __('{0} atingida(s)', $atingidas) ?></span>
        </h2>
        <div class="ss-table-wrap">
            <table class="table ss-table">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Associado') ?></th>
                        <th scope="col"><?= __('Meta') ?></th>
                        <th scope="col"><?= __('Prêmio') ?></th>
                        <th scope="col"><?= __('Progresso') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($linhas as $linha): ?>
                        <?php
                            $meta = $linha['meta'];
                            $porcentagem = round($linha['contador'] * 100 / $meta->meta);
                            $objetivo = $meta->tipo == 'I'
                                ? __('Indicar {0} {1}', $meta->meta, $planos[$meta->para_planos_id])
                                : __('Vender {0} × {1}', $meta->meta, $produtos[$meta->produtos_id]);
                        ?>
                        <tr>
                            <td>
                                <span class="ss-cell-title"><?= h($linha['usuario']->nome) ?></span>
                                <span class="ss-cell-sub"><?= h($linha['usuario']->plano->title) ?></span>
                            </td>
                            <td>
                                <i class="fa fa-fw <?= $meta->tipo == 'I' ? 'fa-user-plus' : 'fa-shopping-cart' ?> ss-muted" aria-hidden="true"></i>
                                <?= h($objetivo) ?>
                            </td>
                            <td><?= $this->Number->format($meta->qtganha) ?> × <?= h($produtos[$meta->bonificacao_produtos_id]) ?></td>
                            <td>
                                <div class="ss-report-progress<?= $porcentagem >= 100 ? ' is-done' : '' ?>">
                                    <progress class="ss-progress" value="<?= min($porcentagem, 100) ?>" max="100"
                                              aria-label="<?= __('{0} de {1}', $linha['contador'], $meta->meta) ?>"><?= $porcentagem ?>%</progress>
                                    <span><?= $linha['contador'] ?>/<?= $meta->meta ?></span>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
<?php endif; ?>
