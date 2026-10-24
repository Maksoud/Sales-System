<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/goals.ctp */
?>

<div class="container">
    <?= $this->element('report-header', ['titulo' => __('Relatório de Metas dos Associados'), 'periodo' => [null, null]]) ?>

    <?php if (!$linhas): ?>
        <div class="alert alert-info"><?= __('Nenhuma meta encontrada com os filtros informados.') ?></div>
    <?php else: ?>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr class="bg-gray">
                    <th><?= __('Associado') ?></th>
                    <th><?= __('Plano') ?></th>
                    <th><?= __('Meta') ?></th>
                    <th class="text-center" style="width: 30%"><?= __('Progresso') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($linhas as $linha): ?>
                    <?php
                        $meta = $linha['meta'];
                        $porcentagem = round($linha['contador'] * 100 / $meta->meta);
                        $descricao = $meta->tipo == 'I'
                            ? __('Indicar {0} {1} para ganhar {2} {3}', $meta->meta, $planos[$meta->para_planos_id], $meta->qtganha, $produtos[$meta->bonificacao_produtos_id])
                            : __('Vender {0} {1} para ganhar {2} {3}', $meta->meta, $produtos[$meta->produtos_id], $meta->qtganha, $produtos[$meta->bonificacao_produtos_id]);
                    ?>
                    <tr>
                        <td><?= h($linha['usuario']->nome) ?></td>
                        <td><?= h($linha['usuario']->plano->title) ?></td>
                        <td><small><?= h($descricao) ?></small></td>
                        <td>
                            <div class="progress bottom-0">
                                <div class="progress-bar <?= $porcentagem >= 100 ? 'progress-bar-success' : '' ?>" style="width: <?= max($porcentagem, 8) ?>%; min-width: 3em;">
                                    <?= $linha['contador'] ?>/<?= $meta->meta ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
