<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/menus/cliente.ctp */

$icone = function ($icone, $texto) { return '<i class="fa ' . $icone . ' fa-fw" aria-hidden="true"></i> ' . $texto; };
//Estado ativo: recebe 'Controller' ou 'Controller/acao' e devolve ' active' quando a página atual bate
$ctrl  = $this->request->getParam('controller');
$acao  = strtolower(str_replace(['_', '-'], '', $this->request->getParam('action')));
$atual = function () use ($ctrl, $acao) {
    foreach (func_get_args() as $alvo) {
        $partes = explode('/', $alvo);
        if ($partes[0] == $ctrl && (!isset($partes[1]) || strtolower($partes[1]) == $acao)) {
            return ' active';
        }
    }
    return '';
};
?>
<li class="<?= trim($atual('Pages/home')) ?>">
    <?= $this->Html->link($icone('fa-home', __('Início')), ['controller' => 'Pages', 'action' => 'home'], ['escape' => false]) ?>
</li>
<li class="<?= trim($atual('Orders/store')) ?>">
    <?= $this->Html->link($icone('fa-cart-plus', __('Loja')), ['controller' => 'Orders', 'action' => 'store'], ['escape' => false]) ?>
</li>
<li class="<?= trim($atual('Orders/myOrders', 'Orders/view')) ?>">
    <?= $this->Html->link($icone('fa-file-text-o', __('Meus Pedidos')), ['controller' => 'Orders', 'action' => 'myOrders'], ['escape' => false]) ?>
</li>
<li class="<?= trim($atual('Invoices')) ?>">
    <?= $this->Html->link($icone('fa-usd', __('Meu Extrato')), ['controller' => 'Invoices', 'action' => 'statement'], ['escape' => false]) ?>
</li>
