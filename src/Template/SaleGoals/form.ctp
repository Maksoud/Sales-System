<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/SaleGoals/form.ctp */

//Inclusão e edição de meta (modal)
$this->layout = 'ajax';
$url  = $meta ? ['action' => 'edit', $meta->id] : ['action' => 'add'];
$tipo = $meta ? $meta->tipo : 'I';

//Os campos do prêmio têm nomes diferentes na inclusão e na edição (mantidos como estavam)
$campoPremio = $meta ? 'benefits_products_id' : 'benefit_products_id';
$campoQtd    = $meta ? 'qtganha' : 'howmuch';

$tipos = [
    'I' => ['fa-users',         __('Indicação'), __('Novos indicados diretos')],
    'V' => ['fa-shopping-cart', __('Venda'),     __('Produtos comprados')],
];
?>

<?= $this->Form->create(null, ['url' => $url]) ?>

    <div id="ajax-retorno"></div>

    <?php if ($meta): ?>
        <?= $this->Form->hidden('id', ['value' => $meta->id]) ?>
    <?php endif; ?>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Tipo de meta') ?></h4>
        <ul class="ss-choices" role="radiogroup" aria-label="<?= __('Tipo de meta') ?>">
            <?php foreach ($tipos as $valor => $item): ?>
            <li>
                <label class="ss-choice">
                    <input type="radio" name="tipo" value="<?= $valor ?>" id="tipo-<?= strtolower($valor) ?>"
                           <?= $tipo == $valor ? 'checked' : '' ?> required>
                    <span class="ss-choice-card">
                        <i class="fa <?= $item[0] ?>" aria-hidden="true"></i>
                        <span class="ss-choice-title"><?= $item[1] ?></span>
                        <span class="ss-choice-desc"><?= $item[2] ?></span>
                    </span>
                </label>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Plano e meta') ?></h4>
        <p class="ss-form-section-desc"><?= __('Qual plano recebe a meta e o que precisa alcançar.') ?></p>
        <div class="row">
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="from-plans-id" class="ss-required"><?= __('Plano') ?></label>
                <?= $this->Form->select('from_plans_id', $planos,
                        ['class' => 'form-control', 'id' => 'from-plans-id', 'required' => true,
                         'value' => $meta ? $meta->de_planos_id : '']) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="goal" class="ss-required"><?= __('Quantidade') ?></label>
                <?= $this->Form->number('goal', ['class' => 'form-control', 'id' => 'goal', 'required' => true,
                        'min' => 1, 'step' => 1, 'inputmode' => 'numeric', 'placeholder' => __('Ex.: 100'),
                        'aria-describedby' => 'goal-help', 'value' => $meta ? $meta->meta : '']) ?>
                <span class="help-block" id="goal-help"><?= __('Indicações ou vendas para atingir a meta.') ?></span>
            </div>
            <div id="tipo_indicacao" class="col-xs-12 col-sm-4 form-group<?= $tipo == 'I' ? '' : ' hidden' ?>">
                <label for="to-plans-id"><?= __('Indicações de') ?></label>
                <?= $this->Form->select('to_plans_id', $planos,
                        ['class' => 'form-control', 'id' => 'to-plans-id', 'aria-describedby' => 'to-plans-help',
                         'value' => $meta ? $meta->para_planos_id : '']) ?>
                <span class="help-block" id="to-plans-help"><?= __('Plano dos novos associados.') ?></span>
            </div>
            <div id="tipo_venda" class="col-xs-12 col-sm-4 form-group<?= $tipo == 'V' ? '' : ' hidden' ?>">
                <label for="products-id"><?= __('Vendas de') ?></label>
                <?= $this->Form->select('products_id', $produtos,
                        ['class' => 'form-control', 'id' => 'products-id', 'aria-describedby' => 'products-help',
                         'value' => $meta ? $meta->produtos_id : '']) ?>
                <span class="help-block" id="products-help"><?= __('Produto que precisa ser vendido.') ?></span>
            </div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Prêmio') ?></h4>
        <p class="ss-form-section-desc"><?= __('O que o associado ganha ao atingir a meta.') ?></p>
        <div class="row">
            <div class="col-xs-12 col-sm-8 form-group">
                <label for="<?= $campoPremio ?>" class="ss-required"><?= __('Produto') ?></label>
                <?= $this->Form->select($campoPremio, $produtos,
                        ['class' => 'form-control', 'id' => $campoPremio, 'required' => true,
                         'value' => $meta ? $meta->bonificacao_produtos_id : '']) ?>
            </div>
            <div class="col-xs-6 col-sm-4 form-group">
                <label for="<?= $campoQtd ?>" class="ss-required"><?= __('Quantidade') ?></label>
                <?= $this->Form->number($campoQtd, ['class' => 'form-control', 'id' => $campoQtd, 'required' => true,
                        'min' => 1, 'step' => 1, 'inputmode' => 'numeric', 'placeholder' => __('Ex.: 1'),
                        'value' => $meta ? $meta->qtganha : '']) ?>
            </div>
        </div>
    </section>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?php if ($meta): ?>
        <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i> ' . __('Excluir'),
                ['action' => 'delete', $meta->id],
                ['confirm' => __('Excluir esta meta? Esta ação não pode ser desfeita.'),
                 'class' => 'btn ss-btn-danger-soft ss-footer-start', 'escape' => false, 'block' => true]) ?>
    <?php endif; ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button($meta ? __('Salvar') : __('Cadastrar'),
            ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->fetch('postLink') ?>

<script>
    //Mostra o campo "Indicações de" ou "Vendas de" conforme o tipo da meta
    $('input[name="tipo"]').on('change', function () {
        $('#tipo_indicacao').toggleClass('hidden', this.value !== 'I');
        $('#tipo_venda').toggleClass('hidden', this.value !== 'V');
    });
</script>
