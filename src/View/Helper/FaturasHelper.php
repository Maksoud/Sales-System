<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/View/Helper/FaturasHelper.php */

namespace App\View\Helper;

use Cake\View\Helper;

class FaturasHelper extends Helper
{
    public function formaPagamentoLista()
    {
        return ['C' => 'Cartão de crédito', 'D' => 'Transferência ou Depósito', 'B' => 'Boleto bancário'];
    }

    public function forma_pagamento($forma_pagamento)
    {
        $lista = $this->formaPagamentoLista();
        return isset($lista[$forma_pagamento]) ? $lista[$forma_pagamento] : '';
    }

    public function statusLista()
    {
        return ['P' => 'Pendente', 'F' => 'Finalizado', 'C' => 'Cancelado'];
    }

    public function status($status)
    {
        $lista = $this->statusLista();
        return isset($lista[$status]) ? $lista[$status] : '';
    }

    /**
     * Status como badge (mapa em .claude/skills/sales-system-ui/references/status.md).
     * Pendente com vencimento no passado aparece como "Vencida".
     */
    public function statusLabel($status, $vencimento = null)
    {
        if ($status == 'P' && $vencimento && $vencimento->format('Y-m-d') < date('Y-m-d')) {
            return '<span class="label label-danger">' . __('Vencida') . '</span>';
        }
        $classes = ['P' => 'warning', 'F' => 'success', 'C' => 'default'];
        $classe  = isset($classes[$status]) ? $classes[$status] : 'default';
        return '<span class="label label-' . $classe . '">' . h($this->status($status)) . '</span>';
    }

    /**
     * Situação da fatura como badge, considerando o tipo e o pedido de origem:
     * pedido ainda em cálculo = "Em cálculo"; comissão pendente = "Bloqueada" (até a liberação);
     * demais casos = statusLabel() com o vencimento.
     */
    public function situacao($fatura)
    {
        if ($fatura->status == 'P' && $fatura->pedido && $fatura->pedido->status == 'V') {
            return '<span class="label label-info">' . __('Em cálculo') . '</span>';
        }
        if ($fatura->tipo == 'C' && $fatura->status == 'P') {
            return '<span class="label label-primary" title="' . __('Liberada em {0}', $fatura->vencimento->format('d/m/Y')) . '">'
                . __('Bloqueada') . '</span>';
        }
        return $this->statusLabel($fatura->status, $fatura->vencimento);
    }

    /** Status do saque como badge, com os textos do pagamento ao associado */
    public function saqueLabel($status)
    {
        $lista = ['P' => ['warning', __('Aguardando pagamento')], 'F' => ['success', __('Pago')], 'C' => ['default', __('Cancelado')]];
        $item  = isset($lista[$status]) ? $lista[$status] : ['default', $this->status($status)];
        return '<span class="label label-' . $item[0] . '">' . h($item[1]) . '</span>';
    }

    public function tipoLista()
    {
        return ['C' => 'Comissão', 'S' => 'Saque', 'P' => 'Pedido', 'T' => 'Taxa de Inscrição'];
    }

    public function tipo($tipo)
    {
        $lista = $this->tipoLista();
        return isset($lista[$tipo]) ? $lista[$tipo] : '';
    }

    public function parcelas($parcela_atual, $qt_parcelas)
    {
        if ($qt_parcelas > 1) {
            return $parcela_atual . 'ª parcela de ' . $qt_parcelas;
        }
        return false;
    }

    /** Fatura pendente e vencida? */
    public function vencida($fatura)
    {
        return $fatura->status == 'P' && $fatura->vencimento->format('Y-m-d') < date('Y-m-d');
    }
}
