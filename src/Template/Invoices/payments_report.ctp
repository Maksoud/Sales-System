<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Invoices/payments_report.ctp */

$this->layout = 'ajax';

echo $this->element('report-form', [
    'url'     => ['controller' => 'Reports', 'action' => 'payments'],
    'selects' => [
        'usuarios_id' => [__('Associado'), $associados, __('Todos os associados')],
        'status'      => [__('Situação do saque'), ['F' => __('Pagos'), 'P' => __('Aguardando pagamento'), 'C' => __('Cancelados')], __('Todas as situações')],
    ],
]);
