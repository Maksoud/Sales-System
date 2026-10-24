<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Layout/default.ctp */

$link_avisos = $this->Url->build(['controller' => 'Notices', 'action' => 'pending']);

//Opções dos links do menu do usuário que abrem em modal
$modal = function ($titulo, $tamanho = null) {
    return ['escape' => false, 'class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => $titulo]
         + ($tamanho ? ['data-tamanho' => $tamanho] : []);
};
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?= $this->element('head') ?>
    </head>
    <body>
        <div class="bg_ajax hide" role="status" aria-live="polite">
            <i class="fa fa-spinner fa-pulse fa-fw" aria-hidden="true"></i><span><?= __('Carregando') ?></span>
        </div>

        <header class="ss-topbar">
            <div class="ss-container ss-topbar-inner">
                <button type="button" class="ss-icon-btn ss-nav-toggle navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#menu-reiniciando" aria-controls="menu-reiniciando" aria-expanded="false"
                        aria-label="<?= __('Abrir menu') ?>">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>

                <?= $this->Html->link(
                        $this->Html->image('logomarca.png', ['alt' => 'Sales-System', 'id' => 'logo',
                                                               'data-url' => $this->Url->build('/', true)]),
                        ['controller' => 'Pages', 'action' => 'home'],
                        ['class' => 'ss-logo', 'escape' => false]
                    ) ?>

                <div class="ss-topbar-actions">
                    <a href="<?= $link_avisos ?>" class="ss-icon-btn btn_modal<?= $count_avisos > 0 ? ' has-alert' : '' ?>"
                       data-title="<?= __('Avisos') ?>" data-loading-text="<?= __('Carregando...') ?>"
                       title="<?= __('Avisos') ?>" aria-label="<?= __('{0} avisos', $count_avisos) ?>">
                        <i class="fa fa-bell-o" aria-hidden="true"></i>
                        <?php if ($count_avisos > 0): ?>
                            <span class="ss-count ss-count--alert"><?= (int)$count_avisos ?></span>
                        <?php endif; ?>
                    </a>

                    <div class="dropdown">
                        <a href="#" class="ss-user dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $this->Html->image($foto_usuario, ['class' => 'ss-avatar', 'alt' => '']) ?>
                            <span class="ss-user-text">
                                <span class="ss-user-name"><?= h($username) ?></span>
                                <span class="ss-user-plan"><span class="ss-plan ss-plan--<?= (int)$id_planos_usuario ?>"><?= h($planos_usuario) ?></span></span>
                            </span>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="ss-dropdown-info"><?= __('Sessão expira em') ?> <strong id="countdown"></strong></li>
                            <li role="separator" class="divider"></li>
                            <li><?= $this->Html->link('<i class="fa fa-user fa-fw" aria-hidden="true"></i> ' . __('Meus dados'),
                                    ['controller' => 'Users', 'action' => 'profile'], $modal(__('Meus dados'))) ?></li>
                            <li><?= $this->Html->link('<i class="fa fa-lock fa-fw" aria-hidden="true"></i> ' . __('Alterar minha senha'),
                                    ['controller' => 'Users', 'action' => 'password'], $modal(__('Alterar minha senha'), 'sm')) ?></li>
                            <li><?= $this->Html->link('<i class="fa fa-university fa-fw" aria-hidden="true"></i> ' . __('Dados bancários'),
                                    ['controller' => 'Users', 'action' => 'bank'], $modal(__('Dados bancários'), 'sm')) ?></li>
                            <li role="separator" class="divider"></li>
                            <li><?= $this->Html->link('<i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> ' . __('Sair'),
                                    ['controller' => 'Pages', 'action' => 'logout'], ['escape' => false]) ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <script>
            //controle do tempo restante na sessao
            var target_date = new Date("<?= date('M d, Y H:i:s', $this->request->Session()->read('Config.time')) ?>").getTime();
            var hours, minutes, seconds;
            var countdown = document.getElementById("countdown");

            //Identifica timezone
            var target_test = new Date("<?= date('M d, Y H:i:s', $this->request->Session()->read('Config.time')) ?>");
            var offset = new Date().getTimezoneOffset();
            var diferenca = 210 - Number(offset);

            //Ajusta timezone
            if (diferenca > 0) {
                target_date = new Date(target_test.setMinutes(target_test.getMinutes() + diferenca)).getTime();
            } else if (diferenca < 0) {
                target_date = new Date(target_test.setMinutes(target_test.getMinutes() - (diferenca * -1))).getTime();
            }

            setInterval(function () {
                var current_date = new Date().getTime();
                var seconds_left = (target_date - current_date) / 1000;

                minutes = parseInt(seconds_left / 60);
                seconds = parseInt(seconds_left % 60);

                if (minutes >= 0 && minutes < 10) {
                    minutes = "0" + minutes;
                }
                if (seconds >= 0 && seconds < 10) {
                    seconds = "0" + seconds;
                }

                if (minutes < 0 || seconds < 0) {
                    //location.reload();
                } else {
                    if (minutes < 1 && seconds < 1) {
                        location.href = "<?= $this->Url->build('/logout', true); ?>";
                    } else {
                        countdown.innerHTML = minutes + ":" + seconds;
                    }
                }
            }, 1000);
        </script>

        <nav class="navbar ss-navbar" aria-label="<?= __('Menu principal') ?>">
            <div class="ss-container">
                <div class="collapse navbar-collapse" id="menu-reiniciando">
                    <ul class="nav navbar-nav">
                    <?php
                        $tipo_plano = $this->request->Session()->read('sessionPlanoId');

                        if ($tipo_plano == 'Dev')
                            echo $this->element('menus/dev');
                        elseif ($tipo_plano == 'Admin')
                            echo $this->element('menus/admin');
                        elseif ($tipo_plano == 'SM')
                            echo $this->element('menus/sm');
                        elseif ($tipo_plano == 'Master')
                            echo $this->element('menus/master');
                        elseif ($tipo_plano == 'VIP')
                            echo $this->element('menus/vip');
                        elseif ($tipo_plano == 'Cliente')
                            echo $this->element('menus/cliente');
                        else
                            echo '<li><div class="alert alert-danger" role="alert">' . __('Erro ao carregar os itens do menu. Entre em contato com o administrador pelo suporte no rodapé do painel.') . '</div></li>';
                    ?>
                    </ul>

                    <?php //Seletor do tipo de acesso: simula o painel como cada perfil ?>
                    <?php if (!empty($lista_planos)): ?>
                        <?php
                            $icones_planos = ['Dev' => 'fa-code', 'Admin' => 'fa-shield', 'SM' => 'fa-diamond',
                                              'Master' => 'fa-trophy', 'VIP' => 'fa-certificate', 'Cliente' => 'fa-user'];
                        ?>
                        <div class="navbar-right tipo-acesso" role="group" aria-label="<?= __('Ver o painel como') ?>">
                            <span class="tipo-acesso-rotulo"><?= __('Ver como') ?></span>
                            <div class="tipo-acesso-opcoes">
                                <?php foreach ($lista_planos as $id_plano => $plano):
                                    list($slug_plano, $nome_plano) = $plano;
                                    $ativo = ((int)$id_plano === (int)$id_planos_usuario);
                                    $icone = isset($icones_planos[$slug_plano]) ? $icones_planos[$slug_plano] : 'fa-circle-o';
                                    echo $this->Html->link(
                                        '<i class="fa ' . $icone . '" aria-hidden="true"></i> ' . h($slug_plano),
                                        ['controller' => 'Pages', 'action' => 'changeTypeOfAccess', $id_plano],
                                        ['escape' => false, 'title' => $nome_plano,
                                         'class' => 'tipo-acesso-opcao' . ($ativo ? ' ativo' : ''),
                                         'aria-current' => $ativo ? 'true' : 'false']
                                    );
                                endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <main id="conteudo">
            <?php if ($alerta = $this->Flash->render()): ?>
                <div class="ss-container"><div class="ss-flash"><?= $alerta ?></div></div>
            <?php endif; ?>
            <?= $this->fetch('content') ?>
        </main>

        <?= $this->element('modal') ?>

        <footer class="ss-footer">
            <?= $this->element('footer') ?>
        </footer>
    </body>
</html>
