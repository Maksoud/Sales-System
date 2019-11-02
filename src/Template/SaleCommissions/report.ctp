<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */ 

/* File: src/Template/Pages/SaleCommissions/report.ctp */

$this->layout = 'ajax'; 
?>

<?= $this->Form->create(null, ['url' => ['controller' => 'SaleCommissions', 'action' => 'report'], 'target' => '_blank']);?>
<?= $this->Html->script('maksoud-datepicker') ?>

    <div class="container-fluid">
        
        <div class="row">
            <div id="ajax-retorno" class="col-xs-12"></div>
        </div>
        
        <div class="row">
            
            <div class="col-md-12">
                <div class="row">
                     <div class="col-md-6"> 
                         <div class="form-group">
                            <label for="start_date"><?= __('Data Início:'); ?></label>
                            <?= $this->Form->text('start_date', ['class' => 'form-control datepicker datemask', 'id' => 'start_date', 'label' => false, 'required']);?> 
                         </div> 
                     </div> 
                     <div class="col-md-6"> 
                         <div class="form-group">
                            <label for="end_date"><?= __('Data Final:'); ?></label>
                            <?= $this->Form->text('end_date', ['class' => 'form-control datepicker datemask', 'id' => 'end_date', 'label' => false,'required']);?> 
                         </div> 
                     </div>  
                </div>
              </div>

              <div class="col-md-12">  
                  <div class="form-group">
                    <label for="user"><?= __('Associado:'); ?></label>
                    <?= $this->Form->select('user', ['opção 1', 'opção 2', 'opção 3', 'opção 4'], 
                                                    ['class' => 'form-control', 'id' => 'user', 'label' => false, 'empty' => '- todos -']);?>   
                  </div>
              </div>
              
              <div class="col-md-12">  
                  <div class="form-group">
                    <label for="type"><?= __('Tipo:'); ?></label>
                    <?= $this->Comissoes->select_tipos('type', ['class' => 'form-control', 'id' => 'type', 'label' => false, 'empty' => '- todos -']);?>                                   
                  </div>
              </div>

        </div>
        
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Gerar Relatório'), ['type' => 'submit', 'class' => 'btn btn-primary scroll-modal', 'data-loading-text' => __('Gerando...'), 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>