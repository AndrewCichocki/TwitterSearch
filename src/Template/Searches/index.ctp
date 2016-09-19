<h1>Searches</h1>
<table>
  <tr>
    <th>Id</th>
    <th>Term</th>
    <th>Results</th>
    <th>Executed</th>
  </tr>
  <?php foreach ($searches as $search): ?>
    <tr>
      <td>
        <?= $search->id ?>
      </td>
      <td>
        <?= $search->term ?>
      </td>
      <td>
        <?= $this->Html->link(__('Results'), ['action' => 'results', $search->id]) ?>
      </td>
      <td>
        <?= $search->executed->format(DATE_RFC850) ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
