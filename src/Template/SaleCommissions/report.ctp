<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/SaleCommissions/report.ctp */

$this->layout = 'ajax';

echo $this->element('report-form', [
    'url'     => ['controller' => 'Reports', 'action' => 'commissions'],
    'selects' => [
        'usuarios_id' => [__('Beneficiário'), $associados, __('Todos os beneficiários')],
        'tipo'        => [__('Tipo'), $this->Comissoes->tipos, __('Todos os tipos')],
        'status'      => [__('Situação'), ['F' => __('Liberadas'), 'P' => __('Bloqueadas')], __('Todas as situações')],
    ],
]);
