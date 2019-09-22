<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('head') ?>
    </head>
    <body>
        <div class="bg_ajax hide">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br><br>
            Carregando
        </div>
        
        <header>
            <div class="container-fluid aSemUnderline">
                <div class="row">
                    <div class="top-5 col-xs-6 col-sm-4">
                        <?= $this->Html->image("Reiniciando.png", ['alt'      => 'Reiniciando',
                                                                 //'width'    => '210px',
                                                                   'style'    => 'height: 62px;',
                                                                   'class'    => 'img-responsive',
                                                                   'id'       => 'logo',
                                                                   'data-url' => $this->Url->build('/', true)
                                                                  ]
                                              );
                        ?>
                    </div>
                    <div class="top-15 col-xs-6 col-sm-4">
                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                            <li>
                                <?= $this->Html->link(('Cadastre-se'), ['controller' => 'Usuarios', 'action' => 'add'], ['class' => 'btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Cadastre-se', 'title' => 'Cadastre-se', 'aria-hidden' => true, 'escape' => false]) ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="top-10 row bg_cinza">
                    <div class="col-xs-12">
                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-reiniciando">
                                    <span>Menu</span>
                                    <span class="icon-bar top-bar"></span>
                                    <span class="icon-bar middle-bar"></span>
                                    <span class="icon-bar bottom-bar"></span>
                                </button>
                            </div>

                            <div class="collapse navbar-collapse" id="menu-reiniciando">
                                <ul class="nav navbar-nav">
                                    <?= $this->element('menus/cliente'); ?>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <?= $this->fetch('content') ?>
        <?= $this->element('modal') ?>
        <?= $this->element('chat') ?>

        <footer>
            <?= $this->element('footer') ?>
        </footer>
    </body>
</html>