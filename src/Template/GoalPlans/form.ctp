<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/GoalPlans/form.ctp */

//Inclusão e edição de plano (modal)
$this->layout = 'ajax';
$url = $plano ? ['action' => 'edit', $plano->id] : ['action' => 'add'];

//O campo da meta tem nomes diferentes na inclusão e na edição (mantidos como estavam)
$campoMeta = $plano ? 'saleGoals' : 'salesGoals';
?>

<?= $this->Form->create(null, ['url' => $url]) ?>

    <div id="ajax-retorno"></div>

    <?php if ($plano): ?>
        <?= $this->Form->hidden('id', ['value' => $plano->id]) ?>
    <?php endif; ?>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Plano') ?></h4>
        <div class="row">
            <div class="col-xs-12 form-group">
                <label for="title" class="ss-required"><?= __('Nome') ?></label>
                <?= $this->Form->text('title', ['class' => 'form-control focus', 'id' => 'title', 'required' => true,
                        'value' => $plano ? $plano->title : '', 'aria-describedby' => 'title-help']) ?>
                <span class="help-block" id="title-help"><?= __('Um plano novo precisa de ajustes no sistema para funcionar. Fale com o desenvolvedor.') ?></span>
            </div>
            <div class="col-xs-6 form-group">
                <label for="fee" class="ss-required"><?= __('Taxa de inscrição') ?></label>
                <div class="input-group">
                    <span class="input-group-addon">R$</span>
                    <?= $this->Form->text('fee', ['class' => 'form-control valuemask', 'id' => 'fee', 'required' => true,
                            'inputmode' => 'decimal', 'autocomplete' => 'off', 'aria-describedby' => 'fee-help',
                            'value' => $plano ? number_format($plano->taxa, 2, ',', '.') : '']) ?>
                </div>
                <span class="help-block" id="fee-help"><?= __('Pago pelo associado para ativar o cadastro.') ?></span>
            </div>
            <div class="col-xs-6 form-group">
                <label for="<?= $campoMeta ?>"><?= __('Meta mínima de vendas') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
                <?= $this->Form->number($campoMeta, ['class' => 'form-control', 'id' => $campoMeta, 'min' => 0, 'step' => 1,
                        'inputmode' => 'numeric', 'placeholder' => __('Ex.: 100'), 'aria-describedby' => 'meta-help']) ?>
                <span class="help-block" id="meta-help"><?= __('Produtos vendidos por mês.') ?></span>
            </div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Bonificação pela inscrição') ?></h4>
        <p class="ss-form-section-desc"><?= __('Produto que o associado ganha ao entrar no plano.') ?></p>
        <div class="row">
            <div class="col-xs-12 col-sm-8 form-group">
                <label for="products-id"><?= __('Produto') ?></label>
                <?= $this->Form->select('products_id', $produtos,
                        ['class' => 'form-control', 'id' => 'products-id', 'empty' => __('Sem bonificação'),
                         'value' => $plano ? $plano->produtos_id : '']) ?>
            </div>
            <div class="col-xs-6 col-sm-4 form-group">
                <label for="qtyproducts"><?= __('Quantidade') ?></label>
                <?= $this->Form->number('qtyproducts', ['class' => 'form-control', 'id' => 'qtyproducts', 'min' => 0, 'step' => 1,
                        'inputmode' => 'numeric', 'value' => $plano ? $plano->qtprodutos : '']) ?>
            </div>
        </div>
    </section>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?php if ($plano): ?>
        <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i> ' . __('Excluir'),
                ['action' => 'delete', $plano->id],
                ['confirm' => __('Excluir o plano {0}? Esta ação não pode ser desfeita.', $plano->title),
                 'class' => 'btn ss-btn-danger-soft ss-footer-start', 'escape' => false, 'block' => true]) ?>
    <?php endif; ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button($plano ? __('Salvar') : __('Cadastrar'),
            ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->fetch('postLink') ?>
