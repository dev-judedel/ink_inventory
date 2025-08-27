<?php
namespace App\Models;

use Core\DB; use Exception; use DateTimeImmutable;

class InkInventoryService
{
    /** Receive stock into a new batch */
    public function receive(int $itemId, int $qty, float $unitCost, array $opts = []): void
    {
        if ($qty <= 0) throw new Exception('Qty must be > 0');
        DB::beginTransaction();
        try {
            $now = new DateTimeImmutable();
            $batch = new InkBatch([
                'item_id' => $itemId,
                'batch_no' => $opts['batch_no'] ?? null,
                'supplier' => $opts['supplier'] ?? null,
                'expiry_date' => $opts['expiry_date'] ?? null,
                'unit_cost' => $unitCost,
                'qty_received' => $qty,
                'qty_remaining' => $qty,
                'received_at' => $opts['received_at'] ?? $now->format('Y-m-d H:i:s'),
                'remarks' => $opts['remarks'] ?? null,
            ]);
            $batch->save();

            $avgCost = $this->computeAvgCost($itemId, $unitCost, $qty);

            (new InkMovement([
                'item_id' => $itemId,
                'batch_id' => $batch->id,
                'txn_date' => $now->format('Y-m-d H:i:s'),
                'type' => 'IN',
                'qty' => $qty,
                'unit_cost' => $unitCost,
                'avg_cost' => $avgCost,
                'ref_no' => $opts['ref_no'] ?? null,
                'doc_type' => $opts['doc_type'] ?? 'RCV',
                'doc_id' => $opts['doc_id'] ?? null,
                'location' => $opts['location'] ?? null,
                'note' => $opts['note'] ?? null,
                'created_by' => $opts['user_id'] ?? null,
            ]))->save();

            DB::commit();
        } catch (Exception $e) { DB::rollBack(); throw $e; }
    }

    /** Issue stock using FIFO across batches */
    public function issue(int $itemId, int $qty, array $opts = []): void
    {
        if ($qty <= 0) throw new Exception('Qty must be > 0');
        DB::beginTransaction();
        try {
            $now = new DateTimeImmutable();
            $remaining = $qty;

            $batches = InkBatch::where('item_id',$itemId)
                ->where('qty_remaining','>',0)
                ->orderBy('received_at','asc')
                ->lockForUpdate()
                ->get();

            foreach ($batches as $batch) {
                if ($remaining <= 0) break;
                $take = min($batch->qty_remaining, $remaining);
                $batch->qty_remaining -= $take; $batch->save();

                $avgCost = $this->currentAvgCost($itemId);

                (new InkMovement([
                    'item_id' => $itemId,
                    'batch_id' => $batch->id,
                    'txn_date' => $now->format('Y-m-d H:i:s'),
                    'type' => 'OUT',
                    'qty' => $take,
                    'unit_cost' => $batch->unit_cost,
                    'avg_cost' => $avgCost,
                    'ref_no' => $opts['ref_no'] ?? null,
                    'doc_type' => $opts['doc_type'] ?? 'ISS',
                    'doc_id' => $opts['doc_id'] ?? null,
                    'location' => $opts['location'] ?? null,
                    'note' => $opts['note'] ?? null,
                    'created_by' => $opts['user_id'] ?? null,
                ]))->save();

                $remaining -= (int)$take;
            }

            if ($remaining > 0) throw new Exception('Insufficient stock to issue requested qty.');
            DB::commit();
        } catch (Exception $e) { DB::rollBack(); throw $e; }
    }

    /** Manual adjustment (+/-) without touching batches (cost uses current avg) */
    public function adjust(int $itemId, int $qtyDelta, array $opts = []): void
    {
        if ($qtyDelta === 0) return;
        DB::beginTransaction();
        try {
            $now = new DateTimeImmutable();
            $avg = $this->currentAvgCost($itemId);

            (new InkMovement([
                'item_id' => $itemId,
                'batch_id' => null,
                'txn_date' => $now->format('Y-m-d H:i:s'),
                'type' => 'ADJ',
                'qty' => $qtyDelta,
                'unit_cost' => $avg,
                'avg_cost' => $avg,
                'ref_no' => $opts['ref_no'] ?? null,
                'doc_type' => $opts['doc_type'] ?? 'ADJ',
                'doc_id' => $opts['doc_id'] ?? null,
                'location' => $opts['location'] ?? null,
                'note' => $opts['note'] ?? null,
                'created_by' => $opts['user_id'] ?? null,
            ]))->save();

            DB::commit();
        } catch (Exception $e) { DB::rollBack(); throw $e; }
    }

    public function currentAvgCost(int $itemId): float
    {
        $row = DB::query(
            "SELECT CASE WHEN SUM(qty) = 0 THEN 0
                    ELSE ROUND(SUM(unit_cost*CASE WHEN type='IN' THEN qty WHEN type='OUT' THEN -qty ELSE qty END) /
                               SUM(CASE WHEN type='IN' THEN qty WHEN type='OUT' THEN -qty ELSE qty END), 2)
                 END AS avg_cost
             FROM ink_movements WHERE item_id=?",
            [$itemId]
        )->first();
        return (float)($row['avg_cost'] ?? 0.0);
    }

    public function computeAvgCost(int $itemId, float $incomingUnitCost, int $incomingQty): float
    {
        $row = DB::query(
            "SELECT COALESCE(SUM(CASE WHEN type='IN' THEN qty WHEN type='OUT' THEN -qty ELSE qty END),0) AS qty_onhand,
                    COALESCE(SUM(unit_cost*CASE WHEN type='IN' THEN qty WHEN type='OUT' THEN -qty ELSE qty END),0) AS total_cost
             FROM ink_movements WHERE item_id=?",
            [$itemId]
        )->first();

        $currentQty = (int)($row['qty_onhand'] ?? 0);
        $currentCost = (float)($row['total_cost'] ?? 0);
        $newQty = $currentQty + $incomingQty;
        if ($newQty <= 0) return $incomingUnitCost;
        $newTotal = $currentCost + ($incomingUnitCost * $incomingQty);
        return round($newTotal / $newQty, 2);
    }

    public function reorderCandidates(): array
    {
<<<<<<< HEAD:app/Models/InkInventoryService.php
        $sql = "
=======
<<<<<<<< HEAD:app/Services/InkInventoryService.php
        $rows = DB::query("
========
        $sql = "
>>>>>>>> 50c8e431d7568ea4d5a49d17a510f6f8ea27bfc4:app/models/InkInventoryService.php
>>>>>>> 50c8e431d7568ea4d5a49d17a510f6f8ea27bfc4:app/models/InkInventoryService.php
            SELECT i.*, (
                SELECT COALESCE(SUM(CASE WHEN type='IN' THEN qty WHEN type='OUT' THEN -qty ELSE qty END),0)
                FROM ink_movements m WHERE m.item_id=i.id
            ) AS on_hand
            FROM ink_items i
            WHERE i.is_active=1
            HAVING on_hand <= i.reorder_point
            ORDER BY name ASC
<<<<<<< HEAD:app/Models/InkInventoryService.php
        ";
        $rows = DB::query($sql)->all();
=======
<<<<<<<< HEAD:app/Services/InkInventoryService.php
        ")->all();
========
        ";
        $rows = DB::query($sql)->all();
>>>>>>>> 50c8e431d7568ea4d5a49d17a510f6f8ea27bfc4:app/models/InkInventoryService.php
>>>>>>> 50c8e431d7568ea4d5a49d17a510f6f8ea27bfc4:app/models/InkInventoryService.php
        return $rows;
    }
}
