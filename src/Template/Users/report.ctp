<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/Template/Users/report.ctp */

$this->layout = 'ajax';

echo $this->element('report-form', [
    'url'     => ['controller' => 'Reports', 'action' => 'associates'],
    'selects' => [
        'patrocinador_id' => [__('Patrocinador'), $patrocinadores, __('Todos os patrocinadores')],
        'planos_id'       => [__('Plano'), $planos, __('Todos os planos')],
        'status'          => [__('Status'), $this->Usuarios->statusLista(), __('Todos os status')],
    ],
]);
