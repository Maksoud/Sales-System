<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Regions/form.ctp */

//Inclusão e edição de região (modal)
$this->layout = 'ajax';
$url = $regiao ? ['action' => 'edit', $regiao->id] : ['action' => 'add'];
$cidades = $regiao ? $regiao->cidades : [];
?>

<?= $this->Form->create(null, ['url' => $url]) ?>

    <div id="ajax-retorno"></div>

    <?php if ($regiao): ?>
        <?= $this->Form->hidden('id', ['value' => $regiao->id]) ?>
        <dl class="ss-dl ss-mb-6">
            <dt><?= __('Código') ?></dt>
            <dd><span class="ss-id">#<?= str_pad($regiao->id, 6, '0', STR_PAD_LEFT) ?></span></dd>
            <dt><?= __('Responsável') ?></dt>
            <dd>
                <?php if (!empty($responsavel)): ?>
                    <?= h($responsavel->nome) ?> <span class="ss-muted">(<?= h($responsavel->login) ?>)</span>
                    <?= $this->Usuarios->plano($responsavel) ?>
                <?php else: ?>
                    <span class="ss-muted">—</span>
                <?php endif; ?>
            </dd>
        </dl>
    <?php endif; ?>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Identificação') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-8 form-group">
                <label for="title" class="ss-required"><?= __('Descrição') ?></label>
                <?= $this->Form->text('title', ['class' => 'form-control focus', 'id' => 'title', 'required' => true,
                        'placeholder' => __('Ex.: São Paulo (011)'), 'value' => $regiao ? $regiao->title : '']) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="exclusive"><?= __('Exclusiva') ?></label>
                <?= $this->Form->select('exclusive', [1 => __('Sim'), 0 => __('Não')],
                        ['class' => 'form-control', 'id' => 'exclusive', 'aria-describedby' => 'exclusive-help',
                         'value' => $regiao && $regiao->exclusiva == 'Sim' ? 1 : 0]) ?>
            </div>
            <div class="col-xs-12">
                <span class="help-block ss-mt-0" id="exclusive-help">
                    <?= __('Exclusiva: só o associado responsável atua na região. Não exclusiva: qualquer associado atua, conforme o plano.') ?>
                </span>
            </div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Cidades') ?></h4>
        <p class="ss-form-section-desc"><?= __('Escolha o país, o estado e a cidade e clique em Adicionar cidade.') ?></p>
        <div class="row">
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="country"><?= __('País') ?></label>
                <?= $this->Form->select('country', ['opção 1', 'opção 2', 'opção 3', 'opção 4'],
                        ['class' => 'form-control', 'id' => 'country', 'empty' => __('Escolha um país')]) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="states"><?= __('Estado') ?></label>
                <select id="states" name="states" class="form-control">
                    <option><?= __('Escolha primeiro o país') ?></option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="cities"><?= __('Cidade') ?></label>
                <select id="cities" name="cities" class="form-control">
                    <option><?= __('Escolha primeiro o estado') ?></option>
                </select>
            </div>
            <div class="col-xs-12 form-group">
                <button type="button" id="btn_add_cidade" class="btn btn-default" disabled="disabled">
                    <i class="fa fa-plus" aria-hidden="true"></i> <?= __('Adicionar cidade') ?>
                </button>
            </div>
        </div>

        <div id="lista_cidades">
            <?php if ($cidades): ?>
                <ul class="ss-chips" aria-label="<?= __('Cidades da região') ?>">
                    <?php foreach ($cidades as $i => $cidade): ?>
                        <li id="cidade<?= $i ?>" class="ss-chip">
                            <input type="hidden" name="cidade[]" value="<?= h($cidade) ?>">
                            <?= h($cidade) ?>
                            <button type="button" class="ss-chip-remove" data-dismiss="alert" data-target="#cidade<?= $i ?>"
                                    data-id="<?= $i ?>" title="<?= __('Remover') ?>" aria-label="<?= __('Remover {0}', $cidade) ?>">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="ss-help ss-mb-0"><?= __('Nenhuma cidade adicionada.') ?></p>
            <?php endif; ?>
        </div>
    </section>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?php if ($regiao): ?>
        <?= $this->Form->postLink('<i class="fa fa-trash-o" aria-hidden="true"></i> ' . __('Excluir'),
                ['action' => 'delete', $regiao->id],
                ['confirm' => __('Excluir a região {0}? Esta ação não pode ser desfeita.', $regiao->title),
                 'class' => 'btn ss-btn-danger-soft ss-footer-start', 'escape' => false, 'block' => true]) ?>
    <?php endif; ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button($regiao ? __('Salvar') : __('Cadastrar'),
            ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->fetch('postLink') ?>
