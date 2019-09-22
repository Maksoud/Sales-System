<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

$pendente = $processamento = $cancelado = $finalizado = 'list-group-item ';
if ($this->request->url == 'Avisos?pendente')      $pendente      .= 'active';
if ($this->request->url == 'Avisos?processamento') $processamento .= 'active';
if ($this->request->url == 'Avisos?cancelado')     $cancelado     .= 'active';
if ($this->request->url == 'Avisos?finalizado')    $finalizado    .= 'active';
?>

<div class="col-sm-3 col-md-2 sidebar">
    <div class="row">
        <div class="list-group">
            <li class="list-group-item list-group-item-info">Filtros</li>
            <?= $this->Html->link(('<i class="fa fa-users fa-fw" aria-hidden="true"></i> Todos'), ['controller' => 'Avisos', 'action' => 'index', 'pendentes'], ['class' => $pendente, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-graduation-cap fa-fw" aria-hidden="true"></i> SM Coordenador'), ['controller' => 'Avisos', 'action' => 'index', 'processamento'], ['class' => $processamento, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-map-marker fa-fw" aria-hidden="true"></i> SM Regional'), ['controller' => 'Avisos', 'action' => 'index', 'cancelado'], ['class' => $cancelado, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-user-secret fa-fw" aria-hidden="true"></i> Master'), ['controller' => 'Avisos', 'action' => 'index', 'finalizado'], ['class' => $finalizado, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-street-view fa-fw" aria-hidden="true"></i> VIP'), ['controller' => 'Avisos', 'action' => 'index', 'finalizado'], ['class' => $finalizado, 'escape' => false]); ?>
        </div>
    </div>
    
    <div id="footer_hora" class="pull-bottom-time text-nowrap">
        <h4><?= date('d/m/Y ') ?><span id="timer"><?= date('H:i:s') ?></span></h4>
    </div>
</div>