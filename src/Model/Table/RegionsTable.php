<?php
/**
 * Developed by:
 *     Renée Maksoud
 * 
 * All rights reserved - 2018-2019
 */

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class RegionsTable extends Table 
{
    public function initialize(array $config) 
    {
        parent::initialize($config);

        $this->entityClass('App\Model\Entity\Region');
        $this->setTable('regions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator) 
    {
        $validator
            ->decimal('valor')
            ->requirePresence('valor', 'create', __('Precisa informar o valor da comissão'))
            ->notEmpty('valor', __('Precisa informar o valor da comissão'));
        $validator
            ->requirePresence('tipo', 'create', __('Precisa informar qual tipo da comissão'))
            ->notEmpty('tipo', __('Precisa informar qual tipo da comissão'));
        return $validator;
    }

    public function buildRules(RulesChecker $rules) 
    {
        return $rules;
    }
}
        