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
        'description',
        'quantity',
        'unit',
        'notes',
        'price',
        'total_price',
    ];

    public function workRequest()
    {
        return $this->belongsTo(WorkRequest::class, 'work_request_id');
    }
}
