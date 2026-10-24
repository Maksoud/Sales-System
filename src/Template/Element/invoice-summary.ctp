<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/invoice-summary.ctp */

/**
 * Totais das faturas listadas, por status (ss-grid-stats).
 * Cada métrica é um link para a mesma lista filtrada pelo status, mantendo os demais filtros.
 * Variáveis: $resumo ['quantidade', 'P', 'F', 'C']
 */
$query = $this->request->getQueryParams();
unset($query['status'], $query['iniciar_busca']);
$query = array_filter($query, 'strlen');
$acao  = $this->request->getParam('action');

$link = function ($status) use ($query, $acao) {
    $filtros = $status === '' ? $query : $query + ['status' => $status];
    if ($filtros) $filtros['iniciar_busca'] = 'true';
    return $this->Url->build(['action' => $acao, '?' => $filtros]);
};

//status => [rótulo, ícone, tom]
$metricas = [
    'P' => [__('Pendentes'),   'fa-clock-o',      'ss-tone-warning'],
    'F' => [__('Finalizadas'), 'fa-check-circle', 'ss-tone-success'],
    'C' => [__('Canceladas'),  'fa-ban',          'ss-tone-neutral'],
];
?>

<div class="ss-grid-stats">
    <a class="ss-stat" href="<?= $link('') ?>">
        <span class="ss-stat-icon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
        <span class="ss-stat-label"><?= __('Faturas listadas') ?></span>
        <span class="ss-stat-value"><?= $this->Number->format($resumo['quantidade']) ?></span>
    </a>
    <?php foreach ($metricas as $status => $metrica): ?>
        <a class="ss-stat <?= $metrica[2] ?>" href="<?= $link($status) ?>">
            <span class="ss-stat-icon"><i class="fa <?= $metrica[1] ?>" aria-hidden="true"></i></span>
            <span class="ss-stat-label"><?= $metrica[0] ?></span>
            <span class="ss-stat-value"><?= $this->Number->currency($resumo[$status], 'BRL') ?></span>
        </a>
    <?php endforeach; ?>
</div>
