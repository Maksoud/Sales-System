<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/clients_report.ctp */

$this->layout = 'ajax';

echo $this->element('report-form', [
    'url'     => ['controller' => 'Reports', 'action' => 'clients'],
    'selects' => [
        'patrocinador_id' => [__('Associado responsável'), $patrocinadores],
    ],
]);
