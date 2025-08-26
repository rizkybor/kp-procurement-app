<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkRequestSpesification extends Model
{
    use HasFactory;

    protected $table = 'work_request_spesifications';

    protected $fillable = [
        'work_request_id',
        'scope_of_work',
        'contract_type',
        'payment_procedures',
    ];

    // relasi ke induk
    public function workRequest()
    {
        return $this->belongsTo(WorkRequest::class);
    }
    public function files()
    {
        return $this->hasMany(WorkRequestSpesificationFile::class, 'work_request_spesification_id');
    }
}
