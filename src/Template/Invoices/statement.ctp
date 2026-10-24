<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Invoices/statement.ctp */

$temFiltro = $this->request->getQuery('iniciar_busca');
$total     = count($faturas);
$comSaldo  = !$gestao && $id_planos_usuario != 6;
?>

<div class="ss-container ss-page">
    <div class="ss-stack">
        <header class="ss-page-header">
            <div class="ss-page-header-main">
                <h1 class="ss-page-title"><?= $gestao ? __('Extrato da empresa') : __('Meu extrato') ?></h1>
                <p class="ss-page-subtitle">
                    <?php if ($gestao): ?>
                        <?= __('Recebimentos e pagamentos confirmados') ?> ·
                    <?php endif; ?>
                    <?= $temFiltro
                        ? __n('{0} fatura encontrada', '{0} faturas encontradas', $total, $total)
                        : __n('{0} fatura', '{0} faturas', $total, $total) ?>
                </p>
            </div>
            <?php if ($comSaldo): ?>
                <div class="ss-page-actions">
                    <?= $this->Html->link('<i class="fa fa-money" aria-hidden="true"></i> ' . __('Solicitar saque'), ['action' => 'withdraw'],
                            ['class' => 'btn btn-primary btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Solicitação de saque'),
                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                </div>
            <?php endif; ?>
        </header>

        <?= $this->element('msg-alert') ?>

        <?php if ($comSaldo): ?>
            <div class="ss-grid-stats">
                <div class="ss-stat ss-tone-success">
                    <span class="ss-stat-icon"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                    <span class="ss-stat-label"><?= __('Disponível') ?></span>
                    <span class="ss-stat-value"><?= $this->Number->currency($saldos['disponivel'], 'BRL') ?></span>
                    <span class="ss-stat-meta"><?= __('Pode ser sacado') ?></span>
                </div>
                <div class="ss-stat ss-tone-info">
                    <span class="ss-stat-icon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                    <span class="ss-stat-label"><?= __('Bloqueado') ?></span>
                    <span class="ss-stat-value"><?= $this->Number->currency($saldos['bloqueado'], 'BRL') ?></span>
                    <span class="ss-stat-meta"><?= __('A receber') ?></span>
                </div>
            </div>
        <?php elseif ($gestao): ?>
            <?= $this->element('invoice-summary', ['resumo' => $resumo]) ?>
        <?php endif; ?>

        <section class="ss-card ss-card--flush">
            <div class="ss-card-header">
                <button type="button" class="btn btn-default ss-filters-toggle" data-toggle="collapse"
                        data-target="#filtros" aria-expanded="false" aria-controls="filtros">
                    <i class="fa fa-sliders" aria-hidden="true"></i> <?= __('Filtros') ?>
                    <?php if ($temFiltro): ?><span class="ss-filters-count">!</span><?php endif; ?>
                </button>
                <div id="filtros" class="ss-filters-panel collapse">
                    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'ss-filters']) ?>
                        <div class="form-group">
                            <label for="f-id" class="sr-only"><?= __('Nº da fatura') ?></label>
                            <?= $this->Form->text('id', ['id' => 'f-id', 'class' => 'form-control', 'inputmode' => 'numeric',
                                    'placeholder' => __('Nº da fatura'), 'value' => $this->request->getQuery('id')]) ?>
                        </div>
                        <div class="form-group">
                            <label for="f-ano" class="sr-only"><?= __('Ano') ?></label>
                            <?= $this->MyForm->select_ultimos_anos('ano', ['id' => 'f-ano', 'class' => 'form-control',
                                    'empty' => __('Qualquer ano'), 'value' => $this->request->getQuery('ano')], 2018) ?>
                        </div>
                        <div class="form-group">
                            <label for="f-mes" class="sr-only"><?= __('Mês') ?></label>
                            <?= $this->MyForm->select_meses('mes', ['id' => 'f-mes', 'class' => 'form-control',
                                    'empty' => __('Qualquer mês'), 'value' => $this->request->getQuery('mes')]) ?>
                        </div>
                        <div class="form-group">
                            <label for="f-tipo" class="sr-only"><?= __('Tipo') ?></label>
                            <?= $this->Form->select('tipo', $this->Faturas->tipoLista(), ['id' => 'f-tipo', 'class' => 'form-control',
                                    'empty' => __('Todos os tipos'), 'value' => $this->request->getQuery('tipo')]) ?>
                        </div>
                        <div class="form-group">
                            <label for="f-status" class="sr-only"><?= __('Status') ?></label>
                            <?= $this->Form->select('status', $this->Faturas->statusLista(), ['id' => 'f-status', 'class' => 'form-control',
                                    'empty' => __('Todos os status'), 'value' => $this->request->getQuery('status')]) ?>
                        </div>
                        <input type="hidden" name="iniciar_busca" value="true">
                        <div class="ss-filters-actions">
                            <?= $this->Html->link(__('Limpar'), ['action' => 'statement'],
                                    ['class' => 'btn btn-link', 'id' => 'btn-resetar-form', 'style' => 'display:none;']) ?>
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?>
                            </button>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>

            <?= $this->element('invoice-table', ['faturas' => $faturas, 'gerenciar' => false, 'mostrarUsuario' => $gestao]) ?>
        </section>

        <?php if ($comSaldo): ?>
            <div class="ss-note">
                <span class="ss-note-title"><?= __('Como funciona o saldo') ?></span>
                <?= __('Comissões ficam bloqueadas por 30 dias após o pagamento da fatura de origem e depois passam para o saldo disponível.') ?>
            </div>
        <?php endif; ?>
    </div>
</div>
