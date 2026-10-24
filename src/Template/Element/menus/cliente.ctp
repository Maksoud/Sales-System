<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/menus/cliente.ctp */

$icone = function ($icone, $texto) { return '<i class="fa ' . $icone . ' fa-fw" aria-hidden="true"></i> ' . $texto; };
?>
<li>
    <?= $this->Html->link($icone('fa-home', __('Início')), ['controller' => 'Pages', 'action' => 'home'], ['escape' => false]) ?>
</li>
<li>
    <?= $this->Html->link($icone('fa-cart-plus', __('Loja')), ['controller' => 'Orders', 'action' => 'store'], ['escape' => false]) ?>
</li>
<li>
    <?= $this->Html->link($icone('fa-file-text-o', __('Meus Pedidos')), ['controller' => 'Orders', 'action' => 'myOrders'], ['escape' => false]) ?>
</li>
<li>
    <?= $this->Html->link($icone('fa-usd', __('Meu Extrato')), ['controller' => 'Invoices', 'action' => 'statement'], ['escape' => false]) ?>
</li>
