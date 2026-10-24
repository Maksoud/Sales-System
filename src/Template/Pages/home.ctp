<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Pages/home.ctp */

$tipo_plano     = $this->request->Session()->read('sessionPlanoId');
$status_usuario = $this->request->Session()->read('status_usuario');
$gestao         = ($tipo_plano == 'Dev' || $tipo_plano == 'Admin');
$cliente        = ($tipo_plano == 'Cliente');
$pendente       = ($status_usuario == 'P');
$comSaldo       = !$gestao && !$cliente;

$nomes         = preg_split('/\s+/', trim((string)$username));
$primeiro_nome = $nomes[0];

//Atalho do dashboard. Com $url vira link; com $url = null (módulo ainda
//não implementado) vira um bloco desabilitado com o selo "Em breve".
$atalho = function ($icone, $titulo, $descricao, $url = null, array $options = []) {
    $classe = trim('ss-shortcut ' . (isset($options['class']) ? $options['class'] : ''));
    $titulo = h($titulo);

    if ($url === null) {
        $classe = trim(str_replace('btn_modal', '', $classe));
        $titulo .= ' <span class="label label-default">' . __('Em breve') . '</span>';
    }

    $html = '<span class="ss-shortcut-icon"><i class="fa ' . $icone . '" aria-hidden="true"></i></span>'
          . '<span><span class="ss-shortcut-title">' . $titulo . '</span>'
          . '<span class="ss-shortcut-desc">' . h($descricao) . '</span></span>';

    if ($url === null) {
        return '<span class="' . $classe . ' is-soon" title="' . __('Em breve') . '">' . $html . '</span>';
    }

    return $this->Html->link($html, $url, ['escape' => false, 'class' => $classe] + $options);
};

//Opções dos atalhos que abrem em modal
$modal = function ($titulo, $tamanho = null) {
    return ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => $titulo]
         + ($tamanho ? ['data-tamanho' => $tamanho] : []);
};
?>

<div class="ss-container ss-page">
    <div class="ss-stack-lg">

        <?php if ($pendente && !$cliente): ?>
            <div class="ss-banner" role="status">
                <i class="fa fa-clock-o" aria-hidden="true"></i> <?= __('Aguardando confirmação de pagamento') ?>
            </div>
        <?php endif; ?>

        <header class="ss-page-header ss-mb-0">
            <div class="ss-page-header-main">
                <h1 class="ss-page-title"><?= __('Olá, {0}', h($primeiro_nome)) ?></h1>
                <p class="ss-page-subtitle ss-cluster">
                    <span class="ss-plan ss-plan--<?= (int)$id_planos_usuario ?>"><?= h($planos_usuario) ?></span>
                    <span><?= $gestao ? __('Resumo da operação e atalhos do painel') : __('Seu saldo, suas metas e atalhos do painel') ?></span>
                </p>
            </div>
            <?php if ($comSaldo && !$pendente): ?>
                <div class="ss-page-actions">
                    <?= $this->Html->link('<i class="fa fa-money" aria-hidden="true"></i> ' . __('Solicitar saque'),
                            ['controller' => 'Invoices', 'action' => 'withdraw'],
                            ['class' => 'btn btn-primary btn_modal', 'data-tamanho' => 'sm', 'data-title' => __('Solicitação de saque'),
                             'data-loading-text' => __('Carregando...'), 'escape' => false]) ?>
                </div>
            <?php endif; ?>
        </header>

        <?= $this->element('msg-alert') ?>

        <?php if ($gestao && !empty($indicadores)): ?>
            <div class="ss-grid-stats">
                <a class="ss-stat ss-tone-warning" href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'index', '?' => ['status' => 'M', 'iniciar_busca' => 'true']]) ?>">
                    <span class="ss-stat-icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                    <span class="ss-stat-label"><?= __('Pedidos aguardando') ?></span>
                    <span class="ss-stat-value"><?= $this->Number->format($indicadores['pedidos']) ?></span>
                    <span class="ss-stat-meta"><?= __('Aguardando a empresa') ?></span>
                </a>
                <a class="ss-stat ss-tone-warning" href="<?= $this->Url->build(['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'S', 'status' => 'P']]) ?>">
                    <span class="ss-stat-icon"><i class="fa fa-money" aria-hidden="true"></i></span>
                    <span class="ss-stat-label"><?= __('Saques a pagar') ?></span>
                    <span class="ss-stat-value"><?= $this->Number->format($indicadores['saques']) ?></span>
                    <span class="ss-stat-meta"><?= __('{0} no total', $this->Number->currency($indicadores['saques_valor'], 'BRL')) ?></span>
                </a>
                <a class="ss-stat ss-tone-danger" href="<?= $this->Url->build(['controller' => 'Invoices', 'action' => 'index', '?' => ['status' => 'P']]) ?>">
                    <span class="ss-stat-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                    <span class="ss-stat-label"><?= __('Faturas vencidas') ?></span>
                    <span class="ss-stat-value"><?= $this->Number->format($indicadores['vencidas']) ?></span>
                    <span class="ss-stat-meta"><?= __('Taxas e pedidos') ?></span>
                </a>
                <a class="ss-stat ss-tone-success" href="<?= $this->Url->build(['controller' => 'Invoices', 'action' => 'statement']) ?>">
                    <span class="ss-stat-icon"><i class="fa fa-line-chart" aria-hidden="true"></i></span>
                    <span class="ss-stat-label"><?= __('Recebido no mês') ?></span>
                    <span class="ss-stat-value"><?= $this->Number->currency($indicadores['vendas_mes'], 'BRL') ?></span>
                    <span class="ss-stat-meta"><?= __('Taxas e pedidos pagos') ?></span>
                </a>
            </div>
        <?php elseif ($comSaldo): ?>
            <div class="ss-grid-stats">
                <a class="ss-stat ss-tone-success" href="<?= $this->Url->build(['controller' => 'Invoices', 'action' => 'statement']) ?>">
                    <span class="ss-stat-icon"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                    <span class="ss-stat-label"><?= __('Disponível') ?></span>
                    <span class="ss-stat-value"><?= $this->Number->currency($saldo_disponivel, 'BRL') ?></span>
                    <span class="ss-stat-meta"><?= __('Pode ser sacado') ?></span>
                </a>
                <a class="ss-stat ss-tone-info" href="<?= $this->Url->build(['controller' => 'Invoices', 'action' => 'statement']) ?>">
                    <span class="ss-stat-icon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                    <span class="ss-stat-label"><?= __('Bloqueado') ?></span>
                    <span class="ss-stat-value"><?= $this->Number->currency($saldo_bloqueado, 'BRL') ?></span>
                    <span class="ss-stat-meta"><?= __('A receber') ?></span>
                </a>
            </div>
        <?php endif; ?>

        <div class="<?= $comSaldo ? 'ss-split' : 'ss-stack-lg' ?>">

            <section class="ss-card">
                <header class="ss-card-header">
                    <h2 class="ss-card-title"><?= __('Acesso rápido') ?></h2>
                </header>
                <div class="ss-card-body">
                    <div class="ss-grid-auto">
                        <?php if (!$pendente && !$cliente): ?>
                            <?= $atalho('fa-user-plus', __('Cadastrar associado'), __('Cadastrar um novo associado'),
                                    ['controller' => 'Users', 'action' => 'add'], $modal(__('Novo associado'))) ?>
                        <?php endif; ?>

                        <?php if (!$gestao): ?>
                            <?= $atalho('fa-file-text-o', __('Meu extrato'), __('Comissões, pedidos, taxas e saques'),
                                    ['controller' => 'Invoices', 'action' => 'statement']) ?>
                        <?php endif; ?>

                        <?php if (!$pendente): ?>
                            <?= $atalho('fa-cart-plus', __('Loja'), $gestao ? __('Lançar uma bonificação para um associado') : __('Fazer um novo pedido na loja'),
                                    ['controller' => 'Orders', 'action' => 'store']) ?>
                        <?php endif; ?>

                        <?php if (!$gestao): ?>
                            <?= $atalho('fa-shopping-cart', __('Meus pedidos'), __('Pedidos feitos na loja'),
                                    ['controller' => 'Orders', 'action' => 'myOrders']) ?>
                        <?php else: ?>
                            <?= $atalho('fa-shopping-cart', __('Pedidos da loja'), __('Pedidos feitos pelos associados'),
                                    ['controller' => 'Orders', 'action' => 'index']) ?>
                            <?= $atalho('fa-money', __('Solicitações de saque'), __('Saques aguardando pagamento'),
                                    ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'S', 'status' => 'P']]) ?>
                            <?= $atalho('fa-ticket', __('Taxas de inscrição'), __('Faturas das taxas de inscrição'),
                                    ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'T']]) ?>
                            <?= $atalho('fa-file-text-o', __('Faturas de pedidos'), __('Faturas dos pedidos da loja'),
                                    ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'P']]) ?>
                            <?= $atalho('fa-handshake-o', __('Faturas de comissões'), __('Comissões de vendas e indicações'),
                                    ['controller' => 'Invoices', 'action' => 'index', '?' => ['tipo' => 'C']]) ?>
                        <?php endif; ?>

                        <?php if ($tipo_plano != 'VIP' && !$cliente): ?>
                            <?= $atalho('fa-bell-o', __('Avisos'), __('Enviar avisos para seus associados'),
                                    ['controller' => 'Notices', 'action' => 'index']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <?php if ($comSaldo): ?>
                <section class="ss-card">
                    <header class="ss-card-header">
                        <h2 class="ss-card-title"><?= __('Minhas metas') ?></h2>
                    </header>
                    <div class="ss-card-body">
                        <?php if (empty($metas)): ?>
                            <div class="ss-empty">
                                <div class="ss-empty-icon"><i class="fa fa-bullseye" aria-hidden="true"></i></div>
                                <p class="ss-empty-title"><?= __('Nenhuma meta ativa') ?></p>
                                <p class="ss-empty-text"><?= __('Quando houver uma meta para o seu plano, o progresso aparece aqui.') ?></p>
                            </div>
                        <?php else: ?>
                            <ul class="ss-goals">
                                <?php foreach ($metas as $progresso): ?>
                                    <?php
                                        $meta        = $progresso->meta;
                                        $porcentagem = $meta->meta > 0 ? (int)round(($progresso->contador * 100) / $meta->meta) : 0;
                                        $bonificacao = $produtos[$meta->bonificacao_produtos_id];

                                        if ($meta->tipo == 'I') {
                                            $frase = $progresso->contador . ' ' . $planos[$meta->para_planos_id] . ' ' . __('indicado(s) e ativado(s)');
                                        } else {
                                            $frase = $progresso->contador . ' ' . $produtos[$meta->produtos_id] . ' ' . __('comprado(s) e pago(s)');
                                        }

                                        $frase_meta = __('Meta: {0} para ganhar {1} {2}', $meta->meta, $meta->qtganha, $bonificacao);
                                    ?>
                                    <li class="ss-goal<?= $porcentagem >= 100 ? ' is-done' : '' ?>">
                                        <div class="ss-goal-head">
                                            <span class="ss-goal-title"><?= h($frase) ?></span>
                                            <span class="ss-goal-value"><?= min($porcentagem, 100) ?>%</span>
                                        </div>
                                        <progress class="ss-progress" value="<?= min($porcentagem, 100) ?>" max="100"
                                                  aria-label="<?= h($frase_meta) ?>"><?= $porcentagem ?>%</progress>
                                        <span class="ss-goal-meta"><i class="fa fa-bullseye" aria-hidden="true"></i> <?= h($frase_meta) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($gestao): ?>
                <section class="ss-card">
                    <header class="ss-card-header">
                        <h2 class="ss-card-title"><?= __('Relatórios') ?></h2>
                    </header>
                    <div class="ss-card-body">
                        <div class="ss-grid-auto">
                            <?= $atalho('fa-shopping-cart', __('Pedidos'), __('Pedidos dos associados'),
                                    ['controller' => 'Orders', 'action' => 'report'], $modal(__('Relatório de pedidos'), 'sm')) ?>
                            <?= $atalho('fa-handshake-o', __('Comissões'), __('Comissões de vendas e indicações'),
                                    ['controller' => 'SaleCommissions', 'action' => 'report'], $modal(__('Relatório de comissões'), 'sm')) ?>
                            <?= $atalho('fa-users', __('Associados'), __('Associados cadastrados'),
                                    ['controller' => 'Users', 'action' => 'report'], $modal(__('Relatório de associados'), 'sm')) ?>
                            <?= $atalho('fa-file-text-o', __('Faturas'), __('Faturas de pedidos, inscrições e saques'),
                                    ['controller' => 'Invoices', 'action' => 'report'], $modal(__('Relatório de faturas'), 'sm')) ?>
                            <?= $atalho('fa-bullseye', __('Metas'), __('Associados e metas'),
                                    ['controller' => 'SaleGoals', 'action' => 'report'], $modal(__('Relatório de metas'), 'sm')) ?>
                            <?= $atalho('fa-money', __('Pagamentos'), __('Pagamentos de comissões'),
                                    ['controller' => 'Invoices', 'action' => 'paymentsReport'], $modal(__('Relatório de pagamentos'), 'sm')) ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php if ($this->request->Session()->read('debug')): ?>
    <div class="ss-container">
        <p class="ss-note"><i class="fa fa-bug" aria-hidden="true"></i> <?= __('Modo de depuração ativo.') ?></p>
    </div>
<?php endif; ?>
