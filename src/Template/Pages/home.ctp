<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

    $tipo_plano     = $this->request->Session()->read('sessionPlanoId');
    $status_usuario = $this->request->Session()->read('status_usuario');
    
    if ($tipo_plano == 'Dev' || $tipo_plano == 'Admin'):
        $class_coluna_1    = 'col-xs-12';
        $class_item_coluna = 'top-20 col-xs-6 col-sm-4 xs-center';
    else:
        $class_coluna_1 = 'col-xs-12 col-sm-7';
        $class_item_coluna = 'top-20 col-xs-6 xs-center';
    endif;

    //Atalho do dashboard. Com $url vira link; com $url = null (módulo ainda
    //não implementado) vira um bloco desabilitado com o selo "Em breve".
    $atalho = function ($icone, $titulo, $descricao, $url = null, array $options = []) {
        $classe = isset($options['class']) ? $options['class'] : 'item';
        $html   = '<i class="fa ' . $icone . '" aria-hidden="true"></i><h4>' . h($titulo);

        if ($url === null) {
            $classe = trim(preg_replace('/btn_modal/', '', $classe));
            $html  .= ' <small class="label label-default">' . __('Em breve') . '</small></h4><p>' . h($descricao) . '</p>';
            return '<span class="' . $classe . ' item-em-breve" title="' . __('Em breve') . '">' . $html . '</span>';
        }

        $html .= '</h4><p>' . h($descricao) . '</p>';
        return $this->Html->link($html, $url, ['escape' => false] + $options);
    };

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
                                <strong><?= __('AGUARDANDO CONFIRMAÇÃO DE PAGAMENTO') ?></strong>
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
                            <?= __('Acesso rápido') ?>
                        </h2>
                    </div>
                    
                    <?php if ($status_usuario != 'P' && $tipo_plano != 'Cliente') { ?>
                    <div class="<?= $class_item_coluna ?>">
                        <?= $atalho('fa-user-plus', 'Cadastrar Associado', 'Cadastrar um novo associado', null, ['class' => 'item item-vermelho']) ?>
                    </div>
                    <?php } ?>
                    
                    <?php if ($tipo_plano != 'Admin' && $tipo_plano != 'Dev') { ?>
                    <div class="<?= $class_item_coluna ?>">
                        <?= $atalho('fa-usd', 'Meu Extrato', 'Suas comissões, pedidos, taxas, saques e etc.', null, ['class' => 'item item-azul']) ?>
                    </div>
                    <?php } ?>
                    
                    <?php if ($status_usuario != 'P') { ?>
                    <div class="<?= $class_item_coluna ?>">
                        <?= $atalho('fa-cart-plus', 'Loja', 'Fazer um novo pedido na loja', null, ['class' => 'item item-azul']) ?>
                    </div>
                    <?php }//if ($status_usuario != 'P') ?>
                    
                    <?php if ($tipo_plano != 'Admin' && $tipo_plano != 'Dev'): ?>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-file-text-o', 'Meus Pedidos', 'Lista todos pedidos feitos na loja', null, ['class' => 'item item-verde']) ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($tipo_plano == 'Admin' || $tipo_plano == 'Dev'): ?>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-shopping-cart', 'Pedidos da Loja', 'Lista os pedidos da loja', null, ['class' => 'item item-verde']) ?>
                        </div>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-btc', 'Solicitações de Saques', 'Lista as faturas de solicitações de saques', null, ['class' => 'item item-verde']) ?>
                        </div>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-line-chart', 'Taxas de Inscrições', 'Lista as faturas de taxas de inscrições', null, ['class' => 'item item-verde']) ?>
                        </div>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-file-text-o', 'Fatura de Pedidos', 'Lista as faturas de pedidos', null, ['class' => 'item item-verde']) ?>
                        </div>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-usd', 'Fatura de Comissões', 'Lista as faturas de comissões', null, ['class' => 'item item-verde']) ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($tipo_plano != 'VIP' && $tipo_plano != 'Cliente'): ?>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-bell', 'Avisos', 'Envio de avisos para seus associados', null, ['class' => 'item item-verde']) ?>
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
                                <span class="label label-success text-uppercase"><?= __('Disponível'); ?></span>
                                <div class="clearfix"></div>
                                <span class="text-cinza"><em><?= __('saldo disponível'); ?></em></span>
                                <div class="clearfix"></div>
                                <h3 class="text-verde top-0"><?= $this->Number->currency($saldo_disponivel, 'BRL') ?></h3>
                            </div>
                            <div class="top-15 col-xs-6 saldo-bloqueado">
                                <span class="label label-primary text-uppercase"><?= __('Bloqueado'); ?></span>
                                <div class="clearfix"></div>
                                <span><em>a receber</em></span>
                                <div class="clearfix"></div>
                                <h3 class="top-0"><?= $this->Number->currency($saldo_bloqueado, 'BRL') ?></h3>
                            </div>
                            <?php if ($status_usuario != 'P') { ?>
                                <div class="top-20 bottom-10 col-xs-12 col-md-offset-2 col-md-8">
                                    <?php //Solicitação de saque ainda não implementada ?>
                                    <button type="button" class="btn btn-default btn-lg btn-block text-uppercase" disabled title="<?= __('Em breve') ?>"><i class="fa fa-btc" aria-hidden="true"></i> Solicitar <strong>Saque</strong></button>
                                </div>
                            <?php }//if ($status_usuario != 'P') ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($metas) && $tipo_plano != 'Cliente'): ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <h2 class="panel-titulo">
                                    <?= __('Minhas Metas') ?>
                                </h2>
                            </div>
                            
                            <?php
                                $cont_x = 0;
                                
                                foreach ($metas as $meta):

                                    if (!empty($meta->meta)) {

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
                                    }//if (!empty($meta->meta))

                                endforeach; 
                                
                                if ($cont_x == 0 ): ?>
                            
                                <div class="col-xs-12">
                                    <span class="label label-default">
                                        <?= __('Você não tem nenhuma meta ativa') ?>
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
                                <?= __('Relatórios') ?>
                            </h2>
                        </div>
                        
                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $atalho('fa-file-text-o', 'Pedidos', 'Relatório de Pedidos dos Associados', null, ['class' => 'item item-verde']) ?>
                        </div>
                        
                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $atalho('fa-handshake-o', 'Comissões', 'Relatório de Comissões de vendas e indicações', ['controller' => 'SaleCommissions', 'action' => 'report'], ['class' => 'item item-verde btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => 'Carregando...', 'data-title' => 'Relatório de Comissões']) ?>
                        </div>
                        
                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $atalho('fa-users fa-fw', 'Associados', 'Relatório de Associados', null, ['class' => 'item item-verde']) ?>
                        </div>
                        
                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $atalho('fa-usd fa-fw', 'Faturas', 'Relatório de Faturas de Pedidos, Inscrições e Saques', null, ['class' => 'item item-verde']) ?>
                        </div>
                        
                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $atalho('fa-star fa-fw', 'Metas', 'Relatório de Associados e Metas', ['controller' => 'SaleGoals', 'action' => 'index'], ['class' => 'item item-verde']) ?>
                        </div>
                        
                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $atalho('fa-btc fa-fw', 'Pagamentos', 'Relatório de Pagamentos de Comissões', null, ['class' => 'item item-verde']) ?>
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