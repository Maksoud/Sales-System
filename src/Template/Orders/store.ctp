<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Orders/store.ctp */

//O cálculo dos totais é feito em webroot/js/maksoud-custom.js (CalculaTotal)
?>

<?= $this->Form->create(null, ['id' => 'form-loja']) ?>

<div class="container-fluid aSemUnderline">
    <div class="col-xs-12">

        <div class="no-padding-lat">
            <h3 class="page-header top-20">
                <?= $gestao ? __('Loja Reiniciando') . ' <small>' . __('lançamento de bonificação') . '</small>' : __('Loja Reiniciando') ?>
            </h3>
        </div>

        <?= $this->element('msg-alert') ?>

        <div class="row">
            <div id="ajax-retorno" class="col-xs-12"></div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="scrolling box-panel bg-white">
                    <table class="table table-striped">
                        <thead>
                            <tr class="font-16">
                                <th class="width-50">&nbsp;</th>
                                <th><?= __('Produto') ?></th>
                                <th class="text-center"><?= __('Preço') ?></th>
                                <th class="text-center"><?= __('Quantidade') ?></th>
                                <th class="text-center"><?= __('Total') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $produto): ?>
                                <tr class="item_produto">
                                    <td class="text-center">
                                        <a href="#" class="btn_modal" data-title="<?= h($produto->title) ?>" data-img="true">
                                            <?= $this->Html->image('produtos/' . $produto->imagem, ['class' => 'img-circle img-responsive', 'style' => 'height: 45px; width: 45px;', 'alt' => $produto->title]) ?>
                                        </a>
                                    </td>
                                    <td style="white-space: normal">
                                        <strong><?= h($produto->title) ?></strong><br>
                                        <small class="text-cinza"><?= h($produto->descricao) ?></small>
                                    </td>
                                    <td class="col-xs-1 text-center text-nowrap valor_unit"><?= $this->Number->currency($produto->valor, 'BRL') ?></td>
                                    <td class="col-xs-1">
                                        <?= $this->Form->control('produtos.' . $produto->id, ['label' => false, 'type' => 'number', 'min' => 0, 'step' => 1, 'class' => 'form-control', 'placeholder' => '0', 'style' => 'min-width: 80px']) ?>
                                    </td>
                                    <td class="col-xs-1 text-center text-nowrap">
                                        R$ <span class="valor_total_prod">0,00</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-xs-12 col-sm-4">
                <div class="top-20 box-panel box bg-white">
                    <?php if ($gestao): ?>
                        <h4 class="text-uppercase"><strong><?= __('Dados da bonificação') ?></strong></h4>
                        <div class="form-group">
                            <label><?= __('Associado que receberá os produtos') ?></label>
                            <?= $this->Form->select('usuarios_id', $associados, ['class' => 'form-control', 'empty' => __('Escolha o associado'), 'required' => true]) ?>
                        </div>
                        <div class="form-group">
                            <label><?= __('Motivo') ?></label>
                            <?= $this->Form->select('motivo', ['meta' => __('Meta atingida'), 'campanha' => __('Campanha promocional'), 'troca' => __('Troca de produto com defeito')], ['class' => 'form-control']) ?>
                        </div>
                    <?php else: ?>
                        <h4 class="text-uppercase"><strong><?= __('Dados de entrega') ?></strong></h4>
                        <p>
                            <?= h($usuario->nome) ?> (<?= h($usuario->login) ?>)<br>
                            <?= h($usuario->endereco) ?>, Nº <?= h($usuario->numero) ?> <?= h($usuario->complemento) ?><br>
                            <?= h($usuario->bairro) ?> - CEP <?= h($usuario->cep) ?><br>
                            <?= h($usuario->cidade) ?> - <?= h($usuario->estado) ?> - <?= h($usuario->pais) ?>
                        </p>
                        <small class="text-danger">
                            <?= __('O valor do frete e o prazo de entrega são calculados pela nossa equipe após o pedido.') ?>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="top-20 bottom-20 box-panel box bg-white">
                    <h4 class="text-uppercase"><?= __('Valor total do pedido') ?></h4>
                    <h3 class="top-0">R$ <span id="valor_total">0,00</span></h3>
                    <?php if ($gestao): ?>
                        <small class="text-cinza"><?= __('Bonificações não geram fatura para o associado.') ?></small>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-xs-12 col-sm-8 bottom-50">
                <div class="top-20 box-panel box bg-white">
                    <?php if ($gestao): ?>
                        <h4 class="text-uppercase"><?= __('Confirmação') ?></h4>
                        <p class="text-cinza"><?= __('O pedido será criado com o tipo "Bonificação por Meta" e seguirá direto para a separação.') ?></p>
                    <?php else: ?>
                        <h4 class="text-uppercase"><?= __('Escolha uma forma de pagamento') ?></h4>

                        <ul id="tipos_de_pagamentos" class="top-10 nav nav-pills nav-justified" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#forma_cartao" role="tab" data-toggle="tab">
                                    <i class="fa fa-credit-card fa-2x" aria-hidden="true"></i><br>
                                    <span class="font-12"><?= __('Cartão de crédito') ?></span>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#forma_deposito" role="tab" data-toggle="tab">
                                    <i class="fa fa-money fa-2x" aria-hidden="true"></i><br>
                                    <span class="font-12"><?= __('Transferência ou Depósito') ?></span>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#forma_boleto" role="tab" data-toggle="tab">
                                    <i class="fa fa-barcode fa-2x" aria-hidden="true"></i><br>
                                    <span class="font-12"><?= __('Boleto bancário') ?></span>
                                </a>
                            </li>
                        </ul>

                        <div class="top-10 alert alert-warning tab-content font-14">
                            <div role="tabpanel" class="tab-pane fade in active" id="forma_cartao">
                                <?php foreach ([1, 2, 3] as $vezes): ?>
                                    <div class="radio">
                                        <label><input type="radio" name="forma_pagamento" id="forma_pagamento_opcao<?= $vezes ?>" value="C<?= $vezes ?>" <?= $vezes == 1 ? 'checked' : '' ?>> <?= $vezes ?>x <?= __('no cartão de crédito (sem juros)') ?></label>
                                    </div>
                                <?php endforeach; ?>
                                <small><i><?= __('Nossa equipe entrará em contato para confirmar os dados do cartão.') ?></i></small>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="forma_deposito">
                                <div class="radio">
                                    <label><input type="radio" name="forma_pagamento" id="forma_pagamento_opcao5" value="D1"> 1x <?= __('(sem juros)') ?></label>
                                </div>
                                <small><i><?= __('Os dados bancários da Reiniciando serão enviados para o seu e-mail.') ?></i></small>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="forma_boleto">
                                <?php foreach ([1, 2] as $vezes): ?>
                                    <div class="radio">
                                        <label><input type="radio" name="forma_pagamento" id="forma_pagamento_opcao<?= 5 + $vezes ?>" value="B<?= $vezes ?>"> <?= $vezes ?>x <?= __('no boleto (sem juros)') ?></label>
                                    </div>
                                <?php endforeach; ?>
                                <small><i><?= __('O boleto será enviado para o seu e-mail.') ?></i></small>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="top-20 row">
                        <div class="col-xs-12 col-sm-offset-7 col-sm-5">
                            <?= $this->Form->button('<i class="fa fa-shopping-cart"></i> ' . ($gestao ? __('Lançar Bonificação') : __('Finalizar Pedido')), ['type' => 'submit', 'class' => 'btn btn-primary btn-block btn-lg']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->end() ?>
