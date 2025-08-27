<?php
namespace App\Models;

use Core\Model;

class InkBatch extends Model
{
    protected string $table = 'ink_batches';
    protected array $fillable = ['item_id','batch_no','supplier','expiry_date','unit_cost','qty_received','qty_remaining','received_at','remarks'];
}