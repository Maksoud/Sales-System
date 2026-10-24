<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/report-header.ctp */

/**
 * Cabeçalho dos relatórios (layout "relatorio").
 * Variáveis: $titulo, $periodo [inicio, fim] (opcional).
 *
 * A barra de quem gerou + "Imprimir" vai para o bloco "report-toolbar", que o layout mostra
 * acima da folha e não sai na impressão. O cabeçalho com logo, título e período abre a folha.
 */
$periodo = isset($periodo) ? $periodo : [null, null];
$gerado  = date('d/m/Y H:i');
?>

<?php $this->start('report-toolbar') ?>
<div class="ss-report-toolbar hidden-print">
    <p class="ss-report-toolbar-info ss-muted ss-text-xs">
        <?= __('Gerado por {0} ({1})', h($username), h($login)) ?> &middot; <?= h($planos_usuario) ?> &middot; <?= __('em {0}', $gerado) ?>
    </p>
    <button type="button" class="btn btn-primary" onclick="window.print();">
        <i class="fa fa-print" aria-hidden="true"></i> <?= __('Imprimir') ?>
    </button>
</div>
<?php $this->end() ?>

<header class="ss-report-header">
    <?= $this->Html->image('Reiniciando.png', ['class' => 'ss-report-logo', 'alt' => 'Reiniciando']) ?>
    <div class="ss-report-heading">
        <h1 class="ss-report-title"><?= h($titulo) ?></h1>
        <?php if ($periodo[0] || $periodo[1]): ?>
            <p class="ss-report-period"><?= __('Período: {0} a {1}', $periodo[0] ?: __('início'), $periodo[1] ?: __('hoje')) ?></p>
        <?php endif; ?>
    </div>
    <p class="ss-report-issued"><?= __('Emitido em {0}', $gerado) ?></p>
</header>
