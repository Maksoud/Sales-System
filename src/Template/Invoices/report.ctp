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
        'usuarios_id'     => [__('Associado'), $associados, __('Todos os associados')],
        'tipo'            => [__('Tipo'), $this->Faturas->tipoLista(), __('Todos os tipos')],
        'status'          => [__('Status'), $this->Faturas->statusLista(), __('Todos os status')],
        'forma_pagamento' => [__('Forma de pagamento'), $this->Faturas->formaPagamentoLista(), __('Todas as formas')],
    ],
]);
