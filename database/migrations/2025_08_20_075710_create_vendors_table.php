<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();

            // Vendor Data
            $table->string('name'); // Company Name
            $table->string('business_type')->nullable(); // business type (string, related to reference table)
            $table->string('tax_number')->nullable(); // NPWP (Tax ID)
            $table->text('company_address')->nullable(); // Company Address
            $table->json('business_fields')->nullable(); // Business Fields (Array)

            // Person in Charge
            $table->string('pic_name')->nullable();
            $table->string('pic_position')->nullable();
            
            // Bank Account
            $table->string('bank_name')->nullable();
            $table->string('bank_number')->nullable();

            // Company Documents
            $table->string('file_deed_of_company')->nullable();        // Akta Perusahaan
            $table->string('file_legalization_letter')->nullable();    // SK Pengesahan

            // Licenses
            $table->string('file_nib')->nullable();
            $table->string('file_siujk')->nullable();
            $table->string('file_tax_registration')->nullable();       // NPWP (file)
            $table->string('file_vat_registration')->nullable();       // PKP
            $table->string('file_id_card')->nullable();                // KTP

            // Additional Documents
            $table->string('file_vendor_statement')->nullable();
            $table->string('file_integrity_pact')->nullable();
            $table->string('file_vendor_feasibility')->nullable();
            $table->string('file_interest_statement')->nullable();

            $table->timestamps();
        });

        // reference table for business type
        Schema::create('business_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "Individual", "Corporate"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
        Schema::dropIfExists('business_types');
    }
};