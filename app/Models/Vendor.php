<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = [
        'name',
        'business_type',          // string, refer ke BusinessType::name
        'tax_number',
        'company_address',
        'business_fields',        // JSON
        'pic_name',
        'pic_position',
        'file_deed_of_company',
        'file_legalization_letter',
        'file_nib',
        'file_siujk',
        'file_tax_registration',
        'file_vat_registration',
        'file_id_card',
        'file_vendor_statement',
        'file_integrity_pact',
        'file_vendor_feasibility',
        'file_interest_statement',
    ];

    protected $casts = [
        'business_fields' => 'array', // otomatis decode/encode JSON
    ];

    /**
     * Relasi opsional ke referensi business type (berdasarkan nama).
     * Jika nanti beralih ke FK integer (business_type_id), ubah relasi ini.
     */
    public function businessType()
    {
        return $this->belongsTo(BusinessType::class, 'business_type', 'name');
    }
}