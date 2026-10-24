<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Pages/login.ctp */

$this->layout = 'layout-clean';

//Em manutenção, o formulário só aparece com ?admin na URL
$liberado_temporariamente = true;
$liberado = $this->request->getQuery('admin') !== null || $liberado_temporariamente;
?>

<main class="ss-auth">
    <div class="ss-auth-card">
        <?= $this->Html->image('Reiniciando.png', ['alt' => 'Reiniciando', 'class' => 'ss-auth-logo']) ?>

        <?php if ($liberado): ?>
            <h1 class="ss-auth-title"><?= __('Acesse o painel') ?></h1>
            <p class="ss-auth-subtitle"><?= __('Entre com seu login e senha.') ?></p>

            <?= $this->Flash->render() ?>

            <?= $this->Form->create('Usuario', ['id' => 'form_entrar']) ?>
                <div class="form-group">
                    <label for="login"><?= __('Login') ?></label>
                    <input type="text" name="login" id="login" class="form-control focus"
                           autocomplete="username" autocapitalize="none" spellcheck="false" required>
                </div>
                <div class="form-group">
                    <label for="senha"><?= __('Senha') ?></label>
                    <input type="password" name="senha" id="senha" class="form-control"
                           autocomplete="current-password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-lg" data-loading-text="<?= __('Entrando...') ?>">
                    <?= __('Entrar') ?>
                </button>
            <?= $this->Form->end() ?>
        <?php else: ?>
            <h1 class="ss-auth-title"><?= __('Sistema em manutenção') ?></h1>
            <p class="ss-auth-subtitle"><?= __('Voltamos em breve.') ?></p>

            <div class="ss-alert ss-alert--warning" role="status">
                <i class="fa fa-exclamation-triangle ss-alert-icon" aria-hidden="true"></i>
                <div class="ss-alert-body">
                    <p><?= __('O painel está em manutenção. Tente acessar novamente mais tarde.') ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>
