<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Comisso Entity
 *
 * @property int $id
 * @property string $title
 * @property float $valor
 * @property string $tipo
 *
 */class SaleGoal extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}