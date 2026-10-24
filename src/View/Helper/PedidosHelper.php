<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/View/Helper/PedidosHelper.php */

namespace App\View\Helper;

use Cake\View\Helper;

class PedidosHelper extends Helper
{
    public $helpers = ['Number'];

    //Etapas do pedido, na ordem: status => [ícone, descrição]
    protected $etapas = [
        'V' => ['fa-calculator',     'Calculando frete e impostos'],
        'P' => ['fa-hourglass-half', 'Aguardando pagamento'],
        'S' => ['fa-dropbox',        'Em preparação para envio'],
        'T' => ['fa-truck',          'Aguardando entrega'],
    ];

    public function status($status)
    {
        $lista = [
            'V' => 'Esperando frete e impostos',
            'P' => 'Aguardando pagamento',
            'S' => 'Em preparação para envio',
            'T' => 'Aguardando entrega',
            'F' => 'Concluído',
            'C' => 'Cancelado',
        ];
        return isset($lista[$status]) ? $lista[$status] : '';
    }

    public function statusLista()
    {
        return ['V' => 'Esperando frete e impostos', 'P' => 'Aguardando pagamento', 'S' => 'Em preparação para envio',
                'T' => 'Aguardando entrega', 'F' => 'Concluído', 'C' => 'Cancelado'];
    }

    public function tipo($tipo)
    {
        $lista = ['E' => 'Bonificação de Inscrição', 'B' => 'Bonificação por Meta', 'N' => 'Normal'];
        return isset($lista[$tipo]) ? $lista[$tipo] : '';
    }

    /**
     * Linha do tempo do pedido: etapas concluídas com check verde,
     * a etapa atual em azul e as próximas em cinza.
     */
    public function etapas($status)
    {
        if ($status == 'F') {
            return '<span class="text-azul"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Concluído</span>';
        }
        if ($status == 'C') {
            return '<span class="text-cinza"><i class="fa fa-ban" aria-hidden="true"></i> Cancelado</span>';
        }

        $ordem = array_keys($this->etapas);
        $atual = array_search($status, $ordem);
        $html  = '';

        foreach ($ordem as $i => $etapa) {
            list($icone, $texto) = $this->etapas[$etapa];
            $classe = $i <= $atual ? 'text-azul' : 'text-cinza';
            $check  = $i < $atual ? 'fa-check-square-o text-verde' : 'fa-square-o';
            $html  .= '<span class="' . $classe . ' text-nowrap"><i class="fa ' . $icone . ' fa-fw" aria-hidden="true"></i> ' . $texto
                    . ' <i class="fa ' . $check . '" aria-hidden="true"></i></span><br>';
        }

        return $html;
    }

    /** Valor do pedido ou o aviso de que frete e impostos ainda estão em cálculo */
    public function total($pedido)
    {
        if ($pedido->status == 'V') {
            return '<small>Aguardando</small><br><small class="label label-default">Frete+Impostos</small>';
        }
        return $this->Number->currency($pedido->total, 'BRL');
    }
}
