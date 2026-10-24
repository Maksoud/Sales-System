<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Element/navbar-side-faturas.ctp */

/**
 * Filtro por tipo de fatura no Extrato geral (Invoices/index).
 * Cada link mantém os demais filtros da busca e troca só o tipo.
 */

//tipo => [ícone, rótulo]
$itens = [
    ''  => ['fa-list',         __('Todas')],
    'S' => ['fa-money',        __('Saques')],
    'T' => ['fa-ticket',       __('Taxas de inscrição')],
    'P' => ['fa-shopping-cart', __('Pedidos')],
    'C' => ['fa-handshake-o',  __('Comissões')],
];
$query = $this->request->getQueryParams();
$atual = isset($query['tipo']) ? (string)$query['tipo'] : '';
unset($query['tipo'], $query['iniciar_busca']);
$query = array_filter($query, 'strlen');
?>

<nav class="ss-subnav" aria-label="<?= __('Filtrar faturas por tipo') ?>">
    <p class="ss-subnav-title"><?= __('Tipo') ?></p>
    <ul class="ss-subnav-list">
        <?php foreach ($itens as $tipo => $item): ?>
            <?php
            $filtros = $tipo === '' ? $query : $query + ['tipo' => $tipo];
            if ($filtros) $filtros['iniciar_busca'] = 'true';
            $ativo = $atual === (string)$tipo;
            ?>
            <li><?= $this->Html->link('<i class="fa ' . $item[0] . '" aria-hidden="true"></i> ' . $item[1],
                    ['controller' => 'Invoices', 'action' => 'index', '?' => $filtros],
                    ['class' => $ativo ? 'is-active' : '', 'escape' => false] + ($ativo ? ['aria-current' => 'page'] : [])) ?></li>
        <?php endforeach; ?>
    </ul>
</nav>
