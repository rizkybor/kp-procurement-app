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
        'company_name',
        'company_address',
        'company_goal',
        'date_applicationletter',
        'no_applicationletter',
        'date_offerletter',
        'no_offerletter',
        'file_offerletter',
        'date_evaluationletter',
        'no_evaluationletter',
        'date_negotiationletter',
        'no_negotiationletter',
        'file_beritaacaraklarifikasi',
        'file_bentukperikatan',
        'file_bap',
        'file_bast'
    ];

    public function workRequest()
    {
        return $this->belongsTo(WorkRequest::class, 'work_request_id');
    }
}
