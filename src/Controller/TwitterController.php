<?php

namespace App\Controller;

use App\Controller\AppController;
use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\ORM\TableRegistry;

/**
 * Twitter Controller
 *
 */
class TwitterController extends AppController
{
  // Your keys go here
  private $consumerKey = '';
  private $consumerSecret = '';
  private $accessToken = '';
  private $accessTokenSecret = '';
  public $search_id = null;
  public $tweets = array();

  public function initialize()
  {
    parent::initialize();
  }

  // Search for tweets by term
  public function search($term, $id) {

    $this->search_id = $id;

    if (!empty($term)) {
      // Connect to Twitter API
      $connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->accessToken, $this->accessTokenSecret);
      $term = trim($term);
      $term = urlencode($term);
      $tweets = null;
      // Get first 100 results (Twitter's limit)
      $results = $connection->get('search/tweets', [
        'q' => $term,
        'lang' => 'en',
        'count' => 100,
        'result_type' => 'recent',
        'include_entities' => false
      ]);
      $this->saveTweets($results);
      // 100 through 500
      for ($i = 100; $i <= 500; $i += 100) {
        $lastTweet = end($this->tweets);
        $max_id = $lastTweet['tweet_id'];
        $results = $connection->get('search/tweets', [
        'q' => $term,
        'lang' => 'en',
        'count' => 100,
        'max_id' => $max_id,
        'result_type' => 'recent',
        'include_entities' => false
      ]);
        $this->saveTweets($results);
      }
      // Sort tweets by popularity (Retweets + Favorites)
      usort($this->tweets, function($a, $b) {
        return $b['popularity'] - $a['popularity'];
      });
      // Remove tweets with the same text, ex. retweets
      $this->tweets = $this->removeDuplicates($this->tweets, 'tweet_text');
      // Add results to database
      $this->addToDb();
    }

  }

  // Save tweets from search results
  protected function saveTweets($results) {
    $results = (array)$results;
    $statuses = (array)$results['statuses'];
    foreach($statuses as $status) {
      $status = (array)$status;
      $tweet_id = $status['id'];
      $tweet_text = $status['text'];
      $tweet_text = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $tweet_text);
      $tweet_text = trim($tweet_text);
      $user = (array)$status['user'];
      $profile_name = $user['screen_name'];
      $profile_url = 'https://twitter.com/' . $profile_name;
      $tweet_url = $profile_url . '/status/' . $tweet_id;
      $retweet_count = $status['retweet_count'];
      $favorite_count = $status['favorite_count'];
      $popularity = $retweet_count + $favorite_count;
      $created_at = $status['created_at'];
      // Format date
      $date_created = date_create($created_at);
      date_sub($date_created, date_interval_create_from_date_string('5 hours'));
      $datestring = date_format($date_created, 'Y-m-d H:i:s');
      $created_at = $datestring;
      $this->tweets[] = [
        'tweet_id' => $tweet_id,
        'search_id' => $this->search_id,
        'tweet_text' => $tweet_text,
        'tweet_url' => $tweet_url,
        'profile_name' => $profile_name,
        'profile_url' => $profile_url,
        'retweet_count' => $retweet_count,
        'favorite_count' => $favorite_count,
        'popularity' => $popularity,
        'created_at' => $created_at
      ];
    }
  }

  // Remove tweets with duplicate text, ex. retweets
  protected function removeDuplicates($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
  }

  protected function addToDb() {
    foreach ($this->tweets as $tweet) {
      $tweetsTable = TableRegistry::get('Tweets');
      $tweetTbl = $tweetsTable->newEntity();
      $tweetTbl->search_id = $tweet['search_id'];
      $tweetTbl->tweet_text = $tweet['tweet_text'];
      $tweetTbl->tweet_url = $tweet['tweet_url'];
      $tweetTbl->profile_name = $tweet['profile_name'];
      $tweetTbl->profile_url = $tweet['profile_url'];
      $tweetTbl->retweet_count = $tweet['retweet_count'];
      $tweetTbl->favorite_count = $tweet['favorite_count'];
      $tweetTbl->popularity = $tweet['popularity'];
      $tweetTbl->created_at = $tweet['created_at'];
      $tweetsTable->save($tweetTbl);
      /*if ($tweetsTable->save($tweetTbl)) {
          $id = $tweetTbl->id;
      }*/
    }
  }

}
