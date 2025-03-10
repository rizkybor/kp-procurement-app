<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkRequestRab extends Model
{
    use HasFactory;

    protected $table = 'work_request_rab';

    protected $fillable = [
        'work_request_item_id',
        'quantity',
        'harga',
        'total_harga',
    ];

    public function workRequestItem()
    {
        return $this->belongsTo(WorkRequestItem::class, 'work_request_item_id');
    }
}
