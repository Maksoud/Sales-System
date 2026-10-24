<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/menus/associado.ctp */

/**
 * Menu comum dos associados (Super Master, Master e VIP).
 * Variável: $avisos (true = mostra Gerenciar > Avisos para enviar avisos à própria rede)
 */
$avisos = isset($avisos) ? $avisos : false;
$modal  = function ($titulo, $tamanho = null) {
    return ['escape' => false, 'class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => $titulo] + ($tamanho ? ['data-tamanho' => $tamanho] : []);
};
$icone  = function ($icone, $texto) { return '<i class="fa ' . $icone . ' fa-fw" aria-hidden="true"></i> ' . $texto; };
$ativo  = $status_usuario != 'P'; //Cadastro pendente: sem loja, cadastro e saque
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
<li class="dropdown<?= $atual('Users/network', 'Users/add') ?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-sitemap fa-fw" aria-hidden="true"></i> <?= __('Minha Rede') ?> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><?= $this->Html->link($icone('fa-users', __('Visualizar')), ['controller' => 'Users', 'action' => 'network'], $modal(__('Minha Rede'))) ?></li>
        <?php if ($ativo): ?>
            <li role="separator" class="divider"></li>
            <li><?= $this->Html->link($icone('fa-user-plus', __('Cadastrar Associado')), ['controller' => 'Users', 'action' => 'add'], $modal(__('Novo Associado'))) ?></li>
        <?php endif; ?>
    </ul>
</li>
<li class="dropdown<?= $atual('Orders') ?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-shopping-cart fa-fw" aria-hidden="true"></i> <?= __('Pedidos') ?> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <?php if ($ativo): ?>
            <li><?= $this->Html->link($icone('fa-cart-plus', __('Loja')), ['controller' => 'Orders', 'action' => 'store'], ['escape' => false]) ?></li>
            <li role="separator" class="divider"></li>
        <?php endif; ?>
        <li><?= $this->Html->link($icone('fa-file-text-o', __('Meus Pedidos')), ['controller' => 'Orders', 'action' => 'myOrders'], ['escape' => false]) ?></li>
    </ul>
</li>
<li class="dropdown<?= $atual('Invoices') ?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-usd fa-fw" aria-hidden="true"></i> <?= __('Financeiro') ?> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <?php if ($ativo): ?>
            <li><?= $this->Html->link($icone('fa-btc', __('Solicitar Saque')), ['controller' => 'Invoices', 'action' => 'withdraw'], $modal(__('Solicitação de Saque'), 'sm')) ?></li>
            <li role="separator" class="divider"></li>
        <?php endif; ?>
        <li><?= $this->Html->link($icone('fa-file-text-o', __('Meu Extrato')), ['controller' => 'Invoices', 'action' => 'statement'], ['escape' => false]) ?></li>
    </ul>
</li>
<?php if ($avisos && $ativo): ?>
    <li class="dropdown<?= $atual('Notices') ?>">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-cogs fa-fw" aria-hidden="true"></i> <?= __('Gerenciar') ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><?= $this->Html->link($icone('fa-bell', __('Avisos')), ['controller' => 'Notices', 'action' => 'index'], ['escape' => false]) ?></li>
        </ul>
    </li>
<?php endif; ?>
