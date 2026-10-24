<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/invoice-table.ctp */

/**
 * Tabela de faturas usada no Extrato Geral (gestão) e no Meu Extrato.
 *
 * Variáveis:
 *   $faturas     Lista de faturas
 *   $gerenciar   true = mostra associado e as ações de baixa/cancelamento (gestão)
 *   $mostrarUsuario Exibe a coluna do associado (padrão: igual a $gerenciar)
 */
$mostrarUsuario = isset($mostrarUsuario) ? $mostrarUsuario : $gerenciar;
?>

<div class="scrolling bottom-40 box-panel bg-white">
    <table class="table table-striped box" id="adjustable">
        <thead>
            <tr>
                <th class="text-nowrap"><?= __('#') ?></th>
                <th class="text-nowrap"><?= __('Cadastro') ?></th>
                <?php if ($mostrarUsuario): ?>
                    <th class="text-nowrap"><?= __('Associado') ?></th>
                <?php endif; ?>
                <th class="text-nowrap"><?= __('Tipo') ?></th>
                <th class="text-center"><?= __('Origem') ?></th>
                <th class="text-center"><?= __('Pedido') ?></th>
                <th class="text-nowrap"><?= __('Forma Pgto') ?></th>
                <th class="text-nowrap"><?= __('Vencimento') ?></th>
                <th class="text-nowrap"><?= __('Valor') ?></th>
                <th class="text-nowrap"><?= __('Status') ?></th>
                <th class="text-center"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($faturas as $fatura): ?>
                <?php
                    $numero  = str_pad($fatura->id, 6, '0', STR_PAD_LEFT);
                    $vencida = $this->Faturas->vencida($fatura);
                    //Saques e comissões são saídas da empresa / entradas do associado
                    $sinal   = '';
                    if (!$gerenciar && $fatura->tipo == 'S') $sinal = '- ';
                    if (!$gerenciar && $fatura->tipo == 'C') $sinal = '+ ';
                ?>
                <tr>
                    <td><?= $numero ?></td>
                    <td data-order="<?= $fatura->created->format('YmdHi') ?>"><?= $this->MyHtml->date($fatura->created) ?></td>
                    <?php if ($mostrarUsuario): ?>
                        <td>
                            <?= $this->Html->link(h($fatura->usuario->nome), ['controller' => 'Users', 'action' => 'view', $fatura->usuario->id], ['class' => 'btn_modal', 'data-title' => __('Dados do Associado')]) ?>
                            <br><small><?= $this->Usuarios->plano($fatura->usuario) ?></small>
                        </td>
                    <?php endif; ?>
                    <td>
                        <?= $this->Faturas->tipo($fatura->tipo) ?>
                        <?php if ($fatura->comissao): ?>
                            <br><small class="text-cinza"><?= $this->Comissoes->tipo($fatura->comissao->tipo) ?> (<?= $fatura->comissao->porcentagem ?>%)</small>
                        <?php endif; ?>
                    </td>
                    <td class="text-center"><?= $fatura->ParentFaturas ? $this->Html->link(str_pad($fatura->ParentFaturas->id, 6, '0', STR_PAD_LEFT), ['controller' => 'Invoices', 'action' => 'view', $fatura->ParentFaturas->id], ['class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Detalhes da Fatura')]) : '-' ?></td>
                    <td class="text-center"><?= $fatura->pedido ? $this->Html->link(str_pad($fatura->pedido->id, 6, '0', STR_PAD_LEFT), ['controller' => 'Orders', 'action' => 'view', $fatura->pedido->id], ['class' => 'btn_modal', 'data-title' => __('Detalhes do Pedido #') . str_pad($fatura->pedido->id, 6, '0', STR_PAD_LEFT)]) : '-' ?></td>
                    <td>
                        <?= $fatura->tipo == 'C' ? '<small class="text-cinza">' . __('Crédito em saldo') . '</small>' : $this->Faturas->forma_pagamento($fatura->forma_pagamento) ?>
                        <?= $fatura->qt_parcelas > 1 ? '<small>(' . $fatura->parcela_atual . '/' . $fatura->qt_parcelas . ')</small>' : '' ?>
                    </td>
                    <td data-order="<?= $fatura->vencimento->format('Ymd') ?>">
                        <span class="<?= $fatura->status != 'P' ? 'text-cinza' : ($vencida ? 'text-danger' : 'text-info') ?>">
                            <?= $this->MyHtml->tinyDate($fatura->vencimento) ?>
                        </span>
                        <?php if ($vencida): ?>
                            <br><small class="label label-danger"><?= __('vencida') ?></small>
                        <?php endif; ?>
                    </td>
                    <td class="text-nowrap" data-order="<?= $fatura->total ?>"><?= $sinal . $this->Number->currency($fatura->total, 'BRL') ?></td>
                    <td>
                        <?php if ($fatura->pedido && $fatura->pedido->status == 'V'): ?>
                            <span class="label label-default"><?= __('Calculando...') ?></span>
                        <?php elseif ($fatura->tipo == 'C' && $fatura->status == 'P'): ?>
                            <span class="label label-primary" title="<?= __('Liberada em') ?> <?= $fatura->vencimento->format('d/m/Y') ?>"><?= __('Bloqueada') ?></span>
                        <?php else: ?>
                            <?= $this->Faturas->statusLabel($fatura->status) ?>
                        <?php endif; ?>
                        <?php if ($fatura->boleto): ?>
                            <i class="fa fa-barcode" aria-hidden="true" title="<?= __('Boleto emitido') ?>"></i>
                        <?php endif; ?>
                    </td>
                    <td class="col-xs-1">
                        <?= $this->Html->link('<i class="fa fa-eye"></i> ' . __('Visualizar'), ['controller' => 'Invoices', 'action' => 'view', $fatura->id], ['class' => 'btn btn-default btn-block btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Detalhes da Fatura'), 'escape' => false]) ?>

                        <?php if ($gerenciar && $fatura->status == 'P' && in_array($fatura->tipo, ['T', 'P', 'S'])): ?>
                            <?= $this->Form->postLink('<i class="fa fa-check"></i> ' . ($fatura->tipo == 'S' ? __('Pagar Saque') : __('Baixar')), ['controller' => 'Invoices', 'action' => 'settle', $fatura->id], ['confirm' => __('Confirmar o pagamento da fatura {0}?', $numero), 'class' => 'top-5 btn btn-primary btn-block', 'escape' => false]) ?>
                            <?= $this->Form->postLink('<i class="fa fa-ban"></i> ' . __('Cancelar'), ['controller' => 'Invoices', 'action' => 'cancel', $fatura->id], ['confirm' => __('Tem certeza que deseja cancelar a fatura {0}?', $numero), 'class' => 'top-5 btn btn-danger btn-block', 'escape' => false]) ?>
                        <?php elseif (!$gerenciar && $fatura->status == 'P' && in_array($fatura->tipo, ['T', 'P']) && !($fatura->pedido && $fatura->pedido->status == 'V')): ?>
                            <?= $this->Html->link('<i class="fa fa-usd"></i> ' . __('Pagar agora'), ['controller' => 'Invoices', 'action' => 'bankDetails', $fatura->id], ['class' => 'top-5 btn btn-warning btn-block btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Dados para Pagamento'), 'escape' => false]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
