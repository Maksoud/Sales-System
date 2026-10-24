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

<div class="container-fluid">
    <div class="text-center">
        <small><?= __('Fatura') ?> <?= str_pad($fatura->id, 6, '0', STR_PAD_LEFT) ?> - <?= $this->Faturas->tipo($fatura->tipo) ?></small>
        <h3 class="top-5"><?= $this->Number->currency($fatura->total, 'BRL') ?></h3>
        <small><?= __('vencimento em') ?> <?= $this->MyHtml->date($fatura->vencimento) ?></small>
    </div>
    <hr>
    <p><strong><?= __('Transferência, depósito ou PIX para:') ?></strong></p>
    <p>
        <?= __('Reiniciando Sistemas Ltda.') ?><br>
        <?= __('CNPJ') ?> 00.000.000/0001-00<br>
        <?= __('Banco') ?> 341 - Itaú Unibanco<br>
        <?= __('Agência') ?> 0000 - <?= __('Conta corrente') ?> 00000-0<br>
        <?= __('PIX (CNPJ)') ?> 00.000.000/0001-00
    </p>
    <div class="alert alert-info">
        <small><?= __('Após o pagamento, envie o comprovante para financeiro@exemplo.com.br informando o número da fatura.') ?></small>
    </div>
</div>
