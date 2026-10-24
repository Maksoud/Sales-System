<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/navbar-side-avisos.ctp */

/**
 * Filtro por destino na lista de avisos (Notices/index).
 * Cada link mantém os demais filtros da busca e troca só o destino (planos_id).
 * Variável: $planos (id => nome dos planos que recebem avisos)
 */

//planos_id => [ícone, rótulo]
$itens = [
    ''      => ['fa-list',  __('Todos os avisos')],
    'todos' => ['fa-users', __('Para todos')],
];
foreach ($planos as $id => $nome) {
    $itens[$id] = ['fa-certificate', h($nome)];
}

$query = $this->request->getQueryParams();
$atual = isset($query['planos_id']) ? (string)$query['planos_id'] : '';
unset($query['planos_id'], $query['iniciar_busca']);
$query = array_filter($query, 'strlen');
?>

<nav class="ss-subnav" aria-label="<?= __('Filtrar avisos por destino') ?>">
    <p class="ss-subnav-title"><?= __('Destino') ?></p>
    <ul class="ss-subnav-list">
        <?php foreach ($itens as $destino => $item): ?>
            <?php
            $filtros = $destino === '' ? $query : $query + ['planos_id' => $destino];
            if ($filtros) $filtros['iniciar_busca'] = 'true';
            $ativo = $atual === (string)$destino;
            ?>
            <li><?= $this->Html->link('<i class="fa ' . $item[0] . '" aria-hidden="true"></i> ' . $item[1],
                    ['controller' => 'Notices', 'action' => 'index', '?' => $filtros],
                    ['class' => $ativo ? 'is-active' : '', 'escape' => false] + ($ativo ? ['aria-current' => 'page'] : [])) ?></li>
        <?php endforeach; ?>
    </ul>
</nav>
