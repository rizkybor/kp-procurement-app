<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkRequestSpesificationFile extends Model
{
    protected $table = 'work_request_spesification_files';

    protected $fillable = [
        'work_request_spesification_id',
        'file_name',
        'original_name',
        'extension',
        'size',
        'disk',
        'path',
        'uploaded_by',
        'description'
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function spesification(): BelongsTo
    {
        return $this->belongsTo(WorkRequestSpesification::class, 'work_request_spesification_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /** helper buat ambil URL publik (disk public) */
    // public function url(): string
    // {
    //     return \Storage::disk($this->disk)->url($this->path);
    // }
}