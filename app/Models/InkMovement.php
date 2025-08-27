<?php
namespace App\Models;

class InkMovement extends Model
{
    protected $table = 'ink_movements';
    protected $fillable = ['item_id','batch_id','txn_date','type','ref_no','doc_type','doc_id','location','qty','unit_cost','avg_cost','note','created_by'];
}