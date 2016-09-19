<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Tweets Controller
 *
 * @property \App\Model\Table\TweetsTable $Tweets
 */
class TweetsController extends AppController
{

  public function initialize()
  {
    parent::initialize();
    $this->loadComponent('Flash');
  }

  public function index()
  {

    $this->paginate = [
      'contain' => ['Searches']
    ];
    $tweets = $this->paginate($this->Tweets);

    $this->set(compact('tweets'));
    $this->set('_serialize', ['tweets']);
  }

  public function view($id = null)
  {

    $tweet = $this->Tweets->get($id, [
      'contain' => ['Searches']
    ]);

    $this->set('tweet', $tweet);
    $this->set('_serialize', ['tweet']);
  }

  public function add()
  {
    $tweet = $this->Tweets->newEntity();
    if ($this->request->is('post')) {
      $tweet = $this->Tweets->patchEntity($tweet, $this->request->data);
      if ($this->Tweets->save($tweet)) {
        $this->Flash->success(__('Loading tweet'));
        return $this->redirect(['action' => 'results', $tweet->id]);
      } else {
        $this->Flash->error(__('The tweet could not be saved. Please, try again.'));
      }
    }
    $this->set(compact('tweet'));
    $this->set('_serialize', ['tweet']);
  }

}
