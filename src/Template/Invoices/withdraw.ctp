<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Invoices/withdraw.ctp */

$this->layout = 'ajax';
?>

<?php if ($gestao): ?>

    <div class="container-fluid">
        <p><?= __('Os saques são solicitados pelos associados a partir do saldo disponível de comissões.') ?></p>
        <div class="alert alert-warning">
            <i class="fa fa-btc" aria-hidden="true"></i>
            <?= __('{0} solicitação(ões) aguardando pagamento.', $pendentes) ?>
        </div>
        <?= $this->Html->link(__('Ver solicitações de saques'), ['action' => 'index', '?' => ['tipo' => 'S', 'status' => 'P']], ['class' => 'btn btn-primary btn-block']) ?>
    </div>

<?php else: ?>

    <?= $this->Form->create(null, ['url' => ['action' => 'withdraw']]) ?>

        <div class="container-fluid">
            <div class="row">
                <div class="top-15 col-xs-6 text-right">
                    <span class="label label-success text-uppercase"><?= __('Disponível') ?></span>
                    <div class="clearfix"></div>
                    <span class="text-cinza"><em><?= __('saldo disponível') ?></em></span>
                    <h3 class="text-verde top-0"><?= $this->Number->currency($saldos['disponivel'], 'BRL') ?></h3>
                </div>
                <div class="top-15 col-xs-6 saldo-bloqueado">
                    <span class="label label-primary text-uppercase"><?= __('Bloqueado') ?></span>
                    <div class="clearfix"></div>
                    <span><em><?= __('a receber') ?></em></span>
                    <h3 class="top-0"><?= $this->Number->currency($saldos['bloqueado'], 'BRL') ?></h3>
                </div>

                <div class="top-20 col-xs-12">
                    <label class="control-label" for="total"><?= __('Valor do saque*') ?></label>
                    <div class="input-group">
                        <span class="input-group-addon">R$</span>
                        <?= $this->Form->text('total', ['class' => 'form-control valuemask focus', 'id' => 'total', 'required' => true, 'placeholder' => '0,00']) ?>
                    </div>
                    <small class="text-cinza"><?= __('Valor mínimo: R$ 50,00. Pagamento em até 5 dias úteis.') ?></small>
                </div>

                <div class="top-15 col-xs-12">
                    <small>
                        <strong><?= __('Depósito em:') ?></strong><br>
                        <?= h($usuario->banco) ?><br>
                        <?= __('Ag.') ?> <?= h($usuario->agencia) ?> - <?= $this->Usuarios->tipo_conta($usuario->tipo_conta) ?> <?= h($usuario->conta) ?><br>
                        <?= $this->Html->link(__('Alterar dados bancários'), ['controller' => 'Users', 'action' => 'bank'], ['class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Dados Bancários')]) ?>
                    </small>
                </div>
            </div>
        </div>

    </div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

    <div class="modal-footer">
        <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= $this->Form->button(__('Solicitar'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Gravando...'), 'disabled' => $saldos['disponivel'] < 50]) ?>
        <?= $this->Form->end() ?>
    </div>

<?php endif; ?>
