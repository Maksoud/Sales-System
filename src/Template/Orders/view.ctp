<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Orders/view.ctp */

$this->layout = 'ajax';
$usuario = $pedido->usuario;
$emCalculo = $pedido->status == 'V';

$subtotal = 0;
foreach ($pedido->pedidos_produtos as $item) {
    $subtotal += $item->valor_unitario * $item->quantidade;
}
$vazio = '<span class="ss-muted">—</span>';
?>

<div class="ss-record-header">
    <div>
        <h3 class="ss-record-title">
            <?= __('Pedido') ?> <span class="ss-id">#<?= str_pad($pedido->id, 6, '0', STR_PAD_LEFT) ?></span>
            <?= $this->Pedidos->statusLabel($pedido->status) ?>
        </h3>
        <div class="ss-record-meta">
            <span><?= __('Feito em {0}', $this->MyHtml->time($pedido->created)) ?></span>
            <span><?= h($this->Pedidos->tipo($pedido->tipo)) ?></span>
        </div>
    </div>
    <div class="ss-cluster hidden-print">
        <a href="#" onclick="window.print(); return false;" class="btn btn-sm btn-default">
            <i class="fa fa-print" aria-hidden="true"></i> <?= __('Imprimir') ?>
        </a>
    </div>
</div>

<?php if ($emCalculo): ?>
    <div class="ss-alert" role="status">
        <i class="fa fa-calculator ss-alert-icon" aria-hidden="true"></i>
        <div class="ss-alert-body"><?= __('Frete e impostos em cálculo. O total aparece aqui assim que o cálculo terminar.') ?></div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-xs-12 col-md-8">

        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Itens') ?></h4>
            <div class="ss-table-wrap">
                <table class="table ss-table ss-table--stack">
                    <thead>
                        <tr>
                            <th><?= __('Produto') ?></th>
                            <th class="ss-num"><?= __('Preço') ?></th>
                            <th class="ss-num"><?= __('Qtd.') ?></th>
                            <th class="ss-num"><?= __('Total') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pedido->pedidos_produtos as $item): ?>
                        <tr>
                            <td class="ss-cell-primary">
                                <div class="ss-cell-media">
                                    <?= $this->Html->image('produtos/' . $item->produto->imagem, ['class' => 'ss-thumb', 'alt' => '']) ?>
                                    <div>
                                        <span class="ss-cell-title"><?= h($item->produto->title) ?></span>
                                        <span class="ss-cell-sub"><?= h($item->produto->descricao) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="ss-num" data-label="<?= __('Preço') ?>">
                                <?= $item->valor_unitario > 0
                                    ? $this->Number->currency($item->valor_unitario, 'BRL')
                                    : '<span class="ss-muted">' . __('Bonificação') . '</span>' ?>
                            </td>
                            <td class="ss-num" data-label="<?= __('Qtd.') ?>"><?= $this->Number->format($item->quantidade) ?></td>
                            <td class="ss-num" data-label="<?= __('Total') ?>">
                                <?= $this->Number->currency($item->valor_unitario * $item->quantidade, 'BRL') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <ul class="ss-totals ss-totals--end">
                <li><span><?= __('Produtos') ?></span><span><?= $this->Number->currency($subtotal, 'BRL') ?></span></li>
                <?php if ($emCalculo): ?>
                    <li><span><?= __('Frete e impostos') ?></span><span class="ss-muted"><?= __('Em cálculo') ?></span></li>
                    <li class="is-total"><span><?= __('Total') ?></span><span class="ss-muted"><?= __('Em cálculo') ?></span></li>
                <?php else: ?>
                    <?php if ($pedido->valor_frete > 0): ?>
                        <li><span><?= __('Frete') ?></span><span><?= $this->Number->currency($pedido->valor_frete, 'BRL') ?></span></li>
                    <?php endif; ?>
                    <?php if ($pedido->valor_icms > 0): ?>
                        <li><span><?= __('ICMS antecipado') ?></span><span><?= $this->Number->currency($pedido->valor_icms, 'BRL') ?></span></li>
                    <?php endif; ?>
                    <li class="is-total"><span><?= __('Total') ?></span><span><?= $this->Number->currency($pedido->total, 'BRL') ?></span></li>
                <?php endif; ?>
            </ul>
        </section>

        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Pagamento') ?></h4>
            <dl class="ss-dl">
                <?php if ($pedido->tipo != 'N'): ?>
                    <dt><?= __('Forma') ?></dt>
                    <dd><?= $pedido->tipo == 'E' ? __('Incluso na taxa de inscrição') : __('Bonificação, sem custo') ?></dd>
                <?php elseif ($pedido->fatura): ?>
                    <dt><?= __('Forma') ?></dt>
                    <dd><?= h($this->Faturas->forma_pagamento($pedido->fatura->forma_pagamento)) ?></dd>
                    <dt><?= __('Parcelas') ?></dt>
                    <dd><?= $pedido->fatura->qt_parcelas > 1 ? __('{0}x', $pedido->fatura->qt_parcelas) : __('À vista') ?></dd>
                    <dt><?= __('Fatura') ?></dt>
                    <dd><span class="ss-mono">#<?= str_pad($pedido->fatura->id, 6, '0', STR_PAD_LEFT) ?></span></dd>
                <?php else: ?>
                    <dt><?= __('Fatura') ?></dt>
                    <dd><?= $emCalculo ? '<span class="ss-muted">' . __('Gerada após o cálculo do frete') . '</span>' : $vazio ?></dd>
                <?php endif; ?>
            </dl>
        </section>

        <?php if ($pedido->obs): ?>
        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Observações') ?></h4>
            <p class="ss-mb-0"><?= nl2br(h($pedido->obs)) ?></p>
        </section>
        <?php endif; ?>
    </div>

    <div class="col-xs-12 col-md-4">
        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Andamento') ?></h4>
            <?= $this->Pedidos->etapas($pedido->status) ?>
        </section>

        <?php if ($pedido->status != 'C'): ?>
        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Entrega') ?></h4>
            <dl class="ss-dl">
                <dt><?= __('Enviado em') ?></dt>
                <dd><?= $pedido->dtdespacho ? $this->MyHtml->date($pedido->dtdespacho) : '<span class="ss-muted">' . __('Ainda não enviado') . '</span>' ?></dd>
                <dt><?= __('Previsão') ?></dt>
                <dd><?= $pedido->dtentrega ? $this->MyHtml->date($pedido->dtentrega) : $vazio ?></dd>
                <dt><?= __('Rastreio') ?></dt>
                <dd><?= $pedido->cod_rastreio ? '<span class="ss-mono">' . h($pedido->cod_rastreio) . '</span>' : $vazio ?></dd>
            </dl>
        </section>
        <?php endif; ?>

        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Destinatário') ?></h4>
            <address class="ss-address">
                <strong><?= h($usuario->nome) ?></strong> <span class="ss-muted">(<?= h($usuario->login) ?>)</span><br>
                <?= h($usuario->endereco) ?>, <?= h($usuario->numero) ?> <?= h($usuario->complemento) ?><br>
                <?= h($usuario->bairro) ?> · <?= h($usuario->cidade) ?>/<?= h($usuario->estado) ?> · CEP <?= h($usuario->cep) ?><br>
                <?= h($usuario->pais) ?><br>
                <i class="fa fa-phone fa-fw" aria-hidden="true"></i> <?= h($usuario->telefone) ?><br>
                <i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i> <?= h($usuario->email) ?>
            </address>
        </section>
    </div>
</div>
