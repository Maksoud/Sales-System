<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Orders/report.ctp */

$this->layout = 'ajax';

echo $this->element('report-form', [
    'url'     => ['controller' => 'Reports', 'action' => 'orders'],
    'selects' => [
        'usuarios_id' => [__('Associado'), $associados],
        'status'      => [__('Status'), $this->Pedidos->statusLista()],
        'tipo'        => [__('Tipo'), ['N' => __('Normal'), 'E' => __('Bonificação de Inscrição'), 'B' => __('Bonificação por Meta')]],
    ],
]);
