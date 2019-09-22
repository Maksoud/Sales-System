<li>
    <?= $this->Html->link('<i class="fa fa-home" aria-hidden="true"></i> Início', ['controller' => 'Pages', 'action' => 'home'], ['escape' => false]); ?>
</li>
<li>
    <?= $this->Html->link('<i class="fa fa-cart-plus" aria-hidden="true"></i> Loja', ['controller' => 'Pages', 'action' => 'loja'], ['escape' => false]); ?>
</li>
<li>
    <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> Meus Pedidos'), ['controller' => 'Pages', 'action' => 'meu-pedido'], ['escape' => false]) ?>
</li>
<li>
    <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i> Meu Extrato'), ['controller' => 'Pages', 'action' => 'meu_extrato'], ['escape' => false]) ?>
</li>