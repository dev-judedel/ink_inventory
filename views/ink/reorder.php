<h3>Reorder Suggestions</h3>
<table class="table">
  <thead><tr><th>SKU</th><th>Name</th><th>On Hand</th><th>Reorder Point</th></tr></thead>
  <tbody>
  <?php foreach ($items as $row): ?>
    <tr>
      <td><?=htmlspecialchars($row['sku'], ENT_QUOTES)?></td>
      <td><?=htmlspecialchars($row['name'], ENT_QUOTES)?></td>
      <td><?=$row['on_hand']?></td>
      <td><?=$row['reorder_point']?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>