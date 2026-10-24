<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Reports/clients.ctp */
?>

<div class="container">
    <?= $this->element('report-header', ['titulo' => __('Relatório de Clientes'), 'periodo' => $periodo]) ?>

    <?php if (!$clientes): ?>
        <div class="alert alert-info"><?= __('Nenhum cliente encontrado com os filtros informados.') ?></div>
    <?php else: ?>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr class="bg-gray">
                    <th class="text-center">#</th>
                    <th><?= __('Cadastro') ?></th>
                    <th><?= __('Cliente') ?></th>
                    <th><?= __('Associado responsável') ?></th>
                    <th><?= __('Cidade/UF') ?></th>
                    <th><?= __('Contato') ?></th>
                    <th class="text-center"><?= __('Pedidos') ?></th>
                    <th><?= __('Última compra') ?></th>
                    <th class="text-right"><?= __('Total comprado') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; $soma = 0; foreach ($clientes as $cliente): ?>
                    <?php $compra = isset($compras[$cliente->id]) ? $compras[$cliente->id] : ['pedidos' => 0, 'total' => 0, 'ultimo' => null]; $soma += $compra['total']; ?>
                    <tr>
                        <th class="text-center"><?= $i++ ?></th>
                        <td class="text-nowrap"><?= $cliente->created->format('d/m/Y') ?></td>
                        <td><?= h($cliente->nome) ?></td>
                        <td><?= $cliente->Patrocinador ? h($cliente->Patrocinador->nome) : '-' ?></td>
                        <td><?= h($cliente->cidade) ?>/<?= h($cliente->estado) ?></td>
                        <td><small><?= h($cliente->telefone) ?><br><?= h($cliente->email) ?></small></td>
                        <td class="text-center"><?= $compra['pedidos'] ?></td>
                        <td class="text-nowrap"><?= $compra['ultimo'] ? $compra['ultimo']->format('d/m/Y') : '-' ?></td>
                        <td class="text-right text-nowrap"><?= $this->Number->currency($compra['total'], 'BRL') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr><th colspan="9" class="text-right font-16"><?= __('Total comprado:') ?> <?= $this->Number->currency($soma, 'BRL') ?></th></tr>
            </tbody>
        </table>
    <?php endif; ?>
</div>
