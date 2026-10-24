<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */
?>
<?= $this->Html->charset() ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#ffffff">
<?= $this->Html->meta('favicon.ico', 'img/favicon.png', ['type' => 'icon']) ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">

<?= $this->Html->css([
        //Bootstrap
        'bootstrap.min',
        'bootstrap-datepicker3.min',
        //Legado (o tema sobrepõe)
        'dashboard2.css',
        'reiniciando.css',
        'jquery.dataTables.min',
        'dataTables.bootstrap.min',
        //Ícones
        'font-awesome.min',
        //Tema: SEMPRE por último; suba o ?v= a cada alteração do CSS
        'ss-theme.css?v=10', //Suba também em Layout/error.ctp
    ])
?>

<title><?= h($title) ?></title>
