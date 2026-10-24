<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Products/view.ctp */

//Visualização do produto (modal), com os textos da loja
$this->layout = 'ajax';
?>

<div class="ss-record-header">
    <div class="ss-cell-media">
        <?= $this->Html->image('produtos/' . $produto->imagem, ['class' => 'ss-thumb ss-thumb--lg', 'alt' => '']) ?>
        <div>
            <h3 class="ss-record-title">
                <?= h($produto->title) ?>
                <?= $this->Produtos->statusLabel($produto->status, true) ?>
            </h3>
            <div class="ss-record-meta">
                <span class="ss-id">#<?= str_pad($produto->id, 6, '0', STR_PAD_LEFT) ?></span>
            </div>
        </div>
    </div>
</div>

<section class="ss-section">
    <dl class="ss-dl">
        <dt><?= __('Preço') ?></dt>
        <dd><span class="ss-money"><?= $this->Number->currency($produto->valor, 'BRL') ?></span></dd>
        <dt><?= __('Descrição') ?></dt>
        <dd><?= $produto->descricao ? h($produto->descricao) : '<span class="ss-muted">—</span>' ?></dd>
        <dt><?= __('Comissões') ?></dt>
        <dd>
            <?php if ($produto->comissoes): ?>
                <i class="fa fa-sitemap fa-fw" aria-hidden="true"></i> <?= __('Gera comissões na rede') ?>
            <?php else: ?>
                <?= __('Não gera comissões') ?>
            <?php endif; ?>
        </dd>
    </dl>
</section>
