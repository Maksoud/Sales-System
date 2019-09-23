<!-- Produtos -->
<div class="container-fluid noPadding">

    <?= $this->element('navbar-side-system') ?>
    
    <div class="col-xs-12 col-sm-9 col-md-10">
        <div class="no-padding-lat">
            <div class="pull-right"><?= $this->Html->link((' Incluir'), ['controller' => 'Pages', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Novo Produto']) ?></div>
            <h3 class="page-header top-20"><?= __('Produtos') ?></h3>
        </div>
        
        <?= $this->element('msg-alert') ?>
        
        <div class="row form-busca bottom-10">
            <div class="col-md-12">
                <?=$this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']);?>    
                <?=$this->Form->text('title', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Digite uma descrição', 'value' => @$this->request->query['title']]);?> 
                <?=$this->Form->select('status', ['A' => 'Ativo',
                                                  'I' => 'Inativo'
                                                 ], ['class' => 'form-control', 'label' => false, 'empty' => '- status -', 'value' => @$this->request->query['status']]);?> 
                <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> <?= __('Buscar') ?></button>
                <?=$this->Html->link('<i class="fa fa-list" aria-hidden="true"></i> Listar Todos', ['action' => 'index'], ['class'=>'btn btn-default', 'escape' => false]);?>
                <?=$this->Form->end();?>        
            </div>
        </div>
        
        <div class="scrolling bottom-40 col-xs-12 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="text-nowrap width-50"><?= __('#') ?></th>
                        <th class="text-nowrap col-xs-1"><?= __('Data de Cadastro') ?></th>
                        <th class="text-center width-50"><?= __('Imagem') ?></th>
                        <th class="text-nowrap"><?= __('Descrição') ?></th>
                        <th class="text-nowrap col-xs-1"><?= __('Status') ?></th>
                        <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= str_pad(1234, 6, '0', STR_PAD_LEFT) ?></td>
                        <td><?= $this->MyHtml->date('2019-09-23') ?></td>
                        <td><?= $this->Html->image('produtos/produto.jpg', ['class' => 'img-responsive img-circle', 'style' => 'height: 40px; width: 40px;']); ?></td>
                        <td><?= '<i class="fa fa-sitemap" aria-hidden="true" title="Comissões"></i> Descrição do Produto' ?></td>
                        <td><?= 'Ativo' ?></td>
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
                <span><i class="fa fa-sitemap" aria-hidden="true" title="Comissões"></i> <?= __('Comissões Vinculadas') ?></span>
            </div>
        </div>
    </div>
    
</div>