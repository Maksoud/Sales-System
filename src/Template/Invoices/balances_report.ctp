<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Invoices/balances_report.ctp */

$this->layout = 'ajax';

echo $this->element('report-form', [
    'url'     => ['controller' => 'Reports', 'action' => 'balances'],
    'periodo' => false,
    'selects' => [
        'planos_id' => [__('Plano'), $planos],
        'saldo'     => [__('Saldo'), ['disponivel' => __('Somente com saldo disponível'), 'bloqueado' => __('Somente com saldo bloqueado')]],
    ],
]);
