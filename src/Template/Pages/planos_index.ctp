<!-- Planos -->
<div class="container-fluid noPadding">

    <?= $this->element('navbar-side-system') ?>
    
    <div class="col-xs-12 col-sm-9 col-md-10">
        <div class="no-padding-lat">
            <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Pages', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Novo Plano']) ?></div>
            <h3 class="page-header top-20"><?= __('Planos') ?></h3>
        </div>
        
        <?= $this->element('msg-alert') ?>
        
        <div class="scrolling bottom-40 col-xs-12 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="text-nowrap width-50"><?= __('#') ?></th>
                        <th class="text-nowrap col-xs-1"><?= __('Data de Cadastro') ?></th>
                        <th class="text-nowrap col-xs-1"><?= __('Descrição') ?></th>
                        <th class="text-nowrap col-xs-1"><?= __('Taxa Plano') ?></th>
                        <th class="text-nowrap"><?= __('Produto') ?></th>
                        <th class="text-nowrap col-xs-1"><?= __('Qtd.Produto') ?></th>
                        <th class="text-nowrap col-xs-1"><?= __('Meta de Vendas') ?></th>
                        <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= str_pad(1234, 6, '0', STR_PAD_LEFT) ?></td>
                        <td><?= $this->MyHtml->date('2019-09-23') ?></td>
                        <td><?= 'Descrição do Plano' ?></td>
                        <td><?= $this->Number->currency(1234.56, 'BRL') ?></td>
                        <td><?= $this->Html->link('Descrição do Produto', ['controller' => 'Pages', 'action' => 'view'], ['class' => 'btn_modal', 'data-title' => 'Visualizar Produto']) ?></td>
                        <td><?= $this->Number->format(10) ?></td>
                        <td><?= $this->Number->format(1) ?></td>
                        <td class="col-xs-1">
                            <?= $this->Html->link('<i class="fa fa-eye"></i> Ver/Editar', ['controller' => 'Pages', 'action' => 'edit'], ['class' => 'top-5 btn btn-default btn-block btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Dados do Cadastro', 'title' => 'Visualizar / Editar', 'aria-hidden' => true, 'escape' => false]) ?>
                            <div class="clearfix"></div>
                            <?= $this->Form->postLink('<i class="fa fa-trash"></i> Apagar', ['controller' => 'Pages', 'action' => 'delete'], ['confirm' => 'Você tem certeza que deseja excluir o registro?', 'class' => 'top-5 btn btn-danger btn-block', 'title' => 'Excluir', 'aria-hidden' => true, 'escape' => false]) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</div>