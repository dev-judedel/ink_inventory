<div class="grid">
  <div>
    <h3><?=htmlspecialchars($item->name, ENT_QUOTES)?> (<?=htmlspecialchars($item->sku, ENT_QUOTES)?>)</h3>
    <p><b>Brand:</b> <?=htmlspecialchars($item->brand ?? '', ENT_QUOTES)?> •
       <b>Color:</b> <?=htmlspecialchars($item->color ?? '', ENT_QUOTES)?> •
       <b>UoM:</b> <?=htmlspecialchars($item->uom, ENT_QUOTES)?></p>
    <p><b>On Hand:</b> <?=$onHand?> • <b>Avg Cost:</b> ₱<?=number_format($avgCost,2)?></p>
  </div>
  <div class="mt-2 flex gap-2">
    <form method="post" action="/ink/<?=$item->id?>/receive" class="card p-2">
      <h4>Receive</h4>
      <input name="qty" type="number" min="1" required placeholder="Qty">
      <input name="unit_cost" type="number" step="0.01" min="0" required placeholder="Unit Cost">
      <input name="batch_no" placeholder="Batch #">
      <input name="supplier" placeholder="Supplier">
      <input name="expiry_date" type="date" placeholder="Expiry">
      <button class="btn">Receive</button>
    </form>

    <form method="post" action="/ink/<?=$item->id?>/issue" class="card p-2">
      <h4>Issue</h4>
      <input name="qty" type="number" min="1" required placeholder="Qty">
      <input name="location" placeholder="To (Dept / Printer)">
      <button class="btn">Issue</button>
    </form>

    <form method="post" action="/ink/<?=$item->id?>/adjust" class="card p-2">
      <h4>Adjust</h4>
      <input name="qty_delta" type="number" required placeholder="+/- Qty">
      <input name="note" placeholder="Reason">
      <button class="btn">Adjust</button>
    </form>
  </div>

  <div class="mt-3">
    <h4>Batches (FIFO)</h4>
    <table class="table">
      <thead><tr><th>Batch</th><th>Supplier</th><th>Received</th><th>Expiry</th><th>Unit Cost</th><th>Remaining</th></tr></thead>
      <tbody>
      <?php foreach ($batches as $b): ?>
        <tr>
          <td><?=htmlspecialchars($b->batch_no ?? '', ENT_QUOTES)?></td>
          <td><?=htmlspecialchars($b->supplier ?? '', ENT_QUOTES)?></td>
          <td><?=date('Y-m-d', strtotime($b->received_at))?></td>
          <td><?=htmlspecialchars($b->expiry_date ?? '', ENT_QUOTES)?></td>
          <td>₱<?=number_format($b->unit_cost,2)?></td>
          <td><?=$b->qty_remaining?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    <h4>Recent Movements</h4>
    <table class="table">
      <thead><tr><th>Date</th><th>Type</th><th>Qty</th><th>Unit Cost</th><th>Avg Cost</th><th>Ref</th><th>Loc</th><th>Note</th></tr></thead>
      <tbody>
      <?php foreach ($movements as $m): ?>
        <tr>
          <td><?=date('Y-m-d H:i', strtotime($m->txn_date))?></td>
          <td><?=htmlspecialchars($m->type, ENT_QUOTES)?></td>
          <td><?=$m->qty?></td>
          <td>₱<?=number_format($m->unit_cost,2)?></td>
          <td>₱<?=number_format($m->avg_cost,2)?></td>
          <td><?=htmlspecialchars($m->ref_no ?? '', ENT_QUOTES)?></td>
          <td><?=htmlspecialchars($m->location ?? '', ENT_QUOTES)?></td>
          <td><?=htmlspecialchars($m->note ?? '', ENT_QUOTES)?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>