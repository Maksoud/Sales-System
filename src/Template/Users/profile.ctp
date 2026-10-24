<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/profile.ctp */

//Meus Dados (usuário logado) e edição de cadastro pela gestão ($edicao = true)
$this->layout = 'ajax';
$input = 'form-control';
$url   = $edicao ? ['action' => 'edit', $usuario->id] : ['action' => 'profile'];
?>

<?= $this->Form->create(null, ['url' => $url]) ?>

    <div class="container-fluid">

        <div class="media bottom-10">
            <div class="media-left">
                <?= $this->Html->image('usuarios/' . $usuario->foto, ['class' => 'img-circle', 'style' => 'height: 64px; width: 64px;', 'alt' => '']) ?>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><?= h($usuario->nome) ?></h4>
                <?= h($usuario->login) ?> &middot; <?= $this->Usuarios->plano($usuario) ?>
                <?php if ($usuario->Patrocinador): ?>
                    <br><small class="text-cinza"><?= __('Patrocinador:') ?> <?= h($usuario->Patrocinador->nome) ?></small>
                <?php endif; ?>
            </div>
        </div>

        <h4 class="text-uppercase"><small><?= __('Dados pessoais') ?></small></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-8 form-group">
                <label for="nome"><?= __('Nome completo') ?></label>
                <?= $this->Form->text('nome', ['class' => $input . ' focus', 'id' => 'nome', 'value' => $usuario->nome]) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="nascimento"><?= __('Nascimento') ?></label>
                <?= $this->Form->text('nascimento', ['class' => $input . ' datemask', 'id' => 'nascimento', 'value' => $usuario->nascimento->format('d/m/Y')]) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label><?= $usuario->tipo_de_pessoa == 'J' ? __('CNPJ') : __('CPF') ?></label>
                <div class="form-control" readonly><?= h($usuario->tipo_de_pessoa == 'J' ? $usuario->cnpj : $usuario->cpf) ?></div>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="rg"><?= __('RG') ?></label>
                <?= $this->Form->text('rg', ['class' => $input, 'id' => 'rg', 'value' => $usuario->rg]) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="estado_civil"><?= __('Estado civil') ?></label>
                <?= $this->Form->select('estado_civil', $this->Usuarios->estadoCivilLista(), ['class' => $input, 'id' => 'estado_civil', 'value' => $usuario->estado_civil]) ?>
            </div>
        </div>

        <h4 class="text-uppercase"><small><?= __('Contato') ?></small></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="email"><?= __('E-mail') ?></label>
                <?= $this->Form->email('email', ['class' => $input, 'id' => 'email', 'value' => $usuario->email]) ?>
            </div>
            <div class="col-xs-12 col-sm-6 form-group">
                <label for="telefone"><?= __('Celular') ?></label>
                <?= $this->Form->text('telefone', ['class' => $input . ' phonemask', 'id' => 'telefone', 'value' => $usuario->telefone]) ?>
            </div>
        </div>

        <h4 class="text-uppercase"><small><?= __('Endereço') ?></small></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-3 form-group">
                <label for="cep"><?= __('CEP') ?></label>
                <?= $this->Form->text('cep', ['class' => $input . ' cepmask', 'id' => 'cep', 'value' => $usuario->cep]) ?>
            </div>
            <div class="col-xs-12 col-sm-7 form-group">
                <label for="endereco"><?= __('Endereço') ?></label>
                <?= $this->Form->text('endereco', ['class' => $input, 'id' => 'endereco', 'value' => $usuario->endereco]) ?>
            </div>
            <div class="col-xs-12 col-sm-2 form-group">
                <label for="numero"><?= __('Nº') ?></label>
                <?= $this->Form->text('numero', ['class' => $input, 'id' => 'numero', 'value' => $usuario->numero]) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="complemento"><?= __('Complemento') ?></label>
                <?= $this->Form->text('complemento', ['class' => $input, 'id' => 'complemento', 'value' => $usuario->complemento]) ?>
            </div>
            <div class="col-xs-12 col-sm-3 form-group">
                <label for="bairro"><?= __('Bairro') ?></label>
                <?= $this->Form->text('bairro', ['class' => $input, 'id' => 'bairro', 'value' => $usuario->bairro]) ?>
            </div>
            <div class="col-xs-12 col-sm-3 form-group">
                <label for="cidade"><?= __('Cidade') ?></label>
                <?= $this->Form->text('cidade', ['class' => $input, 'id' => 'cidade', 'value' => $usuario->cidade]) ?>
            </div>
            <div class="col-xs-12 col-sm-2 form-group">
                <label for="estado"><?= __('UF') ?></label>
                <?= $this->Form->select('estado', $this->Usuarios->estadosLista(), ['class' => $input, 'id' => 'estado', 'value' => $usuario->estado]) ?>
            </div>
        </div>

        <?php if ($edicao): ?>
            <h4 class="text-uppercase"><small><?= __('Administração') ?></small></h4>
            <div class="row">
                <div class="col-xs-12 col-sm-6 form-group">
                    <label for="planos_id"><?= __('Plano') ?></label>
                    <?= $this->Form->select('planos_id', $planos, ['class' => $input, 'id' => 'planos_id', 'value' => $usuario->planos_id]) ?>
                </div>
                <div class="col-xs-12 col-sm-6 form-group">
                    <label for="status"><?= __('Status') ?></label>
                    <?= $this->Form->select('status', $this->Usuarios->statusLista(), ['class' => $input, 'id' => 'status', 'value' => $usuario->status]) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'reset', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Gravando...')]) ?>
    <?= $this->Form->end() ?>
</div>
