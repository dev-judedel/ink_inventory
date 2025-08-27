<div class="card">
  <div class="card-header"><h3>Ink Items</h3></div>
  <div class="card-body">
    <form method="get" class="mb-2">
      <input type="text" name="q" placeholder="Search..." value="<?=htmlspecialchars($_GET['q']??'', ENT_QUOTES)?>">
      <button class="btn">Search</button>
    </form>
    <table class="table">
      <thead><tr><th>SKU</th><th>Name</th><th>Brand</th><th>Color</th><th>On Hand</th><th>Reorder Pt</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($items as $it): ?>
          <tr>
            <td><?=htmlspecialchars($it->sku, ENT_QUOTES)?></td>
            <td><a href="/ink/<?=$it->id?>"><?=htmlspecialchars($it->name, ENT_QUOTES)?></a></td>
            <td><?=htmlspecialchars($it->brand ?? '', ENT_QUOTES)?></td>
            <td><?=htmlspecialchars($it->color ?? '', ENT_QUOTES)?></td>
            <td><?=$it->onHand()?></td>
            <td><?=$it->reorder_point?></td>
            <td><a class="btn btn-sm" href="/ink/<?=$it->id?>">Open</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>