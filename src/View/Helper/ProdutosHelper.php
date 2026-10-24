<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/View/Helper/ProdutosHelper.php */

namespace App\View\Helper;

use Cake\View\Helper;

class ProdutosHelper extends Helper
{
    /** Status na gestão (cadastro de produtos) */
    public function statusLista()
    {
        return ['A' => __('Ativo'), 'I' => __('Inativo')];
    }

    /** Status como aparece para quem compra */
    public function statusLojaLista()
    {
        return ['A' => __('Disponível'), 'I' => __('Fora de linha')];
    }

    public function status($status, $loja = false)
    {
        $lista = $loja ? $this->statusLojaLista() : $this->statusLista();
        return isset($lista[$status]) ? $lista[$status] : '';
    }

    /** Status como badge (mapa em .claude/skills/sales-system-ui/references/status.md) */
    public function statusLabel($status, $loja = false)
    {
        $classe = $status == 'A' ? 'success' : 'default';
        return '<span class="label label-' . $classe . '">' . h($this->status($status, $loja)) . '</span>';
    }
}
