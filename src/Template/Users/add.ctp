<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/add.ctp */

$this->layout = 'ajax';
$input = 'form-control';
?>

<?= $this->Form->create(null, ['url' => ['action' => 'add']]) ?>

    <div class="container-fluid">

        <h4 class="text-uppercase"><small><?= __('Plano e patrocínio') ?></small></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="planos_id"><?= __('Plano*') ?></label>
                <select name="planos_id" id="planos_id" class="<?= $input ?>" required>
                    <?php foreach ($planos as $id => $titulo): ?>
                        <option value="<?= $id ?>"><?= h($titulo) ?><?= $taxas[$id]->taxa > 0 ? ' - ' . __('taxa de') . ' ' . $this->Number->currency($taxas[$id]->taxa, 'BRL') : '' ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="patrocinador_id"><?= __('Patrocinador') ?></label>
                <?php if ($gestao): ?>
                    <?= $this->Form->select('patrocinador_id', $patrocinadores, ['class' => $input, 'id' => 'patrocinador_id', 'empty' => __('Direto da empresa')]) ?>
                <?php else: ?>
                    <div class="form-control" readonly><?= h($usuario->nome) ?> (<?= h($usuario->login) ?>)</div>
                <?php endif; ?>
            </div>
        </div>

        <h4 class="text-uppercase"><small><?= __('Dados pessoais') ?></small></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-8 form-group">
                <label for="nome"><?= __('Nome completo*') ?></label>
                <?= $this->Form->text('nome', ['class' => $input . ' focus', 'id' => 'nome', 'required' => true]) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="tipo_de_pessoa"><?= __('Pessoa') ?></label>
                <?= $this->Form->select('tipo_de_pessoa', ['F' => __('Física'), 'J' => __('Jurídica')], ['class' => $input, 'id' => 'tipo_de_pessoa']) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="cpf"><?= __('CPF / CNPJ*') ?></label>
                <?= $this->Form->text('cpf', ['class' => $input . ' cpfmask', 'id' => 'cpf', 'required' => true]) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="rg"><?= __('RG') ?></label>
                <?= $this->Form->text('rg', ['class' => $input, 'id' => 'rg']) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="nascimento"><?= __('Nascimento') ?></label>
                <?= $this->Form->text('nascimento', ['class' => $input . ' datemask', 'id' => 'nascimento', 'placeholder' => 'dd/mm/aaaa']) ?>
            </div>
        </div>

        <h4 class="text-uppercase"><small><?= __('Contato e acesso') ?></small></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="email"><?= __('E-mail*') ?></label>
                <?= $this->Form->email('email', ['class' => $input, 'id' => 'email', 'required' => true]) ?>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="telefone"><?= __('Celular*') ?></label>
                <?= $this->Form->text('telefone', ['class' => $input . ' phonemask', 'id' => 'telefone', 'required' => true]) ?>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="login"><?= __('Login*') ?></label>
                <?= $this->Form->text('login', ['class' => $input, 'id' => 'login', 'required' => true]) ?>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="password"><?= __('Senha inicial*') ?></label>
                <?= $this->Form->password('password', ['class' => $input, 'id' => 'password', 'required' => true]) ?>
            </div>
        </div>

        <h4 class="text-uppercase"><small><?= __('Endereço de entrega') ?></small></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-3 form-group">
                <label for="cep"><?= __('CEP') ?></label>
                <?= $this->Form->text('cep', ['class' => $input . ' cepmask', 'id' => 'cep']) ?>
            </div>
            <div class="col-xs-12 col-sm-7 form-group">
                <label for="endereco"><?= __('Endereço') ?></label>
                <?= $this->Form->text('endereco', ['class' => $input, 'id' => 'endereco']) ?>
            </div>
            <div class="col-xs-12 col-sm-2 form-group">
                <label for="numero"><?= __('Nº') ?></label>
                <?= $this->Form->text('numero', ['class' => $input, 'id' => 'numero']) ?>
            </div>
            <div class="col-xs-12 col-sm-5 form-group">
                <label for="bairro"><?= __('Bairro') ?></label>
                <?= $this->Form->text('bairro', ['class' => $input, 'id' => 'bairro']) ?>
            </div>
            <div class="col-xs-12 col-sm-5 form-group">
                <label for="cidade"><?= __('Cidade') ?></label>
                <?= $this->Form->text('cidade', ['class' => $input, 'id' => 'cidade']) ?>
            </div>
            <div class="col-xs-12 col-sm-2 form-group">
                <label for="estado"><?= __('UF') ?></label>
                <?= $this->Form->select('estado', $this->Usuarios->estadosLista(), ['class' => $input, 'id' => 'estado', 'value' => $usuario->estado ?: 'CE']) ?>
            </div>
        </div>

        <div class="alert alert-warning">
            <small>
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <?= __('O cadastro fica pendente até o pagamento da taxa de inscrição. A fatura é enviada para o e-mail informado.') ?>
            </small>
        </div>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Cadastrar'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Gravando...')]) ?>
    <?= $this->Form->end() ?>
</div>
