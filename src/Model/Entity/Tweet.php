<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tweet Entity.
 *
 * @property int $id
 * @property int $search_id
 * @property \App\Model\Entity\Search $search
 * @property string $tweet_text
 * @property string $tweet_url
 * @property string $profile_name
 * @property string $profile_url
 * @property int $retweet_count
 * @property int $favorite_count
 * @property int $popularity
 * @property \Cake\I18n\Time $created_at
 */
class Tweet extends Entity
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
        'id' => false,
    ];
}
