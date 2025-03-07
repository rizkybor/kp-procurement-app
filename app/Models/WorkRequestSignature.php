<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkRequestSignature extends Model
{
    use HasFactory;

    protected $table = 'work_request_signatures';

    protected $fillable = [
        'work_request_id',
        'sign_mgr_keuangan',
        'sign_dir_keuangan',
        'sign_dir_utama',
    ];

    public function workRequest()
    {
        return $this->belongsTo(WorkRequest::class, 'work_request_id');
    }
}
