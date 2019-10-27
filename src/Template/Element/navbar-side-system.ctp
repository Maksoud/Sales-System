<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

$regioes = $plans = $metas = $comissoes = $products = $users = $backup = $avisos = $registros = 'list-group-item ';
if ($this->request->url == 'regioes')               $regioes   .= 'active';
elseif ($this->request->url == 'GoalPlans')         $plans     .= 'active';
elseif ($this->request->url == 'metas')             $metas     .= 'active';
elseif ($this->request->url == 'comissoes')         $comissoes .= 'active';
elseif ($this->request->url == 'products')          $products  .= 'active';
elseif ($this->request->url == 'users')             $users     .= 'active';
?>

<div class="hidden-xs col-sm-3 col-md-2 sidebar">
    <div class="row">
        <div class="list-group">
            <?= $this->Html->link(('<i class="fa fa-globe fa-fw" aria-hidden="true"></i> '.__('Regiões')), ['controller' => 'Regions', 'action' => 'index'], ['class' => $regioes, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-server fa-fw" aria-hidden="true"></i> '.__('Planos')), ['controller' => 'GoalPlans', 'action' => 'index'], ['class' => $plans,'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-crosshairs fa-fw" aria-hidden="true"></i> '.__('Metas')), ['controller' => 'SaleGoals', 'action' => 'index'], ['class' => $metas, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-handshake-o fa-fw" aria-hidden="true"></i> '.__('Comissões')), ['controller' => 'Pages', 'action' => 'comissoesIndex'], ['class' => $comissoes, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-diamond fa-fw" aria-hidden="true"></i> '.__('Produtos')), ['controller' => 'Products', 'action' => 'index'], ['class' => $products, 'escape' => false]); ?>
            <?= $this->Html->link(('<i class="fa fa-users fa-fw" aria-hidden="true"></i> '.__('Usuários')), ['controller' => 'Users', 'action' => 'index'], ['class' => $users, 'escape' => false]); ?>
        </div>
    </div>
</div>