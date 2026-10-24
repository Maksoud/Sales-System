<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/SaleCommissions/form.ctp */

//Inclusão e edição de regra de comissão (modal)
$this->layout = 'ajax';
$url = $comissao ? ['action' => 'edit', $comissao->id] : ['action' => 'add'];
$multinivel = $comissao && in_array($comissao->tipo, ['IM', 'VM']);
?>

<?= $this->Form->create(null, ['url' => $url]) ?>

    <div id="ajax-retorno"></div>

    <?php if ($comissao): ?>
        <?= $this->Form->hidden('id', ['value' => $comissao->id]) ?>
        <dl class="ss-dl ss-mb-6">
            <dt><?= __('Código') ?></dt>
            <dd><span class="ss-id">#<?= str_pad($comissao->id, 6, '0', STR_PAD_LEFT) ?></span></dd>
            <dt><?= __('Regra atual') ?></dt>
            <dd>
                <?= $this->Number->toPercentage($comissao->porcentagem, $comissao->porcentagem == (int)$comissao->porcentagem ? 0 : 1) ?>
                <?= $comissao->origem == 'T' ? __('sobre a taxa de inscrição') : __('sobre os pedidos da loja (sem frete)') ?>,
                <?= __n('{0} nível acima de quem pagou', '{0} níveis acima de quem pagou', $comissao->nivel, $comissao->nivel) ?>
            </dd>
        </dl>
    <?php endif; ?>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Planos') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="from-plans-id" class="ss-required"><?= __('Plano que recebe') ?></label>
                <?= $this->Form->select('from_plans_id', $planos,
                        ['class' => 'form-control focus', 'id' => 'from-plans-id', 'required' => true,
                         'empty' => __('Selecione'), 'aria-describedby' => 'from-help']) ?>
                <span class="help-block" id="from-help"><?= __('Em geral, quem indicou ou vendeu.') ?></span>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="to-plans-id" class="ss-required"><?= __('Plano de quem paga') ?></label>
                <?= $this->Form->select('to_plans_id', $planos,
                        ['class' => 'form-control', 'id' => 'to-plans-id', 'required' => true,
                         'empty' => __('Selecione'), 'aria-describedby' => 'to-help']) ?>
                <span class="help-block" id="to-help"><?= __('Quem se cadastra ou faz a compra.') ?></span>
            </div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Comissão') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="type" class="ss-required"><?= __('Tipo') ?></label>
                <?= $this->Form->select('type', $this->Comissoes->tipos,
                        ['class' => 'form-control', 'id' => 'type', 'required' => true, 'empty' => __('Selecione'),
                         'value' => $comissao ? $comissao->tipo : '']) ?>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="value" class="ss-required"><?= __('Valor a pagar') ?></label>
                <div class="input-group">
                    <span class="input-group-addon">R$</span>
                    <?= $this->Form->text('value', ['class' => 'form-control valuemask', 'id' => 'value', 'required' => true,
                            'inputmode' => 'decimal', 'autocomplete' => 'off']) ?>
                </div>
            </div>
            <div class="col-xs-12 form-group">
                <label for="products-id"><?= __('Produto') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
                <?= $this->Form->select('products_id', $produtos,
                        ['class' => 'form-control', 'id' => 'products-id', 'empty' => __('Nenhum produto'),
                         'aria-describedby' => 'products-help']) ?>
                <span class="help-block" id="products-help"><?= __('Só para comissões de venda.') ?></span>
            </div>
            <div class="col-xs-12 form-group">
                <div class="checkbox ss-mb-0">
                    <label>
                        <?= $this->Form->checkbox('multi', ['id' => 'multi', 'hiddenField' => false, 'checked' => $multinivel,
                                'aria-describedby' => 'multi-help']) ?>
                        <?= __('Comissão multinível') ?>
                    </label>
                </div>
                <span class="help-block" id="multi-help"><?= __('O patrocinador do patrocinador também recebe.') ?></span>
            </div>
        </div>
    </section>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?php if ($comissao): ?>
        <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i> ' . __('Excluir'),
                ['action' => 'delete', $comissao->id],
                ['confirm' => __('Excluir a comissão {0}? Esta ação não pode ser desfeita.', $this->Comissoes->tipo($comissao->tipo)),
                 'class' => 'btn ss-btn-danger-soft ss-footer-start', 'escape' => false, 'block' => true]) ?>
    <?php endif; ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button($comissao ? __('Salvar') : __('Cadastrar'),
            ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->fetch('postLink') ?>
