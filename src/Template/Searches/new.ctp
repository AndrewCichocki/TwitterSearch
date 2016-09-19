<div class="search-form">
  <h4>Search Twitter</h4>
  <?= $this->Form->create($search) ?>
  <?php
    echo $this->Form->input('term', [
      'label' => '',
      'type' => 'search',
      'maxlength' => 100
    ]);
  ?>
  <?= $this->Form->button('Search') ?>
  <?= $this->Form->end() ?>
</div>
<div>
  <?= $this->Html->link(__('Previous Search Results'), ['action' => 'index']) ?>
</div>
