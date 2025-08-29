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
        'vendor_id',
        'date_applicationletter',
        'no_applicationletter',
        'date_offerletter',
        'no_offerletter',
        'file_offerletter',
        'date_evaluationletter',
        'no_evaluationletter',
        'date_negotiationletter',
        'no_negotiationletter',
        'date_beritaacaraklarifikasi',
        'no_beritaacaraklarifikasi',
        'date_suratpenunjukan',
        'no_suratpenunjukan',
        'date_bentukperikatan',
        'no_bentukperikatan',
        'date_bap',
        'no_bap',
        'date_bast',
        'no_bast',
        'nilaikontrak_lampiranberitaacaraklarifikasi',
        'file_beritaacaraklarifikasi',
        'file_bentukperikatan',
        'file_bap',
        'file_bast',
        'file_evaluationletter',
        'file_lampiranberitaacaraklarifikasi',
        'file_suratpenunjukan'
    ];

    public function workRequest()
    {
        return $this->belongsTo(WorkRequest::class, 'work_request_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
