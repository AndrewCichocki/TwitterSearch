<?php

namespace App\Model\Table;

use App\Model\Entity\Search;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Searches Model
 *
 * @property \Cake\ORM\Association\HasMany $Tweets
 */
class SearchesTable extends Table
{

  /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('searches');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('Tweets', [
            'foreignKey' => 'search_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('term', 'create')
            ->notEmpty('term');

        $validator
            ->dateTime('executed')
            ->allowEmpty('executed');

        return $validator;
    }

}
