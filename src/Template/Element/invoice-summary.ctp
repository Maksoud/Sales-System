<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/invoice-summary.ctp */

/**
 * Totais das faturas listadas, por status.
 * Variáveis: $resumo ['quantidade', 'P', 'F', 'C']
 */
?>

<div class="row bottom-10">
    <div class="col-xs-6 col-sm-3">
        <div class="box-panel bg-white bottom-10">
            <small class="text-cinza text-uppercase"><?= __('Faturas listadas') ?></small>
            <h4 class="top-5 bottom-0"><?= $this->Number->format($resumo['quantidade']) ?></h4>
        </div>
    </div>
    <div class="col-xs-6 col-sm-3">
        <div class="box-panel bg-white bottom-10">
            <small class="text-warning text-uppercase"><?= __('Pendentes') ?></small>
            <h4 class="top-5 bottom-0"><?= $this->Number->currency($resumo['P'], 'BRL') ?></h4>
        </div>
    </div>
    <div class="col-xs-6 col-sm-3">
        <div class="box-panel bg-white bottom-10">
            <small class="text-verde text-uppercase"><?= __('Finalizadas') ?></small>
            <h4 class="top-5 bottom-0"><?= $this->Number->currency($resumo['F'], 'BRL') ?></h4>
        </div>
    </div>
    <div class="col-xs-6 col-sm-3">
        <div class="box-panel bg-white bottom-10">
            <small class="text-danger text-uppercase"><?= __('Canceladas') ?></small>
            <h4 class="top-5 bottom-0"><?= $this->Number->currency($resumo['C'], 'BRL') ?></h4>
        </div>
    </div>
</div>
