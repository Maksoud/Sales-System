<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Layout/error.ctp */

//Páginas de erro fora do modo debug (no debug o Cake usa o layout dev_error).
//O ErrorController padrão não passa pelo AppController: não há $title, helpers
//do projeto nem sessão. Por isso o <head> fica aqui, sem o element('head').
$titulo = $this->fetch('title') ?: __('Erro');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="robots" content="noindex">
    <?= $this->Html->meta('favicon.ico', 'img/favicon.png', ['type' => 'icon']) ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">

    <?= $this->Html->css([
            'bootstrap.min',
            'font-awesome.min',
            //Tema: SEMPRE por último (mesma versão de Element/head.ctp)
            'ss-theme.css?v=10',
        ])
    ?>

    <title><?= h($titulo) ?> · Sales-System</title>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <header class="ss-topbar">
        <div class="ss-container ss-topbar-inner">
            <?= $this->Html->link($this->Html->image('logomarca.png', ['alt' => 'Sales-System']),
                    '/', ['class' => 'ss-logo', 'escape' => false]) ?>
        </div>
    </header>

    <main id="conteudo">
        <div class="ss-container ss-container--narrow ss-page">
            <?= $this->Flash->render() ?>
            <section class="ss-card">
                <?= $this->fetch('content') ?>
            </section>
        </div>
    </main>

    <footer class="ss-footer">
        <div class="ss-container ss-spread">
            <span>&copy; <?= date('Y') ?> Sales-System</span>
        </div>
    </footer>
</body>
</html>
