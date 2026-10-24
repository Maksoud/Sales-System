<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Products/view.ctp */

$this->layout = 'ajax';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <?= $this->Html->image('produtos/' . $produto->imagem, ['class' => 'img-responsive img-rounded center-block', 'alt' => $produto->title]) ?>
        </div>
        <div class="col-xs-12 col-sm-8">
            <h4><?= h($produto->title) ?></h4>
            <p><?= h($produto->descricao) ?></p>
            <h3 class="text-verde"><?= $this->Number->currency($produto->valor, 'BRL') ?></h3>
            <?= $produto->status == 'A' ? '<span class="label label-success">' . __('Disponível na loja') . '</span>' : '<span class="label label-default">' . __('Fora de linha') . '</span>' ?>
        </div>
    </div>
</div>
