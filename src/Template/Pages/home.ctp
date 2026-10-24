<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

    $tipo_plano     = $this->request->Session()->read('sessionPlanoId');
    $status_usuario = $this->request->Session()->read('status_usuario');
    $gestao         = ($tipo_plano == 'Dev' || $tipo_plano == 'Admin');

    if ($gestao):
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
            $classe = trim(preg_replace('/btn_modal/', '', $classe));
            $html  .= ' <small class="label label-default">' . __('Em breve') . '</small></h4><p>' . h($descricao) . '</p>';
            return '<span class="' . $classe . ' item-em-breve" title="' . __('Em breve') . '">' . $html . '</span>';
        }

        $html .= '</h4><p>' . h($descricao) . '</p>';
        return $this->Html->link($html, $url, ['escape' => false] + $options);
    };

    //Opções dos atalhos que abrem em modal
    $modal = function ($classe, $titulo, $tamanho = null) {
        return ['class' => $classe . ' btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => $titulo] + ($tamanho ? ['data-tamanho' => $tamanho] : []);
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

        <?php if ($gestao && !empty($indicadores)): ?>
            <?php
                $cartoes = [
                    ['fa-shopping-cart', __('Pedidos aguardando a empresa'), $this->Number->format($indicadores['pedidos']), ['controller' => 'Orders', 'action' => 'index', '?' => ['status' => 'M', 'iniciar_busca' => 'true']]],
                    ['fa-btc', __('Saques a pagar'), $indicadores['saques'] . ' <small>(' . $this->Number->currency($indicadores['saques_valor'], 'BRL') . ')</small>', ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'S', 'status' => 'P']]],
                    ['fa-exclamation-triangle', __('Faturas vencidas'), $this->Number->format($indicadores['vencidas']), ['controller' => 'Invoices', 'action' => 'index', '?' => ['status' => 'P']]],
                    ['fa-line-chart', __('Recebido no mês'), $this->Number->currency($indicadores['vendas_mes'], 'BRL'), ['controller' => 'Invoices', 'action' => 'statement']],
                ];
            ?>
            <?php foreach ($cartoes as $cartao): ?>
                <div class="col-xs-6 col-md-3">
                    <a href="<?= $this->Url->build($cartao[3]) ?>" class="panel panel-default show" style="color: inherit">
                        <div class="panel-body">
                            <i class="fa <?= $cartao[0] ?> fa-2x pull-right text-cinza" aria-hidden="true"></i>
                            <small class="text-cinza text-uppercase"><?= $cartao[1] ?></small>
                            <h3 class="top-5 bottom-0"><?= $cartao[2] ?></h3>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
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
                        <?= $atalho('fa-user-plus', 'Cadastrar Associado', 'Cadastrar um novo associado', ['controller' => 'Users', 'action' => 'add'], $modal('item item-vermelho', __('Novo Associado'))) ?>
                    </div>
                    <?php } ?>

                    <?php if (!$gestao) { ?>
                    <div class="<?= $class_item_coluna ?>">
                        <?= $atalho('fa-usd', 'Meu Extrato', 'Suas comissões, pedidos, taxas, saques e etc.', ['controller' => 'Invoices', 'action' => 'statement'], ['class' => 'item item-azul']) ?>
                    </div>
                    <?php } ?>

                    <?php if ($status_usuario != 'P') { ?>
                    <div class="<?= $class_item_coluna ?>">
                        <?= $atalho('fa-cart-plus', 'Loja', $gestao ? 'Lançar uma bonificação para um associado' : 'Fazer um novo pedido na loja', ['controller' => 'Orders', 'action' => 'store'], ['class' => 'item item-azul']) ?>
                    </div>
                    <?php }//if ($status_usuario != 'P') ?>

                    <?php if (!$gestao): ?>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-file-text-o', 'Meus Pedidos', 'Lista todos pedidos feitos na loja', ['controller' => 'Orders', 'action' => 'myOrders'], ['class' => 'item item-verde']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($gestao): ?>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-shopping-cart', 'Pedidos da Loja', 'Lista os pedidos da loja', ['controller' => 'Orders', 'action' => 'index'], ['class' => 'item item-verde']) ?>
                        </div>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-btc', 'Solicitações de Saques', 'Lista as faturas de solicitações de saques', ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'S', 'status' => 'P']], ['class' => 'item item-verde']) ?>
                        </div>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-line-chart', 'Taxas de Inscrições', 'Lista as faturas de taxas de inscrições', ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'T']], ['class' => 'item item-verde']) ?>
                        </div>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-file-text-o', 'Fatura de Pedidos', 'Lista as faturas de pedidos', ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'P']], ['class' => 'item item-verde']) ?>
                        </div>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-usd', 'Fatura de Comissões', 'Lista as faturas de comissões', ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'C']], ['class' => 'item item-verde']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($tipo_plano != 'VIP' && $tipo_plano != 'Cliente'): ?>
                        <div class="<?= $class_item_coluna ?>">
                            <?= $atalho('fa-bell', 'Avisos', 'Envio de avisos para seus associados', ['controller' => 'Notices', 'action' => 'index'], ['class' => 'item item-verde']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (!$gestao): ?>
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
                                    <?= $this->Html->link('<i class="fa fa-btc" aria-hidden="true"></i> Solicitar <strong>Saque</strong>', ['controller' => 'Invoices', 'action' => 'withdraw'], ['class' => 'btn btn-default btn-lg btn-block text-uppercase btn_modal', 'data-tamanho' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Solicitação de Saque'), 'escape' => false]) ?>
                                </div>
                            <?php }//if ($status_usuario != 'P') ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($tipo_plano != 'Cliente'): ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <h2 class="panel-titulo">
                                    <?= __('Minhas Metas') ?>
                                </h2>
                            </div>

                            <?php foreach ($metas as $progresso): ?>
                                <?php
                                    $meta        = $progresso->meta;
                                    $porcentagem = round(($progresso->contador * 100) / $meta->meta);
                                    $bonificacao = $produtos[$meta->bonificacao_produtos_id];

                                    if ($meta->tipo == 'I') {
                                        $frase = $progresso->contador . ' ' . $planos[$meta->para_planos_id] . ' ' . __('indicado(s) e ativado(s)');
                                    } else {
                                        $frase = $progresso->contador . ' ' . $produtos[$meta->produtos_id] . ' ' . __('comprado(s) e pago(s)');
                                    }

                                    $frase_meta = __('A meta é {0} para ganhar {1} {2}', $meta->meta, $meta->qtganha, $bonificacao);
                                ?>
                                <div class="col-xs-12 top-5">
                                    <small><?= h($frase) ?></small>
                                    <span class="label label-primary">
                                        <i class="fa fa-crosshairs" aria-hidden="true"></i> <?= h($frase_meta) ?>
                                    </span>
                                    <div class="top-5 progress">
                                        <div class="progress-bar <?= $porcentagem >= 100 ? 'progress-bar-success' : '' ?>" role="progressbar" aria-valuenow="<?= $porcentagem ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $porcentagem ?>%; min-width: 2.5em;"><?= $porcentagem ?>%</div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php if (empty($metas)): ?>
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

    <?php if ($gestao): ?>
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
                            <?= $atalho('fa-file-text-o', 'Pedidos', 'Relatório de Pedidos dos Associados', ['controller' => 'Orders', 'action' => 'report'], $modal('item item-verde', __('Relatório de Pedidos'), 'sm')) ?>
                        </div>

                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $atalho('fa-handshake-o', 'Comissões', 'Relatório de Comissões de vendas e indicações', ['controller' => 'SaleCommissions', 'action' => 'report'], $modal('item item-verde', __('Relatório de Comissões'), 'sm')) ?>
                        </div>

                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $atalho('fa-users fa-fw', 'Associados', 'Relatório de Associados', ['controller' => 'Users', 'action' => 'report'], $modal('item item-verde', __('Relatório de Associados'), 'sm')) ?>
                        </div>

                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $atalho('fa-usd fa-fw', 'Faturas', 'Relatório de Faturas de Pedidos, Inscrições e Saques', ['controller' => 'Invoices', 'action' => 'report'], $modal('item item-verde', __('Relatório de Faturas'), 'sm')) ?>
                        </div>

                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $atalho('fa-star fa-fw', 'Metas', 'Relatório de Associados e Metas', ['controller' => 'SaleGoals', 'action' => 'report'], $modal('item item-verde', __('Relatório de Metas'), 'sm')) ?>
                        </div>

                        <div class="top-20 col-xs-6 col-sm-4 xs-center">
                            <?= $atalho('fa-btc fa-fw', 'Pagamentos', 'Relatório de Pagamentos de Comissões', ['controller' => 'Invoices', 'action' => 'paymentsReport'], $modal('item item-verde', __('Relatório de Pagamentos'), 'sm')) ?>
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
