<li>
    <?= $this->Html->link('<i class="fa fa-home" aria-hidden="true"></i> Início', ['controller' => 'Pages', 'action' => 'home'], ['escape' => false]); ?>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-sitemap" aria-hidden="true"></i>&nbsp;
        Minha Rede<span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link(('<i class="fa fa-users" aria-hidden="true"></i> Visualizar'), ['controller' => 'Pages', 'action' => 'minha-rede'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Minha Rede', 'title' => 'Visualizar', 'aria-hidden' => true, 'escape' => false]) ?>
        </li>
        <?php if ($status_usuario != 'P') { ?>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-user-plus" aria-hidden="true"></i> Cadastrar Associado'), ['controller' => 'Pages', 'action' => 'add'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Novo Associado', 'escape' => false]) ?>
        </li>
        <?php } ?>
    </ul>
</li>
<li>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;
        Pedidos<span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <?php if ($status_usuario != 'P') { ?>
        <li>
            <?= $this->Html->link('<i class="fa fa-cart-plus" aria-hidden="true"></i> Loja', ['controller' => 'Pages', 'action' => 'loja'], ['escape' => false]); ?>
        </li>
        <li class="divider"></li>
        <?php } ?>
        <li>
            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> Meus Pedidos'), ['controller' => 'Pages', 'action' => 'meu-pedido'], ['escape' => false]) ?>
        </li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-usd" aria-hidden="true"></i>&nbsp;
        Financeiro<span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link(('<i class="fa fa-btc" aria-hidden="true"></i> Solicitar Saque'), ['controller' => 'Pages', 'action' => 'saque'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Solicitação de Saque']) ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> Meu Extrato'), ['controller' => 'Pages', 'action' => 'meu_extrato'], ['escape' => false]) ?>
        </li>
    </ul>
</li>
<?php if ($status_usuario != 'P') { ?>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;
        Gerenciar<span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link(('<i class="fa fa-bell" aria-hidden="true"></i> Avisos'), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
    </ul>
</li>
<?php } ?>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-address-book-o" aria-hidden="true"></i>&nbsp;
        Documentos<span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link('<i class="fa fa-handshake-o" aria-hidden="true"></i> Contrato', ['controller' => 'Pages', 'action' => 'download', 'contrato-092017.pdf', 'documentos'], ['escape' => false, 'target' => '_blank']); ?>
        </li>
        <li>
            <?= $this->Html->link('<i class="fa fa-user-circle-o" aria-hidden="true"></i> Business Plan', ['controller' => 'Pages', 'action' => 'download', 'business-plan-092017.pdf', 'documentos'], ['escape' => false, 'target' => '_blank']); ?>
        </li>
        <li>
            <?= $this->Html->link('<i class="fa fa-refresh" aria-hidden="true"></i> Lavou Tá Novo', ['controller' => 'Pages', 'action' => 'download', 'flyer-092017.pdf', 'documentos'], ['escape' => false, 'target' => '_blank']); ?>
        </li>
    </ul>
</li>