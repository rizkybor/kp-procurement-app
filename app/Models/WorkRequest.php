<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkRequest extends Model
{
    use HasFactory;

    protected $table = 'work_request';

    protected $fillable = [
        'work_name_request',
        'request_number',
        'department',
        'project_title',
        'project_owner',
        'procurement_type',
        'contract_number',
        'request_date',
        'deadline',
        'pic',
        'aanwijzing',
        'time_period',
        'created_by',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function workRequestItems()
    {
        return $this->hasMany(WorkRequestItem::class, 'work_request_id');
    }

    public function workRequestSignatures()
    {
        return $this->hasMany(WorkRequestSignature::class, 'work_request_id');
    }

    public function workRequestSpesifications()
    {
        return $this->hasMany(WorkRequestSpesification::class, 'work_request_id');
    }
}
