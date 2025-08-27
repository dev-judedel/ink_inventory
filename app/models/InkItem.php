<?php
namespace App\Models;

use Core\DB;

class InkItem extends Model
{
    protected $table = 'ink_items';
    protected $fillable = ['sku','name','brand','color','printer_models','uom','reorder_point','is_active'];

    public function batches() {
        return InkBatch::where('item_id', $this->id)->orderBy('received_at','asc')->get();
    }

    public function onHand(): int {
        $row = DB::query(
            "SELECT COALESCE(SUM(CASE WHEN type='IN' THEN qty WHEN type='OUT' THEN -qty ELSE qty END),0) AS soh
             FROM ink_movements WHERE item_id=?",
            [$this->id]
        )->first();
        return (int)($row['soh'] ?? 0);
    }

    public static function search($q)
    {
        return static::whereRaw(
            "(sku LIKE ? OR name LIKE ? OR brand LIKE ? OR color LIKE ?)",
            ["%$q%","%$q%","%$q%","%$q%"]
        )->get();
    }
}