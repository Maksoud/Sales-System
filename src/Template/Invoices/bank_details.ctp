<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Invoices/bank_details.ctp */

$this->layout = 'ajax';
?>

<div class="ss-record-header">
    <div>
        <h3 class="ss-record-title">
            <?= __('Fatura') ?> <span class="ss-id">#<?= str_pad($fatura->id, 6, '0', STR_PAD_LEFT) ?></span>
        </h3>
        <div class="ss-record-meta">
            <span><?= h($this->Faturas->tipo($fatura->tipo)) ?></span>
            <span><?= __('Vence em {0}', $this->MyHtml->date($fatura->vencimento)) ?></span>
        </div>
    </div>
</div>

<ul class="ss-totals ss-mb-4">
    <li class="is-total"><span><?= __('Valor a pagar') ?></span><span><?= $this->Number->currency($fatura->total, 'BRL') ?></span></li>
</ul>

<section class="ss-section">
    <h4 class="ss-section-title"><?= __('Transferência, depósito ou PIX') ?></h4>
    <dl class="ss-dl">
        <dt><?= __('Favorecido') ?></dt>
        <dd><?= __('Sales-System Ltda.') ?></dd>
        <dt><?= __('CNPJ') ?></dt>
        <dd><span class="ss-mono">00.000.000/0001-00</span></dd>
        <dt><?= __('Banco') ?></dt>
        <dd>341 · Itaú Unibanco</dd>
        <dt><?= __('Agência') ?></dt>
        <dd><span class="ss-mono">0000</span></dd>
        <dt><?= __('Conta corrente') ?></dt>
        <dd><span class="ss-mono">00000-0</span></dd>
        <dt><?= __('PIX (CNPJ)') ?></dt>
        <dd><span class="ss-mono">00.000.000/0001-00</span></dd>
    </dl>
</section>

<div class="ss-alert ss-mb-0" role="status">
    <i class="fa fa-info-circle ss-alert-icon" aria-hidden="true"></i>
    <div class="ss-alert-body">
        <?= __('Após o pagamento, envie o comprovante para {0} informando o número da fatura.',
                '<a href="mailto:financeiro@exemplo.com.br">financeiro@exemplo.com.br</a>') ?>
    </div>
</div>
