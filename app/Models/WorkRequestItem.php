<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkRequestItem extends Model
{
    use HasFactory;

    protected $table = 'work_request_items';

    protected $fillable = [
        'work_request_id',
        'item_desc_request',
        'quantity',
        'unit',
        'notes',
    ];

    public function workRequest()
    {
        return $this->belongsTo(WorkRequest::class, 'work_request_id');
    }
}
