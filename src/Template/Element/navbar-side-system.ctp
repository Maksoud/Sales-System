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

//Telas que ainda usam o layout antigo (coluna .sidebar + col-sm-9).
//Retire o controller daqui ao migrar a tela para o ss-layout; quando esvaziar, apague o bloco antigo.
$legado = ['Regions', 'GoalPlans', 'SaleGoals', 'SaleCommissions', 'Pages'];
?>

<?php if (in_array($atual, $legado)): ?>
<div class="hidden-xs col-sm-3 col-md-2 sidebar">
    <div class="row">
        <div class="list-group">
            <?php foreach ($itens as $controller => $item): ?>
                <?= $this->Html->link('<i class="fa ' . $item[0] . ' fa-fw" aria-hidden="true"></i> ' . $item[1], ['controller' => $controller, 'action' => 'index'], ['class' => 'list-group-item' . ($atual == $controller ? ' active' : ''), 'escape' => false]) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php else: ?>
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
<?php endif; ?>
