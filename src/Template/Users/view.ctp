<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/view.ctp */

$this->layout = 'ajax';
$vazio = '<span class="ss-muted">—</span>';
$juridica = $usuario->tipo_de_pessoa == 'J';
?>

<div class="ss-record-header">
    <div class="ss-cell-media">
        <?= $this->Html->image('usuarios/' . $usuario->foto, ['class' => 'ss-avatar ss-avatar--lg', 'alt' => '']) ?>
        <div>
            <h3 class="ss-record-title">
                <?= h($usuario->nome) ?>
                <?= $this->Usuarios->statusLabel($usuario->status) ?>
            </h3>
            <div class="ss-record-meta">
                <span><?= h($usuario->login) ?></span>
                <span><?= $this->Usuarios->plano($usuario) ?></span>
                <span><?= __('Desde {0}', $this->MyHtml->date($usuario->created)) ?></span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-8">

        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Documento') ?></h4>
            <dl class="ss-dl">
                <dt><?= __('Pessoa') ?></dt>
                <dd><?= h($this->Usuarios->tipo_de_pessoa($usuario->tipo_de_pessoa)) ?></dd>
                <?php if ($juridica): ?>
                    <dt><?= __('CNPJ') ?></dt>
                    <dd><span class="ss-mono"><?= h($usuario->cnpj) ?></span></dd>
                <?php else: ?>
                    <dt><?= __('CPF') ?></dt>
                    <dd><span class="ss-mono"><?= h($usuario->cpf) ?></span></dd>
                    <dt><?= __('RG') ?></dt>
                    <dd>
                        <?php if ($usuario->rg): ?>
                            <span class="ss-mono"><?= h($usuario->rg) ?></span>
                            <span class="ss-muted"><?= h($usuario->orgao_expedidor) ?>/<?= h($usuario->estado_expedidor) ?></span>
                        <?php else: ?>
                            <?= $vazio ?>
                        <?php endif; ?>
                    </dd>
                <?php endif; ?>
            </dl>
        </section>

        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Contato') ?></h4>
            <dl class="ss-dl">
                <dt><?= __('E-mail') ?></dt>
                <dd><a href="mailto:<?= h($usuario->email) ?>"><?= h($usuario->email) ?></a></dd>
                <dt><?= __('Celular') ?></dt>
                <dd><?= $usuario->telefone ? h($usuario->telefone) : $vazio ?></dd>
            </dl>
        </section>

        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Endereço') ?></h4>
            <address class="ss-address">
                <?= h($usuario->endereco) ?>, <?= h($usuario->numero) ?> <?= h($usuario->complemento) ?><br>
                <?= h($usuario->bairro) ?> · <?= h($usuario->cidade) ?>/<?= h($usuario->estado) ?> · <?= __('CEP') ?> <?= h($usuario->cep) ?>
            </address>
        </section>
    </div>

    <div class="col-xs-12 col-md-4">

        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Rede') ?></h4>
            <dl class="ss-dl">
                <dt><?= __('Patrocinador') ?></dt>
                <dd><?= $usuario->Patrocinador ? h($usuario->Patrocinador->nome) : $vazio ?></dd>
                <dt><?= __('Região') ?></dt>
                <dd><?= $usuario->regiao ? h($usuario->regiao->title) : $vazio ?></dd>
                <dt><?= __('Indicados') ?></dt>
                <dd><span class="ss-num"><?= $this->Number->format($indicados) ?></span> <span class="ss-muted"><?= __('diretos') ?></span></dd>
            </dl>
        </section>

        <?php if (in_array($usuario->planos_id, [3, 4, 5])): ?>
            <section class="ss-section">
                <h4 class="ss-section-title"><?= __('Saldos') ?></h4>
                <dl class="ss-dl">
                    <dt><?= __('Disponível') ?></dt>
                    <dd><span class="ss-money"><?= $this->Number->currency($saldos['disponivel'], 'BRL') ?></span></dd>
                    <dt><?= __('Bloqueado') ?></dt>
                    <dd><span class="ss-money"><?= $this->Number->currency($saldos['bloqueado'], 'BRL') ?></span></dd>
                </dl>
            </section>
        <?php endif; ?>

        <section class="ss-section">
            <h4 class="ss-section-title"><?= __('Acesso') ?></h4>
            <dl class="ss-dl">
                <dt><?= __('Cadastro') ?></dt>
                <dd><?= $this->MyHtml->date($usuario->created) ?></dd>
                <dt><?= __('Último acesso') ?></dt>
                <dd><?= $usuario->last_login ? $this->MyHtml->time($usuario->last_login) : $vazio ?></dd>
            </dl>
        </section>
    </div>
</div>
