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
$url = $edicao ? ['action' => 'edit', $usuario->id] : ['action' => 'profile'];
$juridica = $usuario->tipo_de_pessoa == 'J';
?>

<?= $this->Form->create(null, ['url' => $url]) ?>

    <div class="ss-record-header">
        <div class="ss-cell-media">
            <?= $this->Html->image('usuarios/' . $usuario->foto, ['class' => 'ss-avatar ss-avatar--lg', 'alt' => '']) ?>
            <div>
                <h3 class="ss-record-title">
                    <?= h($usuario->nome) ?>
                    <?php if ($edicao): ?><?= $this->Usuarios->statusLabel($usuario->status) ?><?php endif; ?>
                </h3>
                <div class="ss-record-meta">
                    <span><?= h($usuario->login) ?></span>
                    <span><?= $this->Usuarios->plano($usuario) ?></span>
                    <?php if ($edicao && $usuario->last_login): ?>
                        <span><?= __('Último acesso em {0}', $this->MyHtml->time($usuario->last_login)) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <dl class="ss-dl ss-mb-6">
        <dt><?= $juridica ? __('CNPJ') : __('CPF') ?></dt>
        <dd><span class="ss-mono"><?= h($juridica ? $usuario->cnpj : $usuario->cpf) ?></span></dd>
        <dt><?= __('Patrocinador') ?></dt>
        <dd>
            <?php if ($usuario->Patrocinador): ?>
                <?= h($usuario->Patrocinador->nome) ?> <span class="ss-muted">(<?= h($usuario->Patrocinador->login) ?>)</span>
            <?php else: ?>
                <span class="ss-muted"><?= __('Direto da empresa') ?></span>
            <?php endif; ?>
        </dd>
    </dl>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Dados pessoais') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-8 form-group">
                <label for="nome"><?= __('Nome completo') ?></label>
                <?= $this->Form->text('nome', ['class' => 'form-control focus', 'id' => 'nome', 'value' => $usuario->nome,
                        'autocomplete' => 'name']) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="nascimento"><?= __('Nascimento') ?></label>
                <?= $this->Form->text('nascimento', ['class' => 'form-control datemask', 'id' => 'nascimento',
                        'value' => $usuario->nascimento->format('d/m/Y'), 'placeholder' => 'dd/mm/aaaa', 'inputmode' => 'numeric']) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="rg"><?= __('RG') ?></label>
                <?= $this->Form->text('rg', ['class' => 'form-control', 'id' => 'rg', 'value' => $usuario->rg, 'inputmode' => 'numeric']) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="estado_civil"><?= __('Estado civil') ?></label>
                <?= $this->Form->select('estado_civil', $this->Usuarios->estadoCivilLista(),
                        ['class' => 'form-control', 'id' => 'estado_civil', 'value' => $usuario->estado_civil]) ?>
            </div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Contato') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-8 form-group">
                <label for="email"><?= __('E-mail') ?></label>
                <?= $this->Form->email('email', ['class' => 'form-control', 'id' => 'email', 'value' => $usuario->email,
                        'autocomplete' => 'email', 'inputmode' => 'email']) ?>
            </div>
            <div class="col-xs-12 col-sm-4 form-group">
                <label for="telefone"><?= __('Celular') ?></label>
                <?= $this->Form->text('telefone', ['class' => 'form-control phonemask', 'id' => 'telefone', 'value' => $usuario->telefone,
                        'autocomplete' => 'tel', 'inputmode' => 'tel']) ?>
            </div>
        </div>
    </section>

    <section class="ss-form-section">
        <h4 class="ss-form-section-title"><?= __('Endereço') ?></h4>
        <div class="row">
            <div class="col-xs-12 col-sm-3 form-group">
                <label for="cep"><?= __('CEP') ?></label>
                <?= $this->Form->text('cep', ['class' => 'form-control cepmask', 'id' => 'cep', 'value' => $usuario->cep,
                        'placeholder' => __('Ex.: 60000-000'), 'autocomplete' => 'postal-code', 'inputmode' => 'numeric']) ?>
            </div>
            <div class="col-xs-12 col-sm-7 form-group">
                <label for="endereco"><?= __('Endereço') ?></label>
                <?= $this->Form->text('endereco', ['class' => 'form-control', 'id' => 'endereco', 'value' => $usuario->endereco,
                        'autocomplete' => 'address-line1']) ?>
            </div>
            <div class="col-xs-6 col-sm-2 form-group">
                <label for="numero"><?= __('Número') ?></label>
                <?= $this->Form->text('numero', ['class' => 'form-control', 'id' => 'numero', 'value' => $usuario->numero]) ?>
            </div>
            <div class="col-xs-6 col-sm-4 form-group">
                <label for="complemento"><?= __('Complemento') ?></label>
                <?= $this->Form->text('complemento', ['class' => 'form-control', 'id' => 'complemento', 'value' => $usuario->complemento,
                        'autocomplete' => 'address-line2']) ?>
            </div>
            <div class="col-xs-12 col-sm-3 form-group">
                <label for="bairro"><?= __('Bairro') ?></label>
                <?= $this->Form->text('bairro', ['class' => 'form-control', 'id' => 'bairro', 'value' => $usuario->bairro]) ?>
            </div>
            <div class="col-xs-8 col-sm-3 form-group">
                <label for="cidade"><?= __('Cidade') ?></label>
                <?= $this->Form->text('cidade', ['class' => 'form-control', 'id' => 'cidade', 'value' => $usuario->cidade,
                        'autocomplete' => 'address-level2']) ?>
            </div>
            <div class="col-xs-4 col-sm-2 form-group">
                <label for="estado"><?= __('UF') ?></label>
                <?= $this->Form->select('estado', $this->Usuarios->estadosLista(),
                        ['class' => 'form-control', 'id' => 'estado', 'value' => $usuario->estado]) ?>
            </div>
        </div>
    </section>

    <?php if ($edicao): ?>
        <section class="ss-form-section">
            <h4 class="ss-form-section-title"><?= __('Administração') ?></h4>
            <div class="row">
                <div class="col-xs-12 col-sm-6 form-group">
                    <label for="planos_id"><?= __('Plano') ?></label>
                    <?= $this->Form->select('planos_id', $planos,
                            ['class' => 'form-control', 'id' => 'planos_id', 'value' => $usuario->planos_id]) ?>
                </div>
                <div class="col-xs-12 col-sm-6 form-group">
                    <label for="status"><?= __('Status') ?></label>
                    <?= $this->Form->select('status', $this->Usuarios->statusLista(),
                            ['class' => 'form-control', 'id' => 'status', 'value' => $usuario->status]) ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

</div> <!-- Encerra o corpo do modal para iniciar o rodapé -->

<div class="modal-footer">
    <?= $this->Form->button(__('Cancelar'), ['type' => 'button', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    <?= $this->Form->button(__('Salvar'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-loading-text' => __('Salvando...')]) ?>
    <?= $this->Form->end() ?>
</div>
