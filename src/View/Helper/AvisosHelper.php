<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/View/Helper/AvisosHelper.php */

namespace App\View\Helper;

use Cake\View\Helper;

class AvisosHelper extends Helper
{
    /**
     * Situação do aviso pela validade: A (ativo) ou E (encerrado).
     * "Agendado" (G) só aparece se o aviso tiver data de início (campo `inicio`) no futuro.
     */
    public function situacao($aviso)
    {
        if ($aviso->get('inicio') && $aviso->get('inicio')->isFuture()) {
            return 'G';
        }
        return $aviso->ativo ? 'A' : 'E';
    }

    public function status($aviso)
    {
        $textos = ['A' => __('Ativo'), 'E' => __('Encerrado'), 'G' => __('Agendado')];
        return $textos[$this->situacao($aviso)];
    }

    /** Status como badge (mapa em .claude/skills/sales-system-ui/references/status.md) */
    public function statusLabel($aviso)
    {
        $classes = ['A' => 'success', 'E' => 'default', 'G' => 'info'];
        return '<span class="label label-' . $classes[$this->situacao($aviso)] . '">' . h($this->status($aviso)) . '</span>';
    }

    /** Destino: selo do plano ou "Todos" */
    public function destino($aviso)
    {
        if (!$aviso->plano) {
            return '<span class="ss-text-sm">' . __('Todos') . '</span>';
        }
        return '<span class="ss-plan ss-plan--' . (int)$aviso->planos_id . '">' . h($aviso->plano->title) . '</span>';
    }

    /** Trecho da mensagem em texto puro, para a linha de apoio da lista */
    public function resumo($aviso, $limite = 90)
    {
        $texto = trim(preg_replace('/\s+/u', ' ', strip_tags(str_replace('</p>', '</p> ', $aviso->aviso))));
        return mb_strlen($texto) > $limite ? rtrim(mb_substr($texto, 0, $limite)) . '…' : $texto;
    }
}
