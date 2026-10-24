<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Notices/form.ctp */

//Formulário de inclusão e edição de avisos (modal)
$this->layout = 'ajax';
$url = $aviso ? ['action' => 'edit', $aviso->id] : ['action' => 'add'];
?>

<?= $this->Form->create(null, ['url' => $url, 'type' => 'file']) ?>
<?= $this->Html->script('maksoud-datepicker') ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <label for="title"><?= __('Título*') ?></label>
                    <?= $this->Form->text('title', ['class' => 'form-control focus', 'id' => 'title', 'required' => true, 'value' => $aviso ? $aviso->title : '']) ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label for="aviso"><?= __('Mensagem*') ?></label>
                    <?= $this->Form->textarea('aviso', ['class' => 'form-control', 'id' => 'aviso', 'rows' => 6, 'required' => true, 'value' => $aviso ? strip_tags($aviso->aviso) : '']) ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="planos_id"><?= __('Enviar para') ?></label>
                    <?= $this->Form->select('planos_id', $planos, ['class' => 'form-control', 'id' => 'planos_id', 'empty' => __('Todos os associados'), 'value' => $aviso ? $aviso->planos_id : '']) ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="validade"><?= __('Válido até') ?></label>
                    <?= $this->Form->text('validade', ['class' => 'form-control datepicker datemask', 'id' => 'validade', 'placeholder' => __('sem validade'), 'value' => $aviso && $aviso->validade ? $aviso->validade->format('d/m/Y') : '']) ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="banner"><?= __('Imagem (800x400)') ?></label>
                    <?= $this->Form->file('banner', ['id' => 'banner']) ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="youtube"><?= __('Vídeo do YouTube') ?></label>
                    <?= $this->Form->text('youtube', ['class' => 'form-control', 'id' => 'youtube', 'placeholder' => 'https://www.youtube.com/watch?v=...']) ?>
                </div>
            </div>
        </div>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button($aviso ? __('Gravar') : __('Enviar Aviso'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Gravando...')]) ?>
    <?= $this->Form->end() ?>
</div>
