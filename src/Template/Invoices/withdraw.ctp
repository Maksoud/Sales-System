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

    <p><?= __('Os saques são solicitados pelos associados a partir do saldo disponível de comissões.') ?></p>
    <div class="ss-alert ss-alert--warning ss-mb-0" role="status">
        <i class="fa fa-money ss-alert-icon" aria-hidden="true"></i>
        <div class="ss-alert-body">
            <?= __n('{0} solicitação aguardando pagamento.', '{0} solicitações aguardando pagamento.', $pendentes, $pendentes) ?>
        </div>
    </div>

    </div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

    <div class="modal-footer">
        <?= $this->Form->button(__('Fechar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= $this->Html->link(__('Ver solicitações de saque'), ['action' => 'index', '?' => ['tipo' => 'S', 'status' => 'P']],
                ['class' => 'btn btn-primary']) ?>
    </div>

<?php else: ?>

    <?php $semSaldo = $saldos['disponivel'] < 50; ?>

    <?= $this->Form->create(null, ['url' => ['action' => 'withdraw']]) ?>

        <dl class="ss-dl ss-mb-4">
            <dt><?= __('Disponível') ?></dt>
            <dd><span class="ss-money"><?= $this->Number->currency($saldos['disponivel'], 'BRL') ?></span></dd>
            <dt><?= __('Bloqueado') ?></dt>
            <dd><span class="ss-money"><?= $this->Number->currency($saldos['bloqueado'], 'BRL') ?></span> <span class="ss-muted"><?= __('(a receber)') ?></span></dd>
        </dl>

        <?php if ($semSaldo): ?>
            <div class="ss-alert ss-alert--warning" role="status">
                <i class="fa fa-exclamation-triangle ss-alert-icon" aria-hidden="true"></i>
                <div class="ss-alert-body"><?= __('O saldo disponível ainda não alcança o valor mínimo de R$ 50,00 para saque.') ?></div>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="total" class="ss-required"><?= __('Valor do saque') ?></label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <?= $this->Form->text('total', ['class' => 'form-control valuemask focus', 'id' => 'total', 'required' => true,
                        'placeholder' => '0,00', 'inputmode' => 'decimal', 'autocomplete' => 'off', 'aria-describedby' => 'total-help']) ?>
            </div>
            <span class="help-block" id="total-help"><?= __('Valor mínimo: R$ 50,00. Pagamento em até 5 dias úteis.') ?></span>
        </div>

        <section class="ss-section ss-mb-0">
            <h4 class="ss-section-title"><?= __('Depósito em') ?></h4>
            <dl class="ss-dl">
                <dt><?= __('Banco') ?></dt>
                <dd><?= h($usuario->banco) ?></dd>
                <dt><?= __('Agência') ?></dt>
                <dd><span class="ss-mono"><?= h($usuario->agencia) ?></span></dd>
                <dt><?= __('Conta') ?></dt>
                <dd><?= h($this->Usuarios->tipo_conta($usuario->tipo_conta)) ?> <span class="ss-mono"><?= h($usuario->conta) ?></span></dd>
            </dl>
            <p class="ss-help">
                <?= $this->Html->link('<i class="fa fa-university" aria-hidden="true"></i> ' . __('Alterar dados bancários'),
                        ['controller' => 'Users', 'action' => 'bank'],
                        ['class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Dados bancários'),
                         'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
            </p>
        </section>

    </div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

    <div class="modal-footer">
        <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= $this->Form->button(__('Solicitar saque'), ['type' => 'submit', 'class' => 'btn btn-primary',
                'data-loading-text' => __('Enviando...'), 'disabled' => $semSaldo]) ?>
        <?= $this->Form->end() ?>
    </div>

<?php endif; ?>
