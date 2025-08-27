<?php
namespace App\Models;

use Core\Model;

class InkMovement extends Model
{
    protected string $table = 'ink_movements';
    protected array $fillable = ['item_id','batch_id','txn_date','type','ref_no','doc_type','doc_id','location','qty','unit_cost','avg_cost','note','created_by'];
}