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

    /** Status como badge (mapa em .claude/skills/sales-system-ui/references/status.md) */
    public function statusLabel($status)
    {
        $classes = ['V' => 'info', 'P' => 'warning', 'S' => 'primary', 'T' => 'primary', 'F' => 'success', 'C' => 'default'];
        $classe  = isset($classes[$status]) ? $classes[$status] : 'default';
        return '<span class="label label-' . $classe . '">' . h($this->status($status)) . '</span>';
    }

    public function tipo($tipo)
    {
        $lista = ['E' => 'Bonificação de Inscrição', 'B' => 'Bonificação por Meta', 'N' => 'Normal'];
        return isset($lista[$tipo]) ? $lista[$tipo] : '';
    }

    /**
     * Linha do tempo do pedido (ss-steps): etapas concluídas como is-done,
     * a etapa atual como is-current e as próximas sem destaque.
     * Concluído: todas is-done. Cancelado: só o item is-canceled
     * (o status não guarda até onde o pedido chegou).
     */
    public function etapas($status)
    {
        $item = function ($classe, $texto) {
            return '<li' . ($classe ? ' class="' . $classe . '"' : '') . '><span class="ss-steps-title">' . h($texto) . '</span></li>';
        };

        if ($status == 'C') {
            return '<ol class="ss-steps">' . $item('is-canceled', __('Cancelado')) . '</ol>';
        }

        $ordem = array_keys($this->etapas);
        $atual = $status == 'F' ? count($ordem) : array_search($status, $ordem);
        $html  = '';

        foreach ($ordem as $i => $etapa) {
            $classe = $i < $atual ? 'is-done' : ($i === $atual ? 'is-current' : '');
            $html  .= $item($classe, $this->etapas[$etapa][1]);
        }
        $html .= $item($status == 'F' ? 'is-done' : '', __('Concluído'));

        return '<ol class="ss-steps">' . $html . '</ol>';
    }

    /** Valor do pedido ou o aviso de que frete e impostos ainda estão em cálculo */
    public function total($pedido)
    {
        if ($pedido->status == 'V') {
            return '<span class="ss-muted" title="' . __('Aguardando o cálculo do frete e dos impostos') . '">' . __('Em cálculo') . '</span>';
        }
        return $this->Number->currency($pedido->total, 'BRL');
    }
}
