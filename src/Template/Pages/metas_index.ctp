<!-- Metas -->
<div class="container-fluid noPadding">

    <?= $this->element('navbar-side-system') ?>
    
    <div class="col-xs-12 col-sm-9 col-md-10">
        <div class="no-padding-lat">
            <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Pages', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Nova Meta']) ?></div>
            <h3 class="page-header top-20"><?= __('Metas') ?></h3>
        </div>
        
        <?= $this->element('msg-alert') ?>
        
        <div class="scrolling bottom-40 col-xs-12 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="text-nowrap width-50"><?= __('#') ?></th>
                        <th><?= __('Descrição') ?></th>
                        <th class="col-xs-1"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= str_pad(1234, 6, '0', STR_PAD_LEFT) ?></td>
                        <td style="white-space: normal"><?= '<i class="fa fa-users" aria-hidden="true" title="Meta de Indicações"></i> Descrição da Meta de Indicação' ?></td>
                        <td class="col-xs-1">
                            <?= $this->Html->link('<i class="fa fa-eye"></i> Ver/Editar', ['controller' => 'Pages', 'action' => 'edit'], ['class' => 'top-5 btn btn-default btn-block btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Dados do Cadastro', 'title' => 'Visualizar / Editar', 'aria-hidden' => true, 'escape' => false]) ?>
                            <div class="clearfix"></div>
                            <?= $this->Form->postLink('<i class="fa fa-trash"></i> Apagar', ['controller' => 'Pages', 'action' => 'delete'], ['confirm' => 'Você tem certeza que deseja excluir o registro?', 'class' => 'top-5 btn btn-danger btn-block', 'title' => 'Excluir', 'aria-hidden' => true, 'escape' => false]) ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?= str_pad(1235, 6, '0', STR_PAD_LEFT) ?></td>
                        <td style="white-space: normal"><?= '<i class="fa fa-handshake-o fa-fw" aria-hidden="true" title="Meta de Vendas"></i> Descrição da Meta de Vendas' ?></td>
                        <td class="col-xs-1">
                            <?= $this->Html->link('<i class="fa fa-eye"></i> Ver/Editar', ['controller' => 'Pages', 'action' => 'edit'], ['class' => 'top-5 btn btn-default btn-block btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Dados do Cadastro', 'title' => 'Visualizar / Editar', 'aria-hidden' => true, 'escape' => false]) ?>
                            <div class="clearfix"></div>
                            <?= $this->Form->postLink('<i class="fa fa-trash"></i> Apagar', ['controller' => 'Pages', 'action' => 'delete'], ['confirm' => 'Você tem certeza que deseja excluir o registro?', 'class' => 'top-5 btn btn-danger btn-block', 'title' => 'Excluir', 'aria-hidden' => true, 'escape' => false]) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        
            <div class="panel-heading" style="font-size: 11px;">
                <strong><?= __('Legenda:') ?></strong><br />
                <span><i class="fa fa-users" aria-hidden="true" title="Meta de Indicações"></i> <?= __('Meta de Indicações') ?> </span><br>
                <span><i class="fa fa-handshake-o fa-fw" aria-hidden="true" title="Meta de Vendas"></i> <?= __('Meta de Vendas') ?></span><br>
            </div>
        </div>
    </div>