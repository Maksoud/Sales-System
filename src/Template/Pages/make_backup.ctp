<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */
?>

<!-- Backup -->
<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Backup', ['type' => 'file']) ?>

<?php 
    $double = 'col-xs-6 no-padding-lat width-155';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control form-group width-x317';
    $input_double = 'form-control form-group double-input';
?>

    <div class="container-fluid">
        <div class="col-xs-12 main">
            <h4 class="text-center"><?= h('CADASTROS') ?></h4>
            <div class="col-xs-12 col-sm-6">
                <div class="well">
                    <div class="form-group">
                        <?= $this->Form->checkbox('planos', ['hiddenField' => false])?>
                        <strong><label>Planos</label></strong>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('regioes', ['hiddenField' => false])?>
                        <strong><label>Regiões</label></strong>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('produtos', ['hiddenField' => false])?>
                        <strong><label>Produtos</label></strong>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('associados', ['hiddenField' => false])?>
                        <strong><label>Associados</label></strong>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="well">
                    <div class="form-group">
                        <?= $this->Form->checkbox('metas', ['hiddenField' => false])?>
                        <strong><label>Metas</label></strong>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('comissoes', ['hiddenField' => false])?>
                        <strong><label>Comissões</label></strong>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('pedidos', ['hiddenField' => false])?>
                        <strong><label>Pedidos</label></strong>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <hr>
            </div>
            <div class="col-xs-12">
                <h4 class="text-center"><?= h('TIPO DE ARQUIVO EXPORTADO') ?></h4>
                <div class="well">
                    <div class="form-group text-center">
                        <div class="radio-inline btn btn-link">
                            <?= $this->Form->radio('radio', ['sql' => 'SQL', 
                                                             'csv' => 'CSV'
                                                            ], 
                                                            ['legend'  => false, 
                                                             'default' => 'csv', 
                                                             'label'   => ['class' => 'radio-inline btn']
                                                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button('Cancelar', ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->button('Gerar', ['type' => 'submit', 'class' => 'btn btn-primary', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>