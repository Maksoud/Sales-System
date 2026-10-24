<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/view.ctp */

$this->layout = 'ajax';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="media">
                <div class="media-left">
                    <?= $this->Html->image('usuarios/' . $usuario->foto, ['class' => 'img-circle', 'style' => 'height: 64px; width: 64px;', 'alt' => '']) ?>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?= h($usuario->nome) ?></h4>
                    <?= h($usuario->login) ?> &middot; <?= $this->Usuarios->plano($usuario) ?>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-xs-12 col-sm-6 form-group">
                    <h5><strong><?= __('Documento') ?></strong></h5>
                    <?php if ($usuario->tipo_de_pessoa == 'J'): ?>
                        <?= __('Pessoa Jurídica') ?><br><?= __('CNPJ') ?> <?= h($usuario->cnpj) ?>
                    <?php else: ?>
                        <?= __('Pessoa Física') ?><br><?= __('CPF') ?> <?= h($usuario->cpf) ?><br>
                        <?= __('RG') ?> <?= h($usuario->rg) ?> <?= h($usuario->orgao_expedidor) ?>/<?= h($usuario->estado_expedidor) ?>
                    <?php endif; ?>
                </div>
                <div class="col-xs-12 col-sm-6 form-group">
                    <h5><strong><?= __('Contato') ?></strong></h5>
                    <i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i> <?= h($usuario->email) ?><br>
                    <i class="fa fa-phone fa-fw" aria-hidden="true"></i> <?= h($usuario->telefone) ?>
                </div>
                <div class="col-xs-12 col-sm-6 form-group">
                    <h5><strong><?= __('Endereço') ?></strong></h5>
                    <?= h($usuario->endereco) ?>, <?= h($usuario->numero) ?> <?= h($usuario->complemento) ?><br>
                    <?= h($usuario->bairro) ?> - <?= h($usuario->cidade) ?>/<?= h($usuario->estado) ?><br>
                    <?= __('CEP') ?> <?= h($usuario->cep) ?>
                </div>
                <div class="col-xs-12 col-sm-6 form-group">
                    <h5><strong><?= __('Rede') ?></strong></h5>
                    <?= __('Patrocinador:') ?> <?= $usuario->Patrocinador ? h($usuario->Patrocinador->nome) : '-' ?><br>
                    <?= __('Região:') ?> <?= $usuario->regiao ? h($usuario->regiao->title) : '-' ?><br>
                    <?= __('Indicados diretos:') ?> <?= $indicados ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-4">
            <div class="box bg-primary padding-15 bottom-10">
                <h5><strong><?= __('Status') ?></strong></h5>
                <?= $this->Usuarios->status($usuario->status) ?>
            </div>
            <?php if (in_array($usuario->planos_id, [3, 4, 5])): ?>
                <div class="box bg-info padding-15 bottom-10">
                    <h5><strong><?= __('Saldos') ?></strong></h5>
                    <?= __('Disponível:') ?> <?= $this->Number->currency($saldos['disponivel'], 'BRL') ?><br>
                    <?= __('Bloqueado:') ?> <?= $this->Number->currency($saldos['bloqueado'], 'BRL') ?>
                </div>
            <?php endif; ?>
            <div class="box bg-warning padding-15">
                <h5><strong><?= __('Cadastro') ?></strong></h5>
                <?= __('Desde') ?> <?= $this->MyHtml->date($usuario->created) ?><br>
                <small><?= __('Último acesso:') ?> <?= $this->MyHtml->time($usuario->last_login) ?></small>
            </div>
        </div>
    </div>
</div>
