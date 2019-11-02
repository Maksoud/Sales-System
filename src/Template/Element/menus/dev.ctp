<li>
    <?= $this->Html->link(('<i class="fa fa-home" aria-hidden="true"></i> '.__('Início')), ['controller' => 'Pages', 'action' => 'home'], ['escape' => false]); ?>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-sitemap" aria-hidden="true"></i>&nbsp;
        <?= __('Minha Rede') ?><span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link(('<i class="fa fa-users" aria-hidden="true"></i> '.__('Visualizar')), ['controller' => 'Pages', 'action' => 'minha-rede'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Minha Rede', 'title' => 'Visualizar', 'aria-hidden' => true, 'escape' => false]) ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-user-plus" aria-hidden="true"></i> '.__('Cadastrar Associado')), ['controller' => 'Pages', 'action' => 'add'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Novo Associado', 'escape' => false]) ?>
        </li>
    </ul>
</li>
<li>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;
        <?= __('Pedidos') ?><span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link(('<i class="fa fa-cart-plus" aria-hidden="true"></i> '.__('Loja')), ['controller' => 'Pages', 'action' => 'loja'], ['escape' => false]); ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> '.__('Meus Pedidos')), ['controller' => 'Pages', 'action' => 'meu-pedido'], ['escape' => false]) ?>
        </li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-usd" aria-hidden="true"></i>&nbsp;
        <?= __('Financeiro') ?><span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link(('<i class="fa fa-btc" aria-hidden="true"></i> '.__('Solicitar Saque')), ['controller' => 'Pages', 'action' => 'saque'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Solicitação de Saque']) ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> '.__('Meu Extrato')), ['controller' => 'Pages', 'action' => 'meu_extrato'], ['escape' => false]) ?>
        </li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;
        <?= __('Gerenciar') ?><span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link(('<i class="fa fa-shopping-cart" aria-hidden="true"></i> '.__('Pedidos da loja')), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-usd" aria-hidden="true"></i> '.__('Extrato Geral')), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-btc" aria-hidden="true"></i> '.__('Solicitações de Saques')), ['controller' => 'Pages', 'action' => 'index', '?' => ['tipo' => 'S', 'status' => 'P']], ['escape' => false]) ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-bell" aria-hidden="true"></i> '.__('Avisos')), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;
        <?= __('Relatórios') ?><span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> '.__('Pedidos')), ['controller' => 'Pages', 'action' => 'report'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Pedidos']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-usd" aria-hidden="true"></i> '.__('Faturas')), ['controller' => 'Pages', 'action' => 'report'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Faturas']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-star" aria-hidden="true"></i> '.__('Metas')), ['controller' => 'SaleGoals', 'action' => 'report'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Metas']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-handshake-o" aria-hidden="true"></i> '.__('Comissões')), ['controller' => 'SaleCommissions', 'action' => 'report'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Comissões']) ?> 
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-users fa-fw" aria-hidden="true"></i> '.__('Associados')), ['controller' => 'Pages', 'action' => 'report'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Associados']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-user fa-fw" aria-hidden="true"></i> '.__('Clientes')), ['controller' => 'Pages', 'action' => 'report'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Clientes']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-btc" aria-hidden="true"></i> '.__('Pagamentos')), ['controller' => 'Pages', 'action' => 'report'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Pagamentos']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-money" aria-hidden="true"></i> '.__('Saldos')), ['controller' => 'Pages', 'action' => 'report'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Faturas']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-diamond" aria-hidden="true"></i> '.__('Cadastros')), ['controller' => 'Pages', 'action' => 'report'], ['escape' => false, 'target' => '_blank'])?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-paw" aria-hidden="true"></i> '.__('Impostos')), ['controller' => 'Pages', 'action' => 'report'], ['escape' => false, 'target' => '_blank'])?>
        </li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-heartbeat" aria-hidden="true"></i>&nbsp;
        <?= __('Sistema') ?><span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link(('<i class="fa fa-globe" aria-hidden="true"></i> '.__('Regiões')), ['controller' => 'Regions', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-server" aria-hidden="true"></i> '.__('Planos')), ['controller' => 'GoalPlans', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-crosshairs" aria-hidden="true"></i> '.__('Metas')), ['controller' => 'SaleGoals', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-handshake-o" aria-hidden="true"></i> '.__('Comissões')), ['controller' => 'SaleCommissions', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-diamond" aria-hidden="true"></i> '.__('Produtos')), ['controller' => 'Products', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-users" aria-hidden="true"></i> '.__('Usuários')), ['controller' => 'Users', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-linux" aria-hidden="true"></i> '.__('Atualizar Sistema')), ['controller' => 'Pages', 'action' => 'update'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-bug" aria-hidden="true"></i> '.__('Modo Debug')), ['controller' => 'Pages', 'action' => 'debug_mode'], ['escape' => false]) ?>
        </li>
    </ul>
</li>