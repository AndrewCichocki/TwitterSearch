<?php
namespace App\Controller;

use App\Controller\AppController;

require 'TwitterController.php';

/**
 * Searches Controller
 *
 * @property \App\Model\Table\SearchesTable $Searches
 */
class SearchesController extends AppController
{

  public function initialize()
  {
    parent::initialize();
    $this->loadComponent('Flash');
  }

  public function index()
  {

    $searches = $this->paginate($this->Searches);
    $this->set(compact('searches'));
    $this->set('_serialize', ['searches']);
  }

  public function results($id = null)
  {

    $search = $this->Searches->get($id, [
      'contain' => ['Tweets']
    ]);

    $this->set('search', $search);
    $this->set('_serialize', ['search']);
  }

  public function new()
  {
    $search = $this->Searches->newEntity();
    if ($this->request->is('post')) {
      $search = $this->Searches->patchEntity($search, $this->request->data);
      if ($this->Searches->save($search)) {
        $twitterController = new TwitterController();
        $twitterController->search($search->term, $search->id);
        //$this->Flash->success(__('Loading search results'));
        return $this->redirect(['action' => 'results', $search->id]);
      } else {
        $this->Flash->error(__('The search could not be saved. Please, try again.'));
      }
    }
    $this->set(compact('search'));
    $this->set('_serialize', ['search']);
  }

}
