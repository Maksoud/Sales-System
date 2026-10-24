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

    /** Status com selo colorido */
    public function statusLabel($status)
    {
        $classes = ['P' => 'warning', 'F' => 'success', 'C' => 'danger'];
        $classe  = isset($classes[$status]) ? $classes[$status] : 'default';
        return '<span class="label label-' . $classe . '">' . $this->status($status) . '</span>';
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
