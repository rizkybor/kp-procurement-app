<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCommunication extends Model
{
    use HasFactory;
    protected $table = 'order_communications';
    protected $fillable = [
        'work_request_id',
        'subject',
        'message',
        'status',
        'document_1_path',
        'document_2_path',
        'document_3_path',
        'document_4_path',
    ];

    public function workRequest()
    {
        return $this->belongsTo(WorkRequest::class, 'work_request_id');
    }
}
