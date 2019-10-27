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

class GoalPlansTable extends Table 
{
    public function initialize(array $config) 
    {
        parent::initialize($config);

        $this->entityClass('App\Model\Entity\GoalPlan');
        $this->setTable('goal_plans');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
        
        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'propertyName' => 'product'
        ]);
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
        