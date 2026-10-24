<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/add.ctp */

$this->layout = 'ajax';
$primeiro = key($planos);
?>

<?= $this->Form->create(null, ['url' => ['action' => 'add']]) ?>

    <div class="ss-alert" role="status">
        <i class="fa fa-info-circle ss-alert-icon" aria-hidden="true"></i>
        <div class="ss-alert-body">
            <?= __('O cadastro fica pendente até o pagamento da taxa de inscrição. A fatura é enviada para o e-mail informado.') ?>
        </div>
    </div>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Plano e patrocínio') ?></h4>
        <span class="control-label ss-required" id="planos-label"><?= __('Plano') ?></span>
        <ul class="ss-choices ss-mb-4" role="radiogroup" aria-labelledby="planos-label">
            <?php foreach ($planos as $id => $titulo): ?>
            <li>
                <label class="ss-choice">
                    <input type="radio" name="planos_id" id="planos_id_<?= $id ?>" value="<?= $id ?>" <?= $id == $primeiro ? 'checked' : '' ?> required>
                    <span class="ss-choice-card">
                        <i class="fa fa-certificate" aria-hidden="true"></i>
                        <span class="ss-choice-title"><?= h($titulo) ?></span>
                        <span class="ss-choice-desc">
                            <?= $taxas[$id]->taxa > 0
                                ? __('Taxa de {0}', $this->Number->currency($taxas[$id]->taxa, 'BRL'))
                                : __('Sem taxa de inscrição') ?>
                        </span>
                    </span>
                </label>
            </li>
            <?php endforeach; ?>
        </ul>

        <?php if ($gestao): ?>
            <div class="form-group">
                <label for="patrocinador_id"><?= __('Patrocinador') ?></label>
                <?= $this->Form->select('patrocinador_id', $patrocinadores,
                        ['class' => 'form-control', 'id' => 'patrocinador_id', 'empty' => __('Direto da empresa')]) ?>
            </div>
        <?php else: ?>
            <dl class="ss-dl">
                <dt><?= __('Patrocinador') ?></dt>
                <dd><?= h($usuario->nome) ?> <span class="ss-muted">(<?= h($usuario->login) ?>)</span></dd>
            </dl>
        <?php endif; ?>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Dados pessoais') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-8 form-group">
                <label for="nome" class="ss-required"><?= __('Nome completo') ?></label>
                <?= $this->Form->text('nome', ['class' => 'form-control focus', 'id' => 'nome', 'required' => true, 'autocomplete' => 'off']) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="tipo_de_pessoa"><?= __('Pessoa') ?></label>
                <?= $this->Form->select('tipo_de_pessoa', ['F' => __('Física'), 'J' => __('Jurídica')],
                        ['class' => 'form-control', 'id' => 'tipo_de_pessoa']) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="cpf" class="ss-required"><?= __('CPF / CNPJ') ?></label>
                <?= $this->Form->text('cpf', ['class' => 'form-control cpfmask', 'id' => 'cpf', 'required' => true, 'inputmode' => 'numeric']) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="rg"><?= __('RG') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
                <?= $this->Form->text('rg', ['class' => 'form-control', 'id' => 'rg', 'inputmode' => 'numeric']) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="nascimento"><?= __('Nascimento') ?> <span class="ss-optional">(<?= __('opcional') ?>)</span></label>
                <?= $this->Form->text('nascimento', ['class' => 'form-control datemask', 'id' => 'nascimento',
                        'placeholder' => 'dd/mm/aaaa', 'inputmode' => 'numeric']) ?>
            </div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Contato e acesso') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="email" class="ss-required"><?= __('E-mail') ?></label>
                <?= $this->Form->email('email', ['class' => 'form-control', 'id' => 'email', 'required' => true,
                        'inputmode' => 'email', 'autocomplete' => 'off', 'aria-describedby' => 'email-help']) ?>
                <span class="help-block" id="email-help"><?= __('A fatura da taxa de inscrição é enviada para cá.') ?></span>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="telefone" class="ss-required"><?= __('Celular') ?></label>
                <?= $this->Form->text('telefone', ['class' => 'form-control phonemask', 'id' => 'telefone', 'required' => true,
                        'inputmode' => 'tel', 'autocomplete' => 'off']) ?>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="login" class="ss-required"><?= __('Login') ?></label>
                <?= $this->Form->text('login', ['class' => 'form-control', 'id' => 'login', 'required' => true,
                        'autocomplete' => 'off', 'autocapitalize' => 'none']) ?>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="password" class="ss-required"><?= __('Senha inicial') ?></label>
                <?= $this->Form->password('password', ['class' => 'form-control', 'id' => 'password', 'required' => true,
                        'autocomplete' => 'new-password']) ?>
            </div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Endereço de entrega') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-3 form-group">
                <label for="cep"><?= __('CEP') ?></label>
                <?= $this->Form->text('cep', ['class' => 'form-control cepmask', 'id' => 'cep', 'placeholder' => __('Ex.: 60000-000'),
                        'inputmode' => 'numeric']) ?>
            </div>
            <div class="col-xs-12 col-sm-7 form-group">
                <label for="endereco"><?= __('Endereço') ?></label>
                <?= $this->Form->text('endereco', ['class' => 'form-control', 'id' => 'endereco']) ?>
            </div>
            <div class="col-xs-6 col-sm-2 form-group">
                <label for="numero"><?= __('Número') ?></label>
                <?= $this->Form->text('numero', ['class' => 'form-control', 'id' => 'numero']) ?>
            </div>
            <div class="col-xs-6 col-sm-5 form-group">
                <label for="bairro"><?= __('Bairro') ?></label>
                <?= $this->Form->text('bairro', ['class' => 'form-control', 'id' => 'bairro']) ?>
            </div>
            <div class="col-xs-8 col-sm-5 form-group">
                <label for="cidade"><?= __('Cidade') ?></label>
                <?= $this->Form->text('cidade', ['class' => 'form-control', 'id' => 'cidade']) ?>
            </div>
            <div class="col-xs-4 col-sm-2 form-group">
                <label for="estado"><?= __('UF') ?></label>
                <?= $this->Form->select('estado', $this->Usuarios->estadosLista(),
                        ['class' => 'form-control', 'id' => 'estado', 'value' => $usuario->estado ?: 'CE']) ?>
            </div>
        </div>
    </section>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Cadastrar'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
