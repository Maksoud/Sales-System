<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/View/Helper/UsuariosHelper.php */

namespace App\View\Helper;

use Cake\View\Helper;

class UsuariosHelper extends Helper
{
    public function statusLista()
    {
        return ['A' => 'Ativo', 'P' => 'Pendente', 'I' => 'Inativo', 'C' => 'Cancelado'];
    }

    public function status($status)
    {
        $lista = $this->statusLista();
        return isset($lista[$status]) ? $lista[$status] : '';
    }

    /** Status como badge (mapa em .claude/skills/sales-system-ui/references/status.md) */
    public function statusLabel($status)
    {
        $classes = ['A' => 'success', 'P' => 'warning', 'I' => 'default', 'C' => 'default'];
        $classe  = isset($classes[$status]) ? $classes[$status] : 'default';
        return '<span class="label label-' . $classe . '">' . h($this->status($status)) . '</span>';
    }

    public function tipo_de_pessoa($tipo_de_pessoa)
    {
        return $tipo_de_pessoa == 'J' ? 'Jurídica' : 'Física';
    }

    public function tipo_conta($tipo_conta)
    {
        return $tipo_conta == 'P' ? 'Poupança' : 'Corrente';
    }

    public function estadoCivilLista()
    {
        return ['S' => 'Solteiro(a)', 'C' => 'Casado(a)', 'U' => 'União Estável', 'D' => 'Divorciado(a)', 'V' => 'Viúvo(a)'];
    }

    public function estado_civil($estado_civil)
    {
        $lista = $this->estadoCivilLista();
        return isset($lista[$estado_civil]) ? $lista[$estado_civil] : '';
    }

    public function estadosLista()
    {
        $ufs = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA',
                'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
        return array_combine($ufs, $ufs);
    }

    /** Selo do plano (ss-plan--1..6, mesma cor do cabeçalho) */
    public function plano($usuario)
    {
        if (!$usuario || !$usuario->plano) {
            return '-';
        }
        return '<span class="ss-plan ss-plan--' . (int)$usuario->planos_id . '">' . h($usuario->plano->title) . '</span>';
    }
}
