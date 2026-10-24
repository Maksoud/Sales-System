<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Invoices/statement.ctp */
?>

<div class="container-fluid">
    <div class="col-xs-12">
        <div class="no-padding-lat">
            <h3 class="page-header top-20">
                <?= $gestao ? __('Extrato da Empresa') . ' <small>' . __('recebimentos e pagamentos confirmados') . '</small>' : __('Meu Extrato') ?>
            </h3>
        </div>

        <?= $this->element('msg-alert') ?>

        <?php if (!$gestao && $id_planos_usuario != 6): ?>
            <div class="row bottom-10">
                <div class="col-xs-6 col-sm-3">
                    <div class="box-panel bg-white bottom-10">
                        <span class="label label-success text-uppercase"><?= __('Disponível') ?></span>
                        <h3 class="text-verde top-5 bottom-0"><?= $this->Number->currency($saldos['disponivel'], 'BRL') ?></h3>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="box-panel bg-white bottom-10">
                        <span class="label label-primary text-uppercase"><?= __('Bloqueado') ?></span>
                        <small class="text-cinza"><em><?= __('a receber') ?></em></small>
                        <h3 class="top-5 bottom-0"><?= $this->Number->currency($saldos['bloqueado'], 'BRL') ?></h3>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 top-10">
                    <?= $this->Html->link('<i class="fa fa-btc" aria-hidden="true"></i> ' . __('Solicitar') . ' <strong>' . __('Saque') . '</strong>', ['action' => 'withdraw'], ['class' => 'btn btn-default btn-lg btn-block text-uppercase btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Solicitação de Saque'), 'escape' => false]) ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($gestao): ?>
            <?= $this->element('invoice-summary', ['resumo' => $resumo]) ?>
        <?php endif; ?>

        <div class="row form-busca bottom-10">
            <div class="col-xs-12">
                <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']) ?>
                    <?= $this->Form->text('id', ['class' => 'form-control', 'placeholder' => __('Nº da fatura'), 'value' => $this->request->getQuery('id'), 'style' => 'width:110px']) ?>
                    <?= $this->MyForm->select_ultimos_anos('ano', ['class' => 'form-control', 'empty' => __('- ano -'), 'value' => $this->request->getQuery('ano')], 2018) ?>
                    <?= $this->MyForm->select_meses('mes', ['class' => 'form-control', 'empty' => __('- mês -'), 'value' => $this->request->getQuery('mes')]) ?>
                    <?= $this->Form->select('tipo', $this->Faturas->tipoLista(), ['class' => 'form-control', 'empty' => __('- tipo -'), 'value' => $this->request->getQuery('tipo')]) ?>
                    <?= $this->Form->select('status', $this->Faturas->statusLista(), ['class' => 'form-control', 'empty' => __('- status -'), 'value' => $this->request->getQuery('status')]) ?>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?></button>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <?= $this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> ' . __('Listar Todos'), ['action' => 'statement'], ['class' => 'btn btn-default', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <?= $this->element('invoice-table', ['faturas' => $faturas, 'gerenciar' => false, 'mostrarUsuario' => $gestao]) ?>

        <?php if (!$gestao && $id_planos_usuario != 6): ?>
            <p class="bottom-40 text-cinza small">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <?= __('Comissões ficam bloqueadas por 30 dias após o pagamento da fatura de origem e depois passam para o saldo disponível.') ?>
            </p>
        <?php endif; ?>
    </div>
</div>
