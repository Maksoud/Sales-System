<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('head') ?>
    </head>
    <body>
        <div class="bg_ajax hide">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br><br>
            <?= __('Carregando') ?>
        </div>
        
        <header>
            <div class="container-fluid aSemUnderline">
                <div class="row">
                    <div class="top-5 col-xs-6 col-sm-4">
                        <?= $this->Html->link(
                                $this->Html->image("Reiniciando.png", ['alt'      => 'Reiniciando',
                                                                     //'width'    => '210px',
                                                                       'style'    => 'height: 62px;',
                                                                       'class'    => 'img-responsive',
                                                                       'id'       => 'logo',
                                                                       'data-url' => $this->Url->build('/', true)
                                                                       ]
                                                  ),
                                                  ['controller' => 'Pages',
                                                   'action'     => 'home'
                                                  ],
                                                  ['escape' => false]
                                             );
                        ?>
                    </div>
                    <div class="top-15 hidden-xs col-sm-4 text-center">
                        <?php
                            $link_avisos = $this->Url->build(["controller" => "Avisos", "action" => "listar"]);
                        ?>
                        <a href="<?= $link_avisos ?>" class="btn-avisos btn_modal <?php if ($count_avisos > 0 ) echo 'avisos-alerta'; ?>" data-loading-text="Carregando..." data-title="Avisos">
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-bell-o fa-stack-1x fa-inverse"></i>
                            </span>
                            <span class="badge" data-count="<?= $count_avisos ?>">
                                <?= $count_avisos ?> <?= __('Avisos'); ?>
                            </span>
                        </a>
                    </div>
                    <div class="top-15 col-xs-6 col-sm-4">
                        <a href="#" class="user-profile dropdown-toggle pull-right" data-toggle="dropdown">
                            <i class="top-10 fa fa-angle-down pull-right"></i>
                            <?= $this->Html->image($foto_usuario, ['class' => 'pull-right', 'style' => 'height: 50px; width: 50px;']); ?>
                            <div class="pull-right text-right">
                            	<?= h($username) ?>
                                <div class="clearfix"></div>
                                <small>
                                    <div class="plano<?= $id_planos_usuario ?>">
                                    	<label class="fa"></label> <?= $planos_usuario ?>
                                    </div>
                                </small>
                            </div>
                            
                            <div class="clearfix"></div>

                            <div class="pull-right font-12">
                                <small><?= __('Sua sessão expira em:'); ?> </small><strong><span id="countdown"></span></strong>
                            </div>

                            <script>
                                //controle do tempo restante na sessao
                                var target_date = new Date("<?= date('M d, Y H:i:s', $this->request->Session()->read('Config.time')) ?>").getTime();
                                var hours, minutes, seconds;
                                var countdown = document.getElementById("countdown");

                                //Identifica timezone
                                var target_test = new Date("<?= date('M d, Y H:i:s', $this->request->Session()->read('Config.time')) ?>");
                                var offset = new Date().getTimezoneOffset();
                                //var diferenca    = 180 - Number(offset);
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
                                            //location.reload(); 
                                            location.href = "<?= $this->Url->build('/logout', true); ?>";
                                        } else {
                                            countdown.innerHTML = minutes + ":" + seconds;
                                        }
                                    }
                                }, 1000);
                            </script>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                            <li>
                                <?= $this->Html->link(('Meus dados'), ['controller' => 'Usuarios', 'action' => 'dados'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Meus Dados', 'title' => 'Meus dados', 'aria-hidden' => true, 'escape' => false]) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(('Alterar minha senha'), ['controller' => 'Usuarios', 'action' => 'senha'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-tamanho' => 'sm', 'data-title' => 'Alterar Minha Senha', 'title' => 'Alterar minha senha', 'aria-hidden' => true, 'escape' => false]) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(('Dados bancários'), ['controller' => 'Usuarios', 'action' => 'banco'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-tamanho' => 'sm', 'data-title' => 'Dados Bancários', 'title' => 'Dados bancários', 'aria-hidden' => true, 'escape' => false]) ?>
                            </li>
                            <li>
                                <?= $this->Html->link('<i class="fa fa-sign-out pull-right" aria-hidden="true"></i> Sair', ['controller' => 'Pages', 'action' => 'logout'], ['escape' => false]) ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="top-10 row bg_cinza">
                    <div class="col-xs-12">
                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <!-- AVISOS PARA VERSAO MOVEL -->
                                <div class="top-20 visible-xs-block col-xs-offset-1 col-xs-6">
                                    <a href="<?= $link_avisos ?>" class="btn-avisos btn_modal <?php if ($count_avisos > 0 ) echo 'avisos-alerta'; ?>" data-loading-text="Carregando..." data-title="Avisos">
                                        <span class="fa-stack fa-lg">
                                            <i class="fa fa-circle fa-stack-2x"></i>
                                            <i class="fa fa-bell-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <span class="badge" data-count="<?= $count_avisos ?>">
                                            <?= $count_avisos ?> <?= __('Avisos'); ?>
                                        </span>
                                    </a>
                                </div>
                                <!-- FIM AVISOS PARA VERSAO MOVEL -->
                                
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-reiniciando">
                                    <span>Menu</span>
                                    <span class="icon-bar top-bar"></span>
                                    <span class="icon-bar middle-bar"></span>
                                    <span class="icon-bar bottom-bar"></span>
                                </button>
                            </div>

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
                                        echo '<div class="alert alert-danger" role="alert">ERRO ao carregar itens do menu, por favor entre em contato com o Administrador através do Suporte no <strong>Rodapé do painel</strong>.</div>'
                                        
                                ?>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <?php if ($alerta = $this->Flash->render()): ?>
            <div class="container-fluid">
                <div class="top-20 col-xs-12">
                    <?= $alerta ?>
                </div>
            </div>
        <?php endif; ?>

        <?= $this->fetch('content') ?>
        <?= $this->element('modal') ?>

        <footer>
            <?= $this->element('footer') ?>
        </footer>
    </body>
</html>