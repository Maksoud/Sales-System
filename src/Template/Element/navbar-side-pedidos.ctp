<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/navbar-side-pedidos.ctp */

/**
 * Filtros rápidos por status dos pedidos da loja (Orders/index).
 * Cada link mantém os demais filtros da busca e troca só o status.
 */

//status => [ícone, rótulo]. "M" agrupa os pedidos que dependem da empresa (V, S e T)
$itens = [
    ''  => ['fa-list',           __('Todos')],
    'M' => ['fa-dropbox',        __('Aguardando a empresa')],
    'P' => ['fa-hourglass-half', __('Aguardando pagamento')],
    'F' => ['fa-check',          __('Concluídos')],
    'C' => ['fa-ban',            __('Cancelados')],
];
$query = $this->request->getQueryParams();
$atual = isset($query['status']) ? (string)$query['status'] : '';
unset($query['status'], $query['iniciar_busca']);
$query = array_filter($query, 'strlen');
?>

<nav class="ss-subnav" aria-label="<?= __('Filtrar pedidos por status') ?>">
    <p class="ss-subnav-title"><?= __('Status') ?></p>
    <ul class="ss-subnav-list">
        <?php foreach ($itens as $status => $item): ?>
            <?php
            $filtros = $status === '' ? $query : $query + ['status' => $status];
            if ($filtros) $filtros['iniciar_busca'] = 'true';
            $ativo = $atual === (string)$status;
            ?>
            <li><?= $this->Html->link('<i class="fa ' . $item[0] . '" aria-hidden="true"></i> ' . $item[1],
                    ['controller' => 'Orders', 'action' => 'index', '?' => $filtros],
                    ['class' => $ativo ? 'is-active' : '', 'escape' => false] + ($ativo ? ['aria-current' => 'page'] : [])) ?></li>
        <?php endforeach; ?>
    </ul>
</nav>
