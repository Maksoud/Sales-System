<li>
    <?= $this->Html->link('<i class="fa fa-home" aria-hidden="true"></i> Início', ['controller' => 'Pages', 'action' => 'home'], ['escape' => false]); ?>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-sitemap" aria-hidden="true"></i>&nbsp;
        <?= __('Minha Rede') ?><span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link(('<i class="fa fa-users" aria-hidden="true"></i> Visualizar'), ['controller' => 'Pages', 'action' => 'minha-rede'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Minha Rede', 'title' => 'Visualizar', 'aria-hidden' => true, 'escape' => false]) ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-user-plus" aria-hidden="true"></i> Cadastrar Associado'), ['controller' => 'Pages', 'action' => 'add'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Novo Associado', 'escape' => false]) ?>
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
            <?= $this->Html->link('<i class="fa fa-cart-plus" aria-hidden="true"></i> Loja', ['controller' => 'Pages', 'action' => 'loja'], ['escape' => false]); ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> Meus Pedidos'), ['controller' => 'Pages', 'action' => 'meu-pedido'], ['escape' => false]) ?>
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
            <?= $this->Html->link(('<i class="fa fa-btc" aria-hidden="true"></i> Solicitar Saque'), ['controller' => 'Pages', 'action' => 'saque'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Solicitação de Saque']) ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> Meu Extrato'), ['controller' => 'Pages', 'action' => 'meu_extrato'], ['escape' => false]) ?>
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
            <?= $this->Html->link(('<i class="fa fa-shopping-cart" aria-hidden="true"></i> Pedidos da loja'), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-usd" aria-hidden="true"></i> Extrato Geral'), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-btc" aria-hidden="true"></i> Solicitações de Saques'), ['controller' => 'Pages', 'action' => 'index', '?' => ['tipo' => 'S', 'status' => 'P']], ['escape' => false]) ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-bell" aria-hidden="true"></i> Avisos'), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
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
            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> Pedidos'), ['controller' => 'Pages', 'action' => 'relatorio'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Pedidos']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-usd" aria-hidden="true"></i> Faturas'), ['controller' => 'Pages', 'action' => 'relatorio'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Faturas']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-star" aria-hidden="true"></i> Metas'), ['controller' => 'Pages', 'action' => 'relatorio'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Metas']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-handshake-o" aria-hidden="true"></i> Comissões'), ['controller' => 'Pages', 'action' => 'relatorio'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Comissões']) ?> 
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-users fa-fw" aria-hidden="true"></i> Associados'), ['controller' => 'Pages', 'action' => 'relatorio'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Associados']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-user fa-fw" aria-hidden="true"></i> Clientes'), ['controller' => 'Pages', 'action' => 'relatorio_clientes'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Clientes']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-btc" aria-hidden="true"></i> Pagamentos'), ['controller' => 'Pages', 'action' => 'relatorio_pagamentos'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Pagamentos']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-money" aria-hidden="true"></i> Saldos'), ['controller' => 'Pages', 'action' => 'relatorio_saldos'], ['escape' => false, 'class' => 'btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Faturas']) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-diamond" aria-hidden="true"></i> Cadastros'), ['controller' => 'Pages', 'action' => 'produtos'], ['escape' => false, 'target' => '_blank'])?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-paw" aria-hidden="true"></i> Impostos'), ['controller' => 'Pages', 'action' => 'impostos'], ['escape' => false, 'target' => '_blank'])?>
        </li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-address-book-o" aria-hidden="true"></i>&nbsp;
        <?= __('Documentos') ?><span class="caret"></span>
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

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-heartbeat" aria-hidden="true"></i>&nbsp;
        <?= __('Sistema') ?><span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <?= $this->Html->link(('<i class="fa fa-globe" aria-hidden="true"></i> Regiões'), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-server" aria-hidden="true"></i> Planos'), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-crosshairs" aria-hidden="true"></i> Metas'), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-handshake-o" aria-hidden="true"></i> Comissões'), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-diamond" aria-hidden="true"></i> Produtos'), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-users" aria-hidden="true"></i> Usuários'), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-linux" aria-hidden="true"></i> Atualizar Sistema'), ['controller' => 'Pages', 'action' => 'update?token=y5eehc123avse6463asd35k3cb6'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-bug" aria-hidden="true"></i> Modo Debug'), ['controller' => 'Pages', 'action' => 'debug_mode'], ['escape' => false]) ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-archive" aria-hidden="true"></i> Lista de Backups'), ['controller' => 'Pages', 'action' => 'list_backup'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-download" aria-hidden="true"></i> Gerar Backup Automático'), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> Log de Registros'), ['controller' => 'Pages', 'action' => 'index'], ['escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> Log do Sistema'), ['controller' => 'Pages', 'action' => 'viewSystemLog'], ['target' => '_blank', 'escape' => false]) ?>
        </li>
        <li>
            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> Log de Atualizações'), ['controller' => 'Pages', 'action' => 'viewUpdateLog'], ['target' => '_blank', 'escape' => false]) ?>
        </li>
    </ul>
</li>