<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/network.ctp */

$this->layout = 'ajax';
?>

<div class="container-fluid">
    <div class="alert alert-info">
        <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
        <?= __('Clique nas pessoas para abrir ou fechar os indicados abaixo delas.') ?>
        <strong class="pull-right"><?= __('{0} pessoas na rede', $total) ?></strong>
    </div>

    <div class="minha-rede user-profile">
        <ul>
            <?= $this->element('network-node', ['usuario' => $raiz, 'nivel' => 0]) ?>
        </ul>
    </div>
</div>

<script>
    $('.minha-rede').on('click', '.rede-pessoa', function (e) {
        e.preventDefault();
        $(this).next('ul').toggle(200);
    });
</script>
