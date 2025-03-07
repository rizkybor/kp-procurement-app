<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkRequestSpesification extends Model
{
    use HasFactory;

    protected $table = 'work_request_spesification';

    protected $fillable = [
        'work_request_id',
        'scope_of_work',
        'contract_type',
        'safety_aspect',
        'reporting',
        'provider_requirements',
        'payment_procedures',
    ];

    public function workRequest()
    {
        return $this->belongsTo(WorkRequest::class, 'work_request_id');
    }
}
