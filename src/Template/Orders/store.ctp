<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Orders/store.ctp */

//O cálculo dos totais é feito em webroot/js/maksoud-custom.js (CalculaTotal):
//cada .item_produto precisa de .valor_unit (só o preço), do input type=number e de .valor_total_prod.
?>

<?= $this->Form->create(null, ['id' => 'form-loja']) ?>

<div class="ss-container ss-page">
    <header class="ss-page-header">
        <div class="ss-page-header-main">
            <ol class="ss-breadcrumb">
                <li><?= __('Pedidos') ?></li>
                <li><?= __('Loja') ?></li>
            </ol>
            <h1 class="ss-page-title"><?= __('Loja Reiniciando') ?></h1>
            <p class="ss-page-subtitle">
                <?= $gestao ? __('Lançamento de bonificação: escolha os produtos e o associado.') : __('Escolha os produtos e a quantidade de cada um.') ?>
            </p>
        </div>
        <div class="ss-page-actions">
            <?= $this->Html->link('<i class="fa fa-shopping-cart" aria-hidden="true"></i> ' . ($gestao ? __('Bonificações lançadas') : __('Meus pedidos')),
                    ['action' => 'myOrders'], ['class' => 'btn btn-default', 'escape' => false]) ?>
        </div>
    </header>

    <?= $this->element('msg-alert') ?>

    <div class="ss-split">

        <section aria-label="<?= __('Produtos') ?>">
            <?php if (count($produtos)): ?>
            <div class="ss-grid-auto">
                <?php foreach ($produtos as $produto): ?>
                <article class="ss-card ss-product item_produto">
                    <a href="#" class="ss-product-media btn_modal" data-title="<?= h($produto->title) ?>" data-img="true"
                       title="<?= __('Ampliar imagem') ?>" aria-label="<?= __('Ampliar imagem de {0}', h($produto->title)) ?>">
                        <?= $this->Html->image('produtos/' . $produto->imagem, ['alt' => '']) ?>
                    </a>
                    <div class="ss-product-body">
                        <h2 class="ss-product-title"><?= h($produto->title) ?></h2>
                        <?php if ($produto->descricao): ?>
                            <p class="ss-product-desc"><?= h($produto->descricao) ?></p>
                        <?php endif; ?>
                        <span class="ss-product-price ss-money valor_unit"><?= $this->Number->currency($produto->valor, 'BRL') ?></span>
                    </div>
                    <div class="ss-product-footer">
                        <div class="ss-product-qty">
                            <label for="produto-<?= $produto->id ?>"><?= __('Qtd.') ?></label>
                            <?= $this->Form->number('produtos.' . $produto->id, ['id' => 'produto-' . $produto->id, 'min' => 0, 'step' => 1,
                                    'class' => 'form-control', 'placeholder' => '0', 'inputmode' => 'numeric']) ?>
                        </div>
                        <span class="ss-product-subtotal">R$ <span class="valor_total_prod">0,00</span></span>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="ss-card">
                <div class="ss-empty">
                    <div class="ss-empty-icon"><i class="fa fa-cube" aria-hidden="true"></i></div>
                    <p class="ss-empty-title"><?= __('Nenhum produto disponível') ?></p>
                    <p class="ss-empty-text"><?= __('A loja está sem produtos no momento. Volte mais tarde.') ?></p>
                </div>
            </div>
            <?php endif; ?>
        </section>

        <aside class="ss-stack">

            <?php if ($gestao): ?>
            <section class="ss-card">
                <header class="ss-card-header"><h2 class="ss-card-title"><?= __('Dados da bonificação') ?></h2></header>
                <div class="ss-card-body">
                    <div class="form-group">
                        <label for="usuarios_id" class="ss-required"><?= __('Associado que receberá os produtos') ?></label>
                        <?= $this->Form->select('usuarios_id', $associados, ['class' => 'form-control', 'id' => 'usuarios_id',
                                'empty' => __('Selecione'), 'required' => true]) ?>
                    </div>
                    <div class="form-group ss-mb-0">
                        <label for="motivo"><?= __('Motivo') ?></label>
                        <?= $this->Form->select('motivo', ['meta' => __('Meta atingida'), 'campanha' => __('Campanha promocional'), 'troca' => __('Troca de produto com defeito')],
                                ['class' => 'form-control', 'id' => 'motivo']) ?>
                    </div>
                </div>
            </section>
            <?php else: ?>
            <section class="ss-card">
                <header class="ss-card-header"><h2 class="ss-card-title"><?= __('Entrega') ?></h2></header>
                <div class="ss-card-body">
                    <address class="ss-address">
                        <strong><?= h($usuario->nome) ?></strong> <span class="ss-muted">(<?= h($usuario->login) ?>)</span><br>
                        <?= h($usuario->endereco) ?>, <?= h($usuario->numero) ?> <?= h($usuario->complemento) ?><br>
                        <?= h($usuario->bairro) ?> · CEP <?= h($usuario->cep) ?><br>
                        <?= h($usuario->cidade) ?>/<?= h($usuario->estado) ?> · <?= h($usuario->pais) ?>
                    </address>
                </div>
            </section>

            <section class="ss-card">
                <header class="ss-card-header"><h2 class="ss-card-title"><?= __('Forma de pagamento') ?></h2></header>
                <div class="ss-card-body">
                    <ul id="tipos_de_pagamentos" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#forma_cartao" role="tab" data-toggle="tab" aria-controls="forma_cartao">
                                <i class="fa fa-credit-card" aria-hidden="true"></i> <?= __('Cartão') ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#forma_deposito" role="tab" data-toggle="tab" aria-controls="forma_deposito">
                                <i class="fa fa-university" aria-hidden="true"></i> <?= __('Transferência') ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#forma_boleto" role="tab" data-toggle="tab" aria-controls="forma_boleto">
                                <i class="fa fa-barcode" aria-hidden="true"></i> <?= __('Boleto') ?>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="forma_cartao">
                            <?php foreach ([1, 2, 3] as $vezes): ?>
                                <div class="radio">
                                    <label><input type="radio" name="forma_pagamento" id="forma_pagamento_opcao<?= $vezes ?>" value="C<?= $vezes ?>" <?= $vezes == 1 ? 'checked' : '' ?>> <?= __('{0}x no cartão de crédito, sem juros', $vezes) ?></label>
                                </div>
                            <?php endforeach; ?>
                            <p class="ss-help ss-mb-0"><?= __('Nossa equipe entrará em contato para confirmar os dados do cartão.') ?></p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="forma_deposito">
                            <div class="radio">
                                <label><input type="radio" name="forma_pagamento" id="forma_pagamento_opcao5" value="D1"> <?= __('Transferência ou depósito à vista') ?></label>
                            </div>
                            <p class="ss-help ss-mb-0"><?= __('Os dados bancários da Reiniciando serão enviados para o seu e-mail.') ?></p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="forma_boleto">
                            <?php foreach ([1, 2] as $vezes): ?>
                                <div class="radio">
                                    <label><input type="radio" name="forma_pagamento" id="forma_pagamento_opcao<?= 5 + $vezes ?>" value="B<?= $vezes ?>"> <?= __('{0}x no boleto, sem juros', $vezes) ?></label>
                                </div>
                            <?php endforeach; ?>
                            <p class="ss-help ss-mb-0"><?= __('O boleto será enviado para o seu e-mail.') ?></p>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <section class="ss-card">
                <header class="ss-card-header"><h2 class="ss-card-title"><?= __('Resumo') ?></h2></header>
                <div class="ss-card-body ss-stack">
                    <ul class="ss-totals">
                        <li class="is-total"><span><?= __('Total dos produtos') ?></span><span>R$ <span id="valor_total">0,00</span></span></li>
                    </ul>
                    <p class="ss-help">
                        <?= $gestao
                            ? __('A bonificação segue direto para a separação e não gera fatura para o associado.')
                            : __('O valor do frete e o prazo de entrega são calculados pela nossa equipe após o pedido.') ?>
                    </p>
                    <div id="ajax-retorno"></div>
                    <?= $this->Form->button('<i class="fa fa-check" aria-hidden="true"></i> ' . ($gestao ? __('Lançar bonificação') : __('Finalizar pedido')),
                            ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) ?>
                </div>
            </section>
        </aside>
    </div>
</div>

<?= $this->Form->end() ?>
