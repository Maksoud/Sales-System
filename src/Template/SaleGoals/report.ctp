<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/SaleGoals/report.ctp */

$this->layout = 'ajax';

echo $this->element('report-form', [
    'url'     => ['controller' => 'Reports', 'action' => 'goals'],
    'periodo' => false,
    'selects' => [
        'planos_id' => [__('Plano'), $planos, __('Todos os planos')],
    ],
]);
