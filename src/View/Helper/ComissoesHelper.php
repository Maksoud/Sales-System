<?php
/**
 * Developed by:
 *     Renée Maksoud
 *
 * All rights reserved - 2018-2019
 */

/* File: src/View/Helper/ComissoesHelper.php */

namespace App\View\Helper;

use Cake\View\Helper;

class ComissoesHelper extends Helper
{
    public $tipos = [
        'ID' => 'Indicação Direta',
        'II' => 'Indicação Indireta',
        'IM' => 'Indicação Multinível',
        'VD' => 'Venda Direta',
        'VI' => 'Venda Indireta',
        'VM' => 'Venda Multinível',
    ];

    public function tipo($tipo)
    {
        return isset($this->tipos[$tipo]) ? $this->tipos[$tipo] : 'Comissão Especial';
    }
}
