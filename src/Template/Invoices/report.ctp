<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Invoices/report.ctp */

$this->layout = 'ajax';

echo $this->element('report-form', [
    'url'     => ['controller' => 'Reports', 'action' => 'invoices'],
    'selects' => [
        'usuarios_id'     => [__('Associado'), $associados],
        'tipo'            => [__('Tipo'), $this->Faturas->tipoLista()],
        'status'          => [__('Status'), $this->Faturas->statusLista()],
        'forma_pagamento' => [__('Forma de pagamento'), $this->Faturas->formaPagamentoLista()],
    ],
]);
