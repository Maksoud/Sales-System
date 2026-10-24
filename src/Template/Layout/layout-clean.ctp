<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Layout/layout-clean.ctp */

//Layout sem cabeçalho nem menu (login). A tela define a própria largura (ss-auth).
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?= $this->element('head') ?>
    </head>
    <body>
        <main id="conteudo">
            <?= $this->fetch('content') ?>
        </main>
        <?= $this->elementExists('chat') ? $this->element('chat') : '' ?>
        <footer class="ss-footer">
            <?= $this->element('footer') ?>
        </footer>
    </body>
</html>
