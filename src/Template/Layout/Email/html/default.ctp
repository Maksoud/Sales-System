<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Layout/Email/html/default.ctp */

//E-mail em HTML. Exceção à regra do tema: clientes de e-mail ignoram <link> e variáveis CSS,
//então o estilo vai inline com os valores dos tokens do ss-theme.css:
//  fundo --ss-bg #f2f5f4 · card --ss-surface #ffffff · borda --ss-border #e6ebea
//  texto --ss-text #17201d · secundário --ss-text-muted #66756f · primária --ss-primary-600 #0f7f6a
$logo = $this->Url->build('/img/logomarca.png', true);
$painel = $this->Url->build('/', true);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?></title>
</head>
<body style="margin:0; padding:0; background-color:#f2f5f4;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f2f5f4;">
        <tr>
            <td align="center" style="padding:24px 16px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;">
                    <tr>
                        <td style="padding:0 0 16px;">
                            <a href="<?= $painel ?>" target="_blank" style="text-decoration:none;">
                                <img src="<?= $logo ?>" alt="Sales-System" height="48" style="display:block; height:48px; width:auto; border:0;">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px; background-color:#ffffff; border:1px solid #e6ebea; border-radius:10px; font-family:Inter, 'Segoe UI', Roboto, Arial, sans-serif; font-size:14px; line-height:1.5; color:#17201d;">
                            <?= $this->fetch('content') ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 4px 0; font-family:Inter, 'Segoe UI', Roboto, Arial, sans-serif; font-size:12px; line-height:1.5; color:#66756f;">
                            &copy; <?= date('Y') ?> Sales-System ·
                            <a href="<?= $painel ?>" target="_blank" style="color:#0f7f6a; text-decoration:underline;"><?= __('Acessar o painel') ?></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
