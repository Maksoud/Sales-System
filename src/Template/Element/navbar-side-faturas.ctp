<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

$comissoes = $saques = $pedidos = $taxas = 'list-group-item ';
if ($this->request->url == 'Faturas?comissoes') $comissoes .= 'active';
if ($this->request->url == 'Faturas?saques')    $saques    .= 'active';
if ($this->request->url == 'Faturas?pedidos')   $pedidos   .= 'active';
if ($this->request->url == 'Faturas?taxas')     $taxas     .= 'active';
?>

<div class="col-sm-3 col-md-2 sidebar">
    <div class="row">
        <div class="list-group">
            <li class="list-group-item list-group-item-info">Filtros</li>
            <?= $this->Html->link(('<i class="fa fa-clock-o fa-fw" aria-hidden="true"></i> Pendentes'), ['controller' => 'Faturas', 'action' => 'index', 'comissoes'], ['class' => $comissoes, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-usd fa-fw" aria-hidden="true"></i> Saques'), ['controller' => 'Faturas', 'action' => 'index', 'saques'], ['class' => $saques, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-cart-arrow-down fa-fw" aria-hidden="true"></i> Pedidos'), ['controller' => 'Faturas', 'action' => 'index', 'pedidos'], ['class' => $pedidos, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-street-view fa-fw" aria-hidden="true"></i> Taxas de Entrada'), ['controller' => 'Faturas', 'action' => 'index', 'taxas'], ['class' => $taxas, 'escape' => false]); ?>
        </div>
    </div>
        
    <div id="footer_hora" class="pull-bottom-time text-nowrap">
        <h4><?= date('d/m/Y ') ?><span id="timer"><?= date('H:i:s') ?></span></h4>
    </div>
</div>