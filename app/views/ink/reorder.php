<?php /** Reorder suggestions in a Bootstrap modal */ ?>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reorderModal">
    View Reorder Suggestions
</button>

<div class="modal fade" id="reorderModal" tabindex="-1" aria-labelledby="reorderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reorderModalLabel">Reorder Suggestions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php if (!empty($items)): ?>
        <table class="table table-striped">
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
        <?php else: ?>
          <p class="mb-0 text-center">No items require reordering.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var modalEl = document.getElementById('reorderModal');
    if (modalEl) {
      var modal = new bootstrap.Modal(modalEl);
      modal.show();
    }
  });
</script>
