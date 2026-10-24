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
$comissao = $fatura->tipo == 'C';
$vazio = '<span class="ss-muted">—</span>';
?>

<div class="ss-record-header">
    <div>
        <h3 class="ss-record-title">
            <?= __('Fatura') ?> <span class="ss-id">#<?= $numero($fatura->id) ?></span>
            <?= $this->Faturas->situacao($fatura) ?>
        </h3>
        <div class="ss-record-meta">
            <span><?= __('Criada em {0}', $this->MyHtml->date($fatura->created)) ?></span>
            <span><?= h($this->Faturas->tipo($fatura->tipo)) ?></span>
        </div>
    </div>
</div>

<?php if ($fatura->status == 'P' && $fatura->boleto): ?>
    <div class="ss-alert" role="status">
        <i class="fa fa-barcode ss-alert-icon" aria-hidden="true"></i>
        <div class="ss-alert-body"><?= __('Boleto emitido e enviado para o e-mail do associado.') ?></div>
    </div>
<?php endif; ?>

<section class="ss-section">
    <h4 class="ss-section-title"><?= __('Valores') ?></h4>
    <dl class="ss-dl">
        <dt><?= __('Valor') ?></dt>
        <dd><span class="ss-money"><?= $this->Number->currency($fatura->total, 'BRL') ?></span></dd>
        <?php if ($fatura->valor_frete > 0): ?>
            <dt><?= __('Frete') ?></dt>
            <dd><span class="ss-money"><?= $this->Number->currency($fatura->valor_frete, 'BRL') ?></span></dd>
        <?php endif; ?>
        <dt><?= __('Pagamento') ?></dt>
        <dd>
            <?php if ($comissao): ?>
                <?= __('Crédito em saldo') ?>
            <?php elseif ($fatura->forma_pagamento): ?>
                <?= h($this->Faturas->forma_pagamento($fatura->forma_pagamento)) ?>
            <?php else: ?>
                <?= $vazio ?>
            <?php endif; ?>
        </dd>
        <?php if ($fatura->qt_parcelas > 1): ?>
            <dt><?= __('Parcela') ?></dt>
            <dd><?= h($this->Faturas->parcelas($fatura->parcela_atual, $fatura->qt_parcelas)) ?></dd>
        <?php endif; ?>
        <dt><?= $comissao ? __('Liberação') : __('Vencimento') ?></dt>
        <dd><?= $this->MyHtml->date($fatura->vencimento) ?></dd>
        <?php if ($fatura->status == 'F'): ?>
            <dt><?= $comissao ? __('Liberada em') : __('Paga em') ?></dt>
            <dd><?= $fatura->pagamento ? $this->MyHtml->date($fatura->pagamento) : $vazio ?></dd>
        <?php endif; ?>
    </dl>
</section>

<section class="ss-section">
    <h4 class="ss-section-title"><?= __('Referência') ?></h4>
    <dl class="ss-dl">
        <?php if ($comissao): ?>
            <dt><?= __('Beneficiário') ?></dt>
            <dd><?= h($fatura->usuario->nome) ?></dd>
            <dt><?= __('Comissão') ?></dt>
            <dd><?= h($this->Comissoes->tipo($fatura->comissao->tipo)) ?> (<?= h($fatura->comissao->porcentagem) ?>%)</dd>
            <dt><?= __('Fatura de origem') ?></dt>
            <dd><span class="ss-id">#<?= $numero($fatura->faturas_id) ?></span></dd>
        <?php elseif ($fatura->tipo == 'S'): ?>
            <dt><?= __('Solicitado por') ?></dt>
            <dd><?= h($fatura->usuario->nome) ?></dd>
        <?php elseif ($fatura->tipo == 'P'): ?>
            <dt><?= __('Pedido') ?></dt>
            <dd><span class="ss-id">#<?= $numero($fatura->pedidos_id) ?></span></dd>
            <dt><?= __('Feito por') ?></dt>
            <dd><?= h($fatura->usuario->nome) ?></dd>
        <?php elseif ($fatura->tipo == 'T'): ?>
            <dt><?= __('Cadastro de') ?></dt>
            <dd><?= h($fatura->usuario->nome) ?></dd>
            <dt><?= __('Plano') ?></dt>
            <dd><?= $this->Usuarios->plano($fatura->usuario) ?></dd>
        <?php endif; ?>
    </dl>
</section>

<?php if ($fatura->obs): ?>
    <section class="ss-section">
        <h4 class="ss-section-title"><?= __('Observações') ?></h4>
        <p class="ss-mb-0"><?= nl2br(h($fatura->obs)) ?></p>
    </section>
<?php endif; ?>
