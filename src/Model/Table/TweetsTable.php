<?php

namespace App\Model\Table;

use App\Model\Entity\Tweet;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * Tweets Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Searches
 */
class TweetsTable extends Table
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

      $this->table('tweets');
      $this->displayField('id');
      $this->primaryKey('id');

      $this->addBehavior('Timestamp');

      $this->belongsTo('Searches', [
          'foreignKey' => 'search_id',
          'joinType' => 'INNER'
      ]);
  }

  /**
 * Returns a rules checker object that will be used for validating
 * application integrity.
 *
 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
 * @return \Cake\ORM\RulesChecker
 */
 public function buildRules(RulesChecker $rules)
 {
    //$rules->add($rules->isUnique(['tweet_text']));
    $rules->add($rules->existsIn(['search_id'], 'Searches'));
    return $rules;
  }

}
