<!-- Backups -->
<!-- File: src/Template/Backups/index.ctp -->
<div class="container-fluid noPadding">
    <?= $this->element('navbar-side-system') ?>
    <?= $this->Form->create('Backup') ?>
    
    <div class="col-xs-12 col-sm-9 col-md-10">
        <div class="no-padding-lat">
            <div class="pull-right"><?= $this->Form->button(' Excluir Selecionados', ['type' => 'submit', 'class' => 'btn btn-danger fa fa-trash-o', 'div' => false]) ?></div>
            <h3 class="page-header"><?= ('Lista de Arquivos de Backup') ?></h3>
        </div>
        
    <!-- 
    Implementado para corrigir falha de conflito do postLink
    com o Form->button que permite a exclusão de mais de um
    registro ao mesmo tempo. Falha: O primeiro postLink após
    a declaração do Form->create não exibe o <form> no HTML.
    Necessário estar localizado após o Form->button e antes
    da listagem. 07/2017
    -->
    <?= $this->Form->postLink('') ?>
    
        <div class="scrolling bottom-40 col-xs-12 box-panel bg-white">
            <table class="table table-striped box" id="adjustable">
                <thead>
                    <tr>
                        <th class="text-center hidden-print" style="width: 20px">
                            <?= $this->Form->control('select_all', ['type'        => 'checkbox', 
                                                                    'id'          => 'select_all',
                                                                    'label'       => false, 
                                                                    'templates'   => ['inputContainer' => '{{content}}'],
                                                                    'hiddenField' => false,
                                                                    'class'       => 'btn btn-actions',
                                                                   ]) ?>
                        </th>
                        <th class="width-50 text-center"><?= ('#') ?></th>
                        <th class="col-xs-1"><?= ('Criação') ?></th>
                        <th class="col-xs-1"><?= ('Tamanho') ?></th>
                        <th class="text-nowrap"><?= ('Arquivo') ?></th>
                        <th class="text-center"><?= ('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $count = 1;
                foreach ($backups as $backup): ?>
                    <tr>
                        <td class="text-center hidden-print">
                            <div>
                                <?= $this->Form->control('record['.$backup['file'].']', ['type'        => 'checkbox', 
                                                                                         'id'          => 'listRecord_'.$backup['file'],
                                                                                         'multiple'    => true,
                                                                                         'label'       => false, 
                                                                                         'templates'   => ['inputContainer' => '{{content}}'],
                                                                                         'hiddenField' => false,
                                                                                         'class'       => 'btn btn-actions',
                                                                                         'value'       => $backup['file']
                                                                                        ]) ?>
                            </div>
                        </td>
                        <th class="text-center"><?= $count++; ?></th>
                        <td><?= ($backup['modifield']) ?></td>
                        <td class="text-right"><?= $this->Number->precision($backup['size'], 2) ?> Kb</td>
                        <td><?= ($backup['file']) ?></td>
                        <td class="col-xs-1">
                            <?= $this->Html->link('<i class="fa fa-download"></i> Download', ['action' => 'download', $backup['file']], ['class' => 'top-5 btn btn-default btn-block', 'data-loading-text' => 'Carregando...', 'target' => '_blank', 'title' => 'Download', 'aria-hidden' => true, 'escape' => false]) ?>
                            <div class="clearfix"></div>
                            <?= $this->Form->postLink('<i class="fa fa-trash"></i> Apagar', ['action' => 'delete', $backup['file']], ['confirm' => 'Você tem certeza que deseja excluir o registro?', 'class' => 'top-5 btn btn-danger btn-block', 'title' => 'Excluir', 'aria-hidden' => true, 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?= $this->element('paginator-footer-jquery') ?>
    </div>
    <?= $this->Form->end() ?>
    
</div>