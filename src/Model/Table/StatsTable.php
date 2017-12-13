<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class StatsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('stats');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('user_id', 'create')
            ->notEmpty('user_id');
        $validator
            ->requirePresence('item_id', 'create')
            ->notEmpty('item_id');

        return $validator;
    }
}
