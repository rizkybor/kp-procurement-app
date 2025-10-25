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
        'project_type',
        'procurement_type',
        'request_date',
        'deadline',
        'pic',
        'time_period',
        'created_by',
        'status',
        'last_reviewers',
    ];

    // public function User()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    public function user()
    {
        // Assuming created_by is the foreign key to users table
        return $this->belongsTo(User::class, 'created_by');
    }

    public function orderCommunications()
    {
        return $this->hasMany(OrderCommunication::class, 'work_request_id');
    }

    public function workRequestItems()
    {
        return $this->hasMany(WorkRequestItem::class, 'work_request_id');
    }

    public function workRequestRab()
    {
        return $this->hasMany(WorkRequestRab::class, 'work_request_id');
    }

    public function getTotalRabAttribute()
    {
        return $this->workRequestRab()->sum('total_harga');
    }

    public function workRequestSignatures()
    {
        return $this->hasMany(WorkRequestSignature::class, 'work_request_id');
    }

    public function workRequestSpesifications()
    {
        return $this->hasMany(WorkRequestSpesification::class, 'work_request_id');
    }

    public function approvals()
    {
        return $this->morphMany(DocumentApproval::class, 'document');
    }

    public function latestApproval()
    {
        return $this->morphOne(DocumentApproval::class, 'document')->latestOfMany();
    }

    public function histories()
    {
        return $this->hasMany(DocHistories::class, 'document_id');
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_work_request', 'work_request_id', 'vendor_id')
            ->withTimestamps();
    }
}
