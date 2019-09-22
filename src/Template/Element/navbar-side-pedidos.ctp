<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

$pendente = $processamento = $cancelado = $finalizado = 'list-group-item ';
if ($this->request->url == 'Pedidos?pendente')      $pendente      .= 'active';
if ($this->request->url == 'Pedidos?processamento') $processamento .= 'active';
if ($this->request->url == 'Pedidos?cancelado')     $cancelado     .= 'active';
if ($this->request->url == 'Pedidos?finalizado')    $finalizado    .= 'active';
?>

<div class="col-sm-3 col-md-2 sidebar">
    <div class="row">
        <div class="list-group">
            <li class="list-group-item list-group-item-info">Filtros</li>
            <?= $this->Html->link(('<i class="fa fa-clock-o fa-fw" aria-hidden="true"></i> Pendentes'), ['controller' => 'Pedidos', 'action' => 'index', 'pendentes'], ['class' => $pendente, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-spinner fa-fw" aria-hidden="true"></i> Em Processamento'), ['controller' => 'Pedidos', 'action' => 'index', 'processamento'], ['class' => $processamento, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-ban text-danger fa-fw" aria-hidden="true"></i> Cancelados'), ['controller' => 'Pedidos', 'action' => 'index', 'cancelado' ], ['class' => $cancelado, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-check-square-o fa-fw" aria-hidden="true"></i> Finalizados'), ['controller' => 'Pedidos', 'action' => 'index', 'finalizado'], ['class' => $finalizado, 'escape' => false]); ?>
        </div>
    </div>
    
    <div id="footer_hora" class="pull-bottom-time text-nowrap">
        <h4><?= date('d/m/Y ') ?><span id="timer"><?= date('H:i:s') ?></span></h4>
    </div>
</div>