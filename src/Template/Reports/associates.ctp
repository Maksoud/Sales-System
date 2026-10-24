<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/associates.ctp */

$porPlano = [];
foreach ($associados as $associado) {
    $plano = $associado->plano->title;
    if (!isset($porPlano[$plano])) $porPlano[$plano] = ['A' => 0, 'P' => 0, 'I' => 0, 'C' => 0];
    $porPlano[$plano][$associado->status]++;
}
?>

<div class="container">
    <?= $this->element('report-header', ['titulo' => __('Relatório de Associados'), 'periodo' => $periodo]) ?>

    <?php if (!$associados): ?>
        <div class="alert alert-info"><?= __('Nenhum associado encontrado com os filtros informados.') ?></div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead><tr class="bg-gray"><th><?= __('Plano') ?></th><th class="text-center"><?= __('Ativos') ?></th><th class="text-center"><?= __('Pendentes') ?></th><th class="text-center"><?= __('Inativos') ?></th><th class="text-center"><?= __('Total') ?></th></tr></thead>
            <tbody>
                <?php foreach ($porPlano as $plano => $linha): ?>
                    <tr><td><?= h($plano) ?></td><td class="text-center"><?= $linha['A'] ?></td><td class="text-center"><?= $linha['P'] ?></td><td class="text-center"><?= $linha['I'] ?></td><th class="text-center"><?= array_sum($linha) ?></th></tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <table class="table table-bordered table-condensed">
            <thead>
                <tr class="bg-gray">
                    <th class="text-center">#</th>
                    <th><?= __('Cadastro') ?></th>
                    <th><?= __('Nome') ?></th>
                    <th><?= __('Login') ?></th>
                    <th><?= __('Plano') ?></th>
                    <th><?= __('Patrocinador') ?></th>
                    <th><?= __('Cidade/UF') ?></th>
                    <th><?= __('Telefone') ?></th>
                    <th><?= __('Status') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($associados as $associado): ?>
                    <tr>
                        <th class="text-center"><?= $i++ ?></th>
                        <td class="text-nowrap"><?= $associado->created->format('d/m/Y') ?></td>
                        <td><?= h($associado->nome) ?></td>
                        <td><?= h($associado->login) ?></td>
                        <td><?= h($associado->plano->title) ?></td>
                        <td><?= $associado->Patrocinador ? h($associado->Patrocinador->nome) : '-' ?></td>
                        <td><?= h($associado->cidade) ?>/<?= h($associado->estado) ?></td>
                        <td class="text-nowrap"><?= h($associado->telefone) ?></td>
                        <td><?= $this->Usuarios->status($associado->status) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
