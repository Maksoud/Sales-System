<!-- Home -->

<?php

    $tipo_plano     = $this->request->Session()->read('sessionPlanoId');
    $status_usuario = $this->request->Session()->read('status_usuario');
    
    if ($tipo_plano == 'Dev' || $tipo_plano == 'Admin'):
        $class_coluna_1    = 'col-xs-12';
        $class_item_coluna = 'top-20 col-xs-6 col-sm-4 xs-center';
    else:
        $class_coluna_1 = 'col-xs-12 col-sm-7';
        $class_item_coluna = 'top-20 col-xs-6 xs-center';
    endif;

?>

<div class="container-fluid top-20 bottom-10 aSemUnderline">
    
    <?= $this->element('msg-alert') ?>
    
    <div class="row">
        
        <?php if ($status_usuario == 'P' && $tipo_plano != 'Cliente'): ?>
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12">
                            <div class="text-center font-20 text-danger">
                                <strong>AGUARDANDO CONFIRMAÇÃO DE PAGAMENTO</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="<?= $class_coluna_1; ?>">
            <div class="panel panel-default">
                <div class="panel-body atalho bottom-10">
                    <div class="col-xs-12">
                        <h2 class="panel-titulo">
                            Acesso rápido
                        </h2>
                    </div>
                    
                    <?php if ($status_usuario != 'P' && $tipo_plano != 'Cliente') { ?>
                    <div class="<?= $class_item_coluna ?>">
                        <?= $this->Html->link(('<i class="fa fa-user-plus" aria-hidden="true"></i><h4>Cadastrar Associado</h4><p>Cadastrar um novo associado</p>'), ['controller' => 'Pages', 'action' => 'add'], ['class' => 'item item-vermelho btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Novo Associado', 'escape' => false]) ?>
                    </div>
                    <?php } ?>
                    
                    <?php if ($tipo_plano != 'Admin' && $tipo_plano != 'Dev') { ?>
                    <div class="<?= $class_item_coluna ?>">
                        <?= $this->Html->link(('<i class="fa fa-usd" aria-hidden="true"></i><h4>Meu Extrato</h4><p>Suas comissões, pedidos, taxas, saques e etc.</p>'), ['controller' => 'Pages', 'action' => 'meu_extrato'], ['class' => 'item item-azul', 'escape' => false]) ?>
                    </div>
                    <?php } ?>
                    
                    <?php if ($status_usuario != 'P') { ?>
                    <div class="<?= $class_item_coluna ?>">
                        <?= $this->Html->link(('<i class="fa fa-cart-plus" aria-hidden="true"></i><h4>Loja</h4><p>Fazer um novo pedido na loja</p>'), ['controller' => 'Pages', 'action' => 'loja'], ['class' => 'item item-azul', 'escape' => false]) ?>
                    </div>
                    <?php }//if ($status_usuario != 'P') ?>
                    
                    <?php if ($tipo_plano != 'Admin' && $tipo_plano != 'Dev'): ?>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i><h4>Meus Pedidos</h4><p>Lista todos pedidos feitos na loja</p>'), ['controller' => 'Pages', 'action' => 'meu-pedido'], ['class' => 'item item-verde', 'escape' => false]) ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($tipo_plano == 'Admin' || $tipo_plano == 'Dev'): ?>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $this->Html->link(('<i class="fa fa-shopping-cart" aria-hidden="true"></i><h4>Pedidos da Loja</h4><p>Lista os pedidos da loja</p>'), ['controller' => 'Pages', 'action' => 'index'], ['class' => 'item item-verde', 'escape' => false]) ?>
                        </div>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $this->Html->link(('<i class="fa fa-btc" aria-hidden="true"></i><h4>Solicitações de Saques</h4><p>Lista as faturas de solicitações de saques</p>'), ['controller' => 'Pages', 'action' => 'index', '?' => ['tipo' => 'S', 'status' => 'P']], ['class' => 'item item-verde', 'escape' => false]) ?>
                        </div>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $this->Html->link(('<i class="fa fa-line-chart" aria-hidden="true"></i><h4>Taxas de Inscrições</h4><p>Lista as faturas de taxas de inscrições</p>'), ['controller' => 'Pages', 'action' => 'index', '?' => ['tipo' => 'T', 'status' => 'P']], ['class' => 'item item-verde', 'escape' => false]) ?>
                        </div>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i><h4>Fatura de Pedidos</h4><p>Lista as faturas de pedidos</p>'), ['controller' => 'Pages', 'action' => 'index', '?' => ['tipo' => 'P', 'status' => 'P']], ['class' => 'item item-verde', 'escape' => false]) ?>
                        </div>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $this->Html->link(('<i class="fa fa-usd" aria-hidden="true"></i><h4>Fatura de Comissões</h4><p>Lista as faturas de comissões</p>'), ['controller' => 'Pages', 'action' => 'index', '?' => ['tipo' => 'C', 'status' => 'P']], ['class' => 'item item-verde', 'escape' => false]) ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($tipo_plano != 'VIP' && $tipo_plano != 'Cliente'): ?>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $this->Html->link(('<i class="fa fa-bell" aria-hidden="true"></i><h4>Avisos</h4><p>Envio de avisos para seus associados</p>'), ['controller' => 'Pages', 'action' => 'index'], ['class' => 'item item-verde', 'escape' => false]) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <?php if ($tipo_plano != 'Dev' && $tipo_plano != 'Admin'): ?>
            <div class="col-xs-12 col-sm-5">
                <?php if ($tipo_plano != 'Cliente'): ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="top-15 col-xs-6 text-right">
                                <span class="label label-success text-uppercase">Disponível</span>
                                <div class="clearfix"></div>
                                <span class="text-cinza"><em>saldo disponível</em></span>
                                <div class="clearfix"></div>
                                <h3 class="text-verde top-0"><?= $this->Number->currency ($saldo_disponivel, 'BRL') ?></h3>
                            </div>
                            <div class="top-15 col-xs-6 saldo-bloqueado">
                                <span class="label label-primary text-uppercase">Bloqueado</span>
                                <div class="clearfix"></div>
                                <span><em>a receber</em></span>
                                <div class="clearfix"></div>
                                <h3 class="top-0"><?= $this->Number->currency ($saldo_bloqueado, 'BRL') ?></h3>
                            </div>
                            <?php if ($status_usuario != 'P') { ?>xs
                                <div class="top-20 bottom-10 col-xs-12 col-md-offset-2 col-md-8">
                                    <?= $this->Html->link(('<i class="fa fa-btc" aria-hidden="true"></i> Solicitar <strong>Saque</strong>'), ['controller' => 'Pages', 'action' => 'saque'], ['class' => 'btn btn-default btn-lg btn-block text-uppercase btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Solicitar Saque', 'escape' => false]) ?>
                                </div>
                            <?php }//if ($status_usuario != 'P') ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty ($metas->toArray()) && $tipo_plano != 'Cliente'): ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <h2 class="panel-titulo">
                                    Minhas Metas
                                </h2>
                            </div>
                            
                            <?php
                                $cont_x = 0;
                                
                                foreach ($metas as $meta):

                                    if (!empty ($meta->meta)) {

                                        //Descrição dos planos
                                        foreach ($planos as $index => $plano):
                                            if ($meta->meta->para_planos_id == $index) $para_planos = $plano;
                                        endforeach;
                                        
                                        //Descrição dos produtos
                                        foreach ($produtos as $index => $produto):
                                            if ($meta->meta->produtos_id == $index) $produto = $produto;
                                            if ($meta->meta->bonificacao_produtos_id == $index) $bonificacao = $produto;
                                        endforeach;
        
                                        $porcentagem =  ($meta->contador * 100) / $meta->meta->meta;
        
                                        if ($meta->meta->tipo == 'I' )
                                            $frase = $meta->contador . ' ' . $para_planos . ' já indicado e ativado';
                                        else
                                            $frase = $meta->contador . ' ' . $produto . ' já comprado e pago';
        
                                        $frase_meta = "A meta é {$meta->meta->meta} para ganhar {$meta->meta->qtganha} {$bonificacao}";
        
                                        $cont_x++;
                                        ?>
                                        <div class="col-xs-12">
                                            <small><?= $frase ?></small>
                                            <span class="label label-primary">
                                                <i class="fa fa-crosshairs" aria-hidden="true"></i> <?= $frase_meta ?>
                                            </span>
                                            <div class="top-5 progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?= $porcentagem ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $porcentagem ?>%;"></div>
                                            </div>
                                        </div>
                                        <?php 
                                    }//if (!empty ($meta->meta))

                                endforeach; 
                                
                                if ($cont_x == 0 ): ?>
                            
                                <div class="col-xs-12">
                                    <span class="label label-default">
                                        Você não tem nenhuma meta ativa
                                    </span>
                                </div>
                                
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; //não mostra se for dev ou admin ?>
    </div>
    
    <?php if ($tipo_plano == 'Dev' || $tipo_plano == 'Admin'): ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body atalho bottom-10">
                        
                        <div class="col-xs-12">
                            <h2 class="panel-titulo">
                                Relatórios
                            </h2>
                        </div>
                        
                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $this->Html->link(('<i class="fa fa-file-text-o" aria-hidden="true"></i><h4>Pedidos</h4><p>Relatório de Pedidos dos Associados</p>'), ['controller' => 'Pages', 'action' => 'relatorio'], ['escape' => false, 'class' => 'item item-verde btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Pedidos']) ?>
                        </div>
                        
                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $this->Html->link(('<i class="fa fa-handshake-o" aria-hidden="true"></i><h4>Comissões</h4><p>Relatório de Comissões de vendas e indicações</p>'), ['controller' => 'Pages', 'action' => 'relatorio'], ['escape' => false, 'class' => 'item item-verde btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Comssões']) ?>
                        </div>
                        
                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $this->Html->link(('<i class="fa fa-users fa-fw" aria-hidden="true"></i><h4>Associados</h4><p>Relatório de Associados</p>'), ['controller' => 'Pages', 'action' => 'relatorio'], ['escape' => false, 'class' => 'item item-verde btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Associados']) ?>
                        </div>
                        
                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $this->Html->link(('<i class="fa fa-usd fa-fw" aria-hidden="true"></i><h4>Faturas</h4><p>Relatório de Faturas de Pedidos, Inscrições e Saques</p>'), ['controller' => 'Pages', 'action' => 'relatorio'], ['escape' => false, 'class' => 'item item-verde btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Faturas']) ?>
                        </div>
                        
                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $this->Html->link(('<i class="fa fa-star fa-fw" aria-hidden="true"></i><h4>Metas</h4><p>Relatório de Associados e Metas</p>'), ['controller' => 'Pages', 'action' => 'relatorio'], ['escape' => false, 'class' => 'item item-verde btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Metas']) ?>
                        </div>
                        
                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $this->Html->link(('<i class="fa fa-btc fa-fw" aria-hidden="true"></i><h4>Pagamentos</h4><p>Relatório de Pagamentos de Comissões</p>'), ['controller' => 'Pages', 'action' => 'relatorio_pagamentos'], ['escape' => false, 'class' => 'item item-verde btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Metas']) ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
    <?php endif; ?>
    
</div>

<!-- /////////////////////////////////////////////////////////////////////// -->
<?php if ($this->request->Session()->read('debug')) { ?>
    <div class="pull-bottom-developed">
        <i class="fa fa-bug" aria-hidden="true"></i> Debug mode is active!
    </div>
<?php }//if ($this->request->Session()->read('debug')) ?>