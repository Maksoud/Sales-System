<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/navbar-side-system.ctp */

//Itens do menu Sistema: controller => [ícone, rótulo]
$itens = [
    'Regions'         => ['fa-globe',       __('Regiões')],
    'GoalPlans'       => ['fa-server',      __('Planos')],
    'SaleGoals'       => ['fa-bullseye',    __('Metas')],
    'SaleCommissions' => ['fa-handshake-o', __('Comissões')],
    'Products'        => ['fa-cube',        __('Produtos')],
    'Users'           => ['fa-users',       __('Usuários')],
];
$atual = $this->request->getParam('controller');
?>

<nav class="ss-subnav" aria-label="<?= __('Sistema') ?>">
    <p class="ss-subnav-title"><?= __('Sistema') ?></p>
    <ul class="ss-subnav-list">
        <?php foreach ($itens as $controller => $item): ?>
            <li><?= $this->Html->link('<i class="fa ' . $item[0] . '" aria-hidden="true"></i> ' . $item[1],
                    ['controller' => $controller, 'action' => 'index'],
                    ['class' => $atual == $controller ? 'is-active' : '', 'escape' => false]
                        + ($atual == $controller ? ['aria-current' => 'page'] : [])) ?></li>
        <?php endforeach; ?>
    </ul>
</nav>
