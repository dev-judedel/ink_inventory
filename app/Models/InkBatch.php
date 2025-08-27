<?php
namespace App\Models;

class InkBatch extends Model
{
    protected $table = 'ink_batches';
    protected $fillable = ['item_id','batch_no','supplier','expiry_date','unit_cost','qty_received','qty_remaining','received_at','remarks'];
}