<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/report-header.ctp */

/**
 * Cabeçalho dos relatórios. Variáveis: $titulo, $periodo [inicio, fim] (opcional).
 */
$periodo = isset($periodo) ? $periodo : [null, null];
?>

<div class="top-20 hidden-print clearfix">
    <div class="pull-right">
        <a href="#" onclick="window.print(); return false;" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i> <?= __('Imprimir') ?></a>
    </div>
    <small class="text-cinza">
        <?= __('Usuário:') ?> <?= h($username) ?> (<?= h($login) ?>) &middot; <?= __('Plano:') ?> <?= h($planos_usuario) ?><br>
        <?= __('Gerado em') ?> <?= date('d/m/Y H:i') ?>
    </small>
</div>

<div class="top-10 panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-4">
                <?= $this->Html->image('Reiniciando.png', ['class' => 'img-responsive', 'style' => 'height: 56px;', 'alt' => 'Reiniciando']) ?>
            </div>
            <div class="col-xs-8 text-center">
                <div class="font-24"><strong><?= h($titulo) ?></strong></div>
                <?php if ($periodo[0] || $periodo[1]): ?>
                    <div class="font-14">
                        <?= __('Período:') ?> <?= $periodo[0] ?: __('início') ?> <?= __('até') ?> <?= $periodo[1] ?: __('hoje') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
