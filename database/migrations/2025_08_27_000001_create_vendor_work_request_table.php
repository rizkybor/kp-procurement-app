<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel WorkRequest Anda bernama 'work_request' (singular), jadi FK mengarah ke sana
        Schema::create('vendor_work_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('work_request_id')->constrained('work_request')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['vendor_id', 'work_request_id'], 'vendor_wr_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_work_request');
    }
};