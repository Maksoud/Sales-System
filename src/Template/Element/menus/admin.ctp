<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/menus/admin.ctp */

//Opções dos links que abrem em modal
$modal   = function ($titulo, $tamanho = null) {
    return ['escape' => false, 'class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => $titulo] + ($tamanho ? ['data-tamanho' => $tamanho] : []);
};
$icone   = function ($icone, $texto) { return '<i class="fa ' . $icone . ' fa-fw" aria-hidden="true"></i> ' . $texto; };
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
        <li><?= $this->Html->link($icone('fa-users', __('Visualizar')), ['controller' => 'Users', 'action' => 'network'], $modal(__('Rede Reiniciando'))) ?></li>
        <li role="separator" class="divider"></li>
        <li><?= $this->Html->link($icone('fa-user-plus', __('Cadastrar Associado')), ['controller' => 'Users', 'action' => 'add'], $modal(__('Novo Associado'))) ?></li>
    </ul>
</li>
<li class="dropdown<?= $atual('Orders/store', 'Orders/myOrders') ?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-shopping-cart fa-fw" aria-hidden="true"></i> <?= __('Pedidos') ?> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><?= $this->Html->link($icone('fa-cart-plus', __('Loja (bonificação)')), ['controller' => 'Orders', 'action' => 'store'], ['escape' => false]) ?></li>
        <li role="separator" class="divider"></li>
        <li><?= $this->Html->link($icone('fa-gift', __('Bonificações Lançadas')), ['controller' => 'Orders', 'action' => 'myOrders'], ['escape' => false]) ?></li>
    </ul>
</li>
<li class="dropdown<?= $atual('Orders/index', 'Orders/view', 'Invoices', 'Notices') ?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cogs fa-fw" aria-hidden="true"></i> <?= __('Gerenciar') ?> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><?= $this->Html->link($icone('fa-shopping-cart', __('Pedidos da Loja')), ['controller' => 'Orders', 'action' => 'index', '?' => ['status' => 'M', 'iniciar_busca' => 'true']], ['escape' => false]) ?></li>
        <li role="separator" class="divider"></li>
        <li><?= $this->Html->link($icone('fa-usd', __('Extrato Geral')), ['controller' => 'Invoices', 'action' => 'index'], ['escape' => false]) ?></li>
        <li><?= $this->Html->link($icone('fa-btc', __('Solicitações de Saques')), ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'S', 'status' => 'P']], ['escape' => false]) ?></li>
        <li><?= $this->Html->link($icone('fa-line-chart', __('Taxas de Inscrições')), ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'T']], ['escape' => false]) ?></li>
        <li><?= $this->Html->link($icone('fa-file-text-o', __('Faturas de Pedidos')), ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'P']], ['escape' => false]) ?></li>
        <li><?= $this->Html->link($icone('fa-handshake-o', __('Faturas de Comissões')), ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'C']], ['escape' => false]) ?></li>
        <li><?= $this->Html->link($icone('fa-university', __('Extrato da Empresa')), ['controller' => 'Invoices', 'action' => 'statement'], ['escape' => false]) ?></li>
        <li role="separator" class="divider"></li>
        <li><?= $this->Html->link($icone('fa-bell', __('Avisos')), ['controller' => 'Notices', 'action' => 'index'], ['escape' => false]) ?></li>
    </ul>
</li>
<li class="dropdown<?= $atual('Reports') ?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> <?= __('Relatórios') ?> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><?= $this->Html->link($icone('fa-file-text-o', __('Pedidos')), ['controller' => 'Orders', 'action' => 'report'], $modal(__('Relatório de Pedidos'), 'sm')) ?></li>
        <li><?= $this->Html->link($icone('fa-usd', __('Faturas')), ['controller' => 'Invoices', 'action' => 'report'], $modal(__('Relatório de Faturas'), 'sm')) ?></li>
        <li><?= $this->Html->link($icone('fa-star', __('Metas')), ['controller' => 'SaleGoals', 'action' => 'report'], $modal(__('Relatório de Metas'), 'sm')) ?></li>
        <li><?= $this->Html->link($icone('fa-handshake-o', __('Comissões')), ['controller' => 'SaleCommissions', 'action' => 'report'], $modal(__('Relatório de Comissões'), 'sm')) ?></li>
        <li><?= $this->Html->link($icone('fa-users', __('Associados')), ['controller' => 'Users', 'action' => 'report'], $modal(__('Relatório de Associados'), 'sm')) ?></li>
        <li><?= $this->Html->link($icone('fa-user', __('Clientes')), ['controller' => 'Users', 'action' => 'clientsReport'], $modal(__('Relatório de Clientes'), 'sm')) ?></li>
        <li><?= $this->Html->link($icone('fa-btc', __('Pagamentos')), ['controller' => 'Invoices', 'action' => 'paymentsReport'], $modal(__('Relatório de Pagamentos'), 'sm')) ?></li>
        <li><?= $this->Html->link($icone('fa-money', __('Saldos')), ['controller' => 'Invoices', 'action' => 'balancesReport'], $modal(__('Relatório de Saldos'), 'sm')) ?></li>
        <li role="separator" class="divider"></li>
        <li><?= $this->Html->link($icone('fa-bar-chart', __('Cadastros')), ['controller' => 'Reports', 'action' => 'registrations'], ['escape' => false, 'target' => '_blank']) ?></li>
        <li><?= $this->Html->link($icone('fa-percent', __('Impostos')), ['controller' => 'Reports', 'action' => 'taxes'], ['escape' => false, 'target' => '_blank']) ?></li>
    </ul>
</li>
