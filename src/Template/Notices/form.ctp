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

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Mensagem') ?></h4>
        <div class="row">
            <div class="col-xs-12 form-group">
                <label for="title" class="ss-required"><?= __('Título') ?></label>
                <?= $this->Form->text('title', ['class' => 'form-control focus', 'id' => 'title', 'required' => true,
                        'value' => $aviso ? $aviso->title : '']) ?>
            </div>
            <div class="col-xs-12 form-group">
                <label for="aviso" class="ss-required"><?= __('Mensagem') ?></label>
                <?= $this->Form->textarea('aviso', ['class' => 'form-control', 'id' => 'aviso', 'rows' => 6, 'required' => true,
                        'value' => $aviso ? strip_tags($aviso->aviso) : '', 'aria-describedby' => 'aviso-help']) ?>
                <span class="help-block" id="aviso-help"><?= __('Aparece no sino do cabeçalho de quem recebe.') ?></span>
            </div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Envio') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="planos_id"><?= __('Enviar para') ?></label>
                <?= $this->Form->select('planos_id', $planos, ['class' => 'form-control', 'id' => 'planos_id',
                        'empty' => __('Todos os associados'), 'value' => $aviso ? $aviso->planos_id : '']) ?>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="validade"><?= __('Válido até') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
                <div class="input-group">
                    <?= $this->Form->text('validade', ['class' => 'form-control datepicker datemask', 'id' => 'validade',
                            'placeholder' => 'dd/mm/aaaa', 'autocomplete' => 'off', 'inputmode' => 'numeric',
                            'aria-describedby' => 'validade-help',
                            'value' => $aviso && $aviso->validade ? $aviso->validade->format('d/m/Y') : '']) ?>
                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                </div>
                <span class="help-block" id="validade-help"><?= __('Em branco, o aviso não vence.') ?></span>
            </div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Mídia') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="banner"><?= __('Imagem') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
                <?= $this->Form->file('banner', ['id' => 'banner', 'accept' => 'image/*', 'aria-describedby' => 'banner-help']) ?>
                <span class="help-block" id="banner-help"><?= __('JPG ou PNG, 800 × 400 px.') ?></span>
                <?php if ($aviso && $aviso->banner): ?>
                    <?= $this->Html->image($aviso->banner, ['class' => 'ss-figure', 'alt' => __('Imagem atual')]) ?>
                <?php endif; ?>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="youtube"><?= __('Vídeo do YouTube') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
                <?= $this->Form->text('youtube', ['class' => 'form-control', 'id' => 'youtube', 'inputmode' => 'url',
                        'placeholder' => 'Ex.: https://www.youtube.com/watch?v=...',
                        'value' => $aviso ? $aviso->youtube : '']) ?>
            </div>
        </div>
    </section>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?php if ($aviso): ?>
        <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i> ' . __('Excluir'),
                ['action' => 'delete', $aviso->id],
                ['confirm' => __('Excluir o aviso "{0}"? Esta ação não pode ser desfeita.', $aviso->title),
                 'class' => 'btn ss-btn-danger-soft ss-footer-start', 'escape' => false, 'block' => true]) ?>
    <?php endif; ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button($aviso ? __('Salvar') : __('Enviar aviso'),
            ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->fetch('postLink') ?>
