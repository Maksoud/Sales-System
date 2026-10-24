<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Email/html/default.ctp */

//Uma linha do texto = um parágrafo. O conteúdo é montado pelo código e pode trazer HTML,
//por isso não passa por h() (igual ao template padrão do Cake). Estilo inline: ver o layout.
$content = explode("\n", $content);

foreach ($content as $line):
    echo '<p style="margin:0 0 12px;">' . $line . "</p>\n";
endforeach;
