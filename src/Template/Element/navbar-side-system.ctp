<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

//Itens do menu Sistema: controller => [ícone, rótulo]
$itens = [
    'Regions'         => ['fa-globe',       __('Regiões')],
    'GoalPlans'       => ['fa-server',      __('Planos')],
    'SaleGoals'       => ['fa-crosshairs',  __('Metas')],
    'SaleCommissions' => ['fa-handshake-o', __('Comissões')],
    'Products'        => ['fa-diamond',     __('Produtos')],
    'Users'           => ['fa-users',       __('Usuários')],
];
$atual = $this->request->getParam('controller');
?>

<div class="hidden-xs col-sm-3 col-md-2 sidebar">
    <div class="row">
        <div class="list-group">
            <?php foreach ($itens as $controller => $item): ?>
                <?= $this->Html->link('<i class="fa ' . $item[0] . ' fa-fw" aria-hidden="true"></i> ' . $item[1], ['controller' => $controller, 'action' => 'index'], ['class' => 'list-group-item' . ($atual == $controller ? ' active' : ''), 'escape' => false]) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
