<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstTypeProcurement extends Model
{
    protected $table = 'mst_type_procurement';
    protected $fillable = ['name'];
}
