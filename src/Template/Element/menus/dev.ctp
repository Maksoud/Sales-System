<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/menus/dev.ctp */

//Desenvolvedor: tudo do Administrador + o menu Sistema
$icone = function ($icone, $texto) { return '<i class="fa ' . $icone . ' fa-fw" aria-hidden="true"></i> ' . $texto; };
?>
<?= $this->element('menus/admin') ?>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-heartbeat" aria-hidden="true"></i>&nbsp;<?= __('Sistema') ?><span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li><?= $this->Html->link($icone('fa-globe', __('Regiões')), ['controller' => 'Regions', 'action' => 'index'], ['escape' => false]) ?></li>
        <li><?= $this->Html->link($icone('fa-server', __('Planos')), ['controller' => 'GoalPlans', 'action' => 'index'], ['escape' => false]) ?></li>
        <li><?= $this->Html->link($icone('fa-crosshairs', __('Metas')), ['controller' => 'SaleGoals', 'action' => 'index'], ['escape' => false]) ?></li>
        <li><?= $this->Html->link($icone('fa-handshake-o', __('Comissões')), ['controller' => 'SaleCommissions', 'action' => 'index'], ['escape' => false]) ?></li>
        <li><?= $this->Html->link($icone('fa-diamond', __('Produtos')), ['controller' => 'Products', 'action' => 'index'], ['escape' => false]) ?></li>
        <li><?= $this->Html->link($icone('fa-users', __('Usuários')), ['controller' => 'Users', 'action' => 'index'], ['escape' => false]) ?></li>
        <li class="divider"></li>
        <li><?= $this->Form->postLink($icone('fa-linux', __('Atualizar Sistema')), ['controller' => 'Pages', 'action' => 'update'], ['escape' => false, 'confirm' => __('Atualizar o sistema a partir do repositório?')]) ?></li>
        <li><?= $this->Html->link($icone('fa-bug', __('Modo Debug')), ['controller' => 'Pages', 'action' => 'debug_mode'], ['escape' => false]) ?></li>
    </ul>
</li>
