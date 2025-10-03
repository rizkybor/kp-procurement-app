<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    use HasFactory;

    protected $table = 'business_types';

    protected $fillable = [
        'nama',
    ];

    // Relasi ke vendor (berdasarkan nama)
    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'business_types', 'nama');
    }
}