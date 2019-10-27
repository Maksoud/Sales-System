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
        <?php if ($status_usuario != 'P') { ?>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-user-plus" aria-hidden="true"></i> '.__('Cadastrar Associado')), ['controller' => 'Pages', 'action' => 'add'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Novo Associado', 'escape' => false]) ?>
        </li>
        <?php }//if ($status_usuario != 'P') ?>
    </ul>
</li>
<li>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;
        <?= __('Pedidos') ?><span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <?php if ($status_usuario != 'P') { ?>
        <li>
            <?= $this->Html->link(('<i class="fa fa-cart-plus" aria-hidden="true"></i> '.__('Loja')), ['controller' => 'Pages', 'action' => 'loja'], ['escape' => false]); ?>
        </li>
        <li class="divider"></li>
        <?php }//if ($status_usuario != 'P') ?>
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
<?php if ($status_usuario != 'P') { ?>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;
        <?= __('Gerenciar') ?><span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link(('<i class="fa fa-bell" aria-hidden="true"></i> '.__('Avisos')), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
    </ul>
</li>
<?php }//if ($status_usuario != 'P') ?>