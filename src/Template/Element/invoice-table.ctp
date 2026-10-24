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
 * Fica dentro de um ss-card--flush; com a lista vazia, mostra o ss-empty.
 *
 * Variáveis:
 *   $faturas        Lista de faturas
 *   $gerenciar      true = ações de baixa/cancelamento (gestão)
 *   $mostrarUsuario Identifica a linha pelo associado (padrão: igual a $gerenciar)
 */
$mostrarUsuario = isset($mostrarUsuario) ? $mostrarUsuario : $gerenciar;
$vazio = '<span class="ss-muted">—</span>';
$numero = function ($id) { return str_pad($id, 6, '0', STR_PAD_LEFT); };
$abrirFatura = ['class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Detalhes da fatura'),
                'data-loading-text' => __('Carregando...')];
?>

<?php if (count($faturas)): ?>
<div class="ss-table-wrap">
    <table class="table ss-table ss-table--stack" id="adjustable">
        <thead>
            <tr>
                <th class="ss-col-id"><?= __('Código') ?></th>
                <th><?= $mostrarUsuario ? __('Associado') : __('Fatura') ?></th>
                <th><?= __('Pagamento') ?></th>
                <th><?= __('Vencimento') ?></th>
                <th class="ss-num"><?= __('Valor') ?></th>
                <th><?= __('Status') ?></th>
                <th class="ss-actions" data-orderable="false"><span class="sr-only"><?= __('Ações') ?></span></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($faturas as $fatura): ?>
            <?php
            $id = $numero($fatura->id);
            $emCalculo = $fatura->pedido && $fatura->pedido->status == 'V';

            //Saques e comissões são saídas da empresa / entradas do associado
            $sinal = $classe = '';
            if (!$gerenciar && $fatura->tipo == 'S') { $sinal = '− '; $classe = ' ss-neg'; }
            if (!$gerenciar && $fatura->tipo == 'C') { $sinal = '+ '; $classe = ' ss-pos'; }

            //Linha de apoio: tipo, detalhe da comissão e documento de referência
            $apoio = [];
            //Em faturas de pedido, o link "Pedido #..." já diz o tipo
            if ($mostrarUsuario && !($fatura->tipo == 'P' && $fatura->pedido)) $apoio[] = h($this->Faturas->tipo($fatura->tipo));
            if ($fatura->comissao) {
                $apoio[] = h($this->Comissoes->tipo($fatura->comissao->tipo)) . ' (' . h($fatura->comissao->porcentagem) . '%)';
            }
            //Comissões apontam para a fatura de origem; as demais, para o pedido
            if ($fatura->ParentFaturas) {
                $apoio[] = $this->Html->link(__('Origem #{0}', $numero($fatura->ParentFaturas->id)),
                        ['controller' => 'Invoices', 'action' => 'view', $fatura->ParentFaturas->id], $abrirFatura);
            } elseif ($fatura->pedido) {
                $apoio[] = $this->Html->link(__('Pedido #{0}', $numero($fatura->pedido->id)),
                        ['controller' => 'Orders', 'action' => 'view', $fatura->pedido->id],
                        ['class' => 'btn_modal', 'data-title' => __('Pedido #{0}', $numero($fatura->pedido->id)),
                         'data-loading-text' => __('Carregando...')]);
            }
            ?>
            <tr>
                <td class="ss-col-id" data-label="<?= __('Código') ?>" data-order="<?= $fatura->id ?>">
                    <span class="ss-id">#<?= $id ?></span>
                </td>
                <td class="ss-cell-primary">
                    <?= $this->Html->link($mostrarUsuario ? h($fatura->usuario->nome) : h($this->Faturas->tipo($fatura->tipo)),
                            ['controller' => 'Invoices', 'action' => 'view', $fatura->id],
                            ['class' => 'ss-cell-title btn_modal', 'escape' => false] + $abrirFatura) ?>
                    <?php if ($mostrarUsuario || $apoio): ?>
                        <span class="ss-cell-sub">
                            <?php if ($mostrarUsuario): ?><?= $this->Usuarios->plano($fatura->usuario) ?> <?php endif; ?>
                            <?= implode(' · ', $apoio) ?>
                        </span>
                    <?php endif; ?>
                </td>
                <td data-label="<?= __('Pagamento') ?>">
                    <?php if ($fatura->tipo == 'C'): ?>
                        <span class="ss-muted"><?= __('Crédito em saldo') ?></span>
                    <?php elseif ($fatura->forma_pagamento): ?>
                        <?= h($this->Faturas->forma_pagamento($fatura->forma_pagamento)) ?>
                        <?php if ($fatura->qt_parcelas > 1): ?>
                            <span class="ss-muted">(<?= $fatura->parcela_atual ?>/<?= $fatura->qt_parcelas ?>)</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <?= $vazio ?>
                    <?php endif; ?>
                </td>
                <td data-label="<?= __('Vencimento') ?>" data-order="<?= $fatura->vencimento->format('Ymd') ?>">
                    <span class="<?= $fatura->status != 'P' ? 'ss-muted' : '' ?>"><?= $this->MyHtml->tinyDate($fatura->vencimento) ?></span>
                </td>
                <td class="ss-num" data-label="<?= __('Valor') ?>" data-order="<?= $emCalculo ? -1 : $fatura->total ?>">
                    <?php if ($emCalculo): ?>
                        <span class="ss-muted"><?= __('Em cálculo') ?></span>
                    <?php else: ?>
                        <span class="ss-money<?= $classe ?>"><?= $sinal . $this->Number->currency($fatura->total, 'BRL') ?></span>
                    <?php endif; ?>
                </td>
                <td data-label="<?= __('Status') ?>">
                    <?= $this->Faturas->situacao($fatura) ?>
                    <?php if ($fatura->boleto): ?>
                        <i class="fa fa-barcode ss-muted" aria-hidden="true" title="<?= __('Boleto emitido') ?>"></i>
                        <span class="sr-only"><?= __('Boleto emitido') ?></span>
                    <?php endif; ?>
                </td>
                <td class="ss-actions">
                    <?php if ($gerenciar && $fatura->status == 'P' && in_array($fatura->tipo, ['T', 'P', 'S'])): ?>
                        <?= $this->Form->postLink('<i class="fa fa-check" aria-hidden="true"></i> ' . ($fatura->tipo == 'S' ? __('Pagar saque') : __('Baixar')),
                                ['controller' => 'Invoices', 'action' => 'settle', $fatura->id],
                                ['confirm' => __('Confirmar o pagamento da fatura #{0}?', $id),
                                 'class' => 'btn btn-sm ss-btn-ghost', 'escape' => false]) ?>
                    <?php elseif (!$gerenciar && $fatura->status == 'P' && in_array($fatura->tipo, ['T', 'P']) && !$emCalculo): ?>
                        <?= $this->Html->link('<i class="fa fa-university" aria-hidden="true"></i> ' . __('Pagar agora'),
                                ['controller' => 'Invoices', 'action' => 'bankDetails', $fatura->id],
                                ['class' => 'btn btn-sm ss-btn-ghost btn_modal', 'data-tamanho' => 'sm',
                                 'data-title' => __('Dados para pagamento'), 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                    <?php endif; ?>
                    <?php if ($mostrarUsuario): ?>
                        <?= $this->Html->link('<i class="fa fa-user" aria-hidden="true"></i>',
                                ['controller' => 'Users', 'action' => 'view', $fatura->usuario->id],
                                ['class' => 'btn btn-sm ss-btn-ghost ss-btn-icon btn_modal', 'title' => __('Dados do associado'),
                                 'aria-label' => __('Dados de {0}', $fatura->usuario->nome), 'data-title' => __('Dados do associado'),
                                 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                    <?php endif; ?>
                    <?php if ($gerenciar && $fatura->status == 'P' && in_array($fatura->tipo, ['T', 'P', 'S'])): ?>
                        <?= $this->Form->postLink('<i class="fa fa-ban" aria-hidden="true"></i>',
                                ['controller' => 'Invoices', 'action' => 'cancel', $fatura->id],
                                ['confirm' => __('Cancelar a fatura #{0}? Esta ação não pode ser desfeita.', $id),
                                 'class' => 'btn btn-sm ss-btn-danger-soft ss-btn-icon', 'title' => __('Cancelar fatura'),
                                 'aria-label' => __('Cancelar fatura #{0}', $id), 'escape' => false]) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<div class="ss-empty">
    <div class="ss-empty-icon"><i class="fa fa-file-text-o" aria-hidden="true"></i></div>
    <p class="ss-empty-title"><?= __('Nenhuma fatura encontrada') ?></p>
    <p class="ss-empty-text"><?= __('Ajuste os filtros ou escolha outro tipo ou status.') ?></p>
    <?= $this->Html->link(__('Limpar filtros'), ['action' => $this->request->getParam('action')], ['class' => 'btn btn-default']) ?>
</div>
<?php endif; ?>
