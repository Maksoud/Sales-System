<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Invoices/view.ctp */

$this->layout = 'ajax';
$numero = function ($id) { return str_pad($id, 6, '0', STR_PAD_LEFT); };
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <label class="control-label"><?= __('Fatura Nº') ?></label>
            <div class="input-group">
                <div class="input-group-addon">#</div>
                <div class="form-control"><?= $numero($fatura->id) ?></div>
            </div>
            <small><?= __('criada em') ?> <?= $this->MyHtml->date($fatura->created) ?></small>
        </div>

        <div class="col-xs-12 text-center">
            <hr>
            <?php if ($fatura->status == 'P'): ?>
                <h4 class="bottom-0"><?= $this->Number->currency($fatura->total, 'BRL') ?></h4>
                <small>
                    <?php if ($fatura->tipo != 'C'): ?>
                        <?= $this->Faturas->forma_pagamento($fatura->forma_pagamento) ?>
                        <?= $fatura->qt_parcelas > 1 ? '- ' . $this->Faturas->parcelas($fatura->parcela_atual, $fatura->qt_parcelas) : '' ?><br>
                    <?php endif; ?>
                    <?= $fatura->valor_frete > 0 ? __('Frete:') . ' ' . $this->Number->currency($fatura->valor_frete, 'BRL') . '<br>' : '' ?>
                    <?= $fatura->tipo == 'C' ? __('liberada em') : __('vencimento em') ?> <?= $this->MyHtml->date($fatura->vencimento) ?>
                </small>
                <h4>
                    <?php if ($fatura->tipo == 'C'): ?>
                        <span class="label label-primary"><?= __('Bloqueada') ?></span>
                    <?php elseif ($this->Faturas->vencida($fatura)): ?>
                        <span class="label label-danger"><?= __('Vencida') ?></span>
                    <?php else: ?>
                        <span class="label label-warning"><?= __('Pendente') ?></span>
                    <?php endif; ?>
                </h4>
            <?php elseif ($fatura->status == 'F'): ?>
                <div class="alert alert-success">
                    <h4 class="bottom-0"><?= $this->Number->currency($fatura->total, 'BRL') ?></h4>
                    <small>
                        <?= $fatura->tipo == 'C' ? __('Crédito em saldo') : $this->Faturas->forma_pagamento($fatura->forma_pagamento) ?>
                        <?= $fatura->qt_parcelas > 1 ? '- ' . $this->Faturas->parcelas($fatura->parcela_atual, $fatura->qt_parcelas) : '' ?><br>
                        <?= $fatura->tipo == 'C' ? __('liberada em') : __('paga em') ?> <?= $this->MyHtml->date($fatura->pagamento) ?>
                    </small>
                    <h4><span class="label label-primary"><?= $fatura->tipo == 'C' ? __('Liberada') : __('Paga') ?></span></h4>
                </div>
            <?php else: ?>
                <h4><span class="label label-danger"><?= __('Cancelada') ?></span></h4>
                <small><?= __('Era de') ?> <?= $this->Number->currency($fatura->total, 'BRL') ?>, <?= __('com vencimento em') ?> <?= $this->MyHtml->date($fatura->vencimento) ?></small>
            <?php endif; ?>
        </div>

        <div class="col-xs-12">
            <hr>
            <?php if ($fatura->tipo == 'C'): ?>
                <?= __('Fatura do tipo') ?> <span class="label label-warning"><?= __('Comissão') ?></span><br>
                <?= __('Beneficiário:') ?> <span class="label label-default"><?= h($fatura->usuario->nome) ?></span><br>
                <?= $this->Comissoes->tipo($fatura->comissao->tipo) ?> (<?= $fatura->comissao->porcentagem ?>%)<br>
                <?= __('Fatura de origem:') ?> <span class="label label-default"><?= $numero($fatura->faturas_id) ?></span>
            <?php elseif ($fatura->tipo == 'S'): ?>
                <?= __('Fatura do tipo') ?> <span class="label label-primary"><?= __('Saque') ?></span><br>
                <?= __('Solicitado por') ?> <span class="label label-default"><?= h($fatura->usuario->nome) ?></span>
            <?php elseif ($fatura->tipo == 'P'): ?>
                <?= __('Fatura do tipo') ?> <span class="label label-success"><?= __('Pedido') ?></span><br>
                <?= __('Referente ao pedido') ?> <span class="label label-default"><?= $numero($fatura->pedidos_id) ?></span><br>
                <?= __('Feito por') ?> <span class="label label-default"><?= h($fatura->usuario->nome) ?></span>
            <?php elseif ($fatura->tipo == 'T'): ?>
                <?= __('Fatura do tipo') ?> <span class="label label-info"><?= __('Taxa de inscrição') ?></span><br>
                <?= __('Cadastro de') ?> <span class="label label-default"><?= h($fatura->usuario->nome) ?></span>
                <?= __('no plano') ?> <span class="label label-default"><?= h($fatura->usuario->plano->title) ?></span>
            <?php endif; ?>

            <?php if ($fatura->obs): ?>
                <hr>
                <small><strong><?= __('Observações:') ?></strong><br><?= nl2br(h($fatura->obs)) ?></small>
            <?php endif; ?>

            <?php if ($fatura->status == 'P' && $fatura->boleto): ?>
                <hr>
                <div class="text-center">
                    <i class="fa fa-barcode fa-2x" aria-hidden="true"></i><br>
                    <small><?= __('Boleto emitido e enviado para o e-mail do associado.') ?></small>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
