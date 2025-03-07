<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_request_spesification', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_request_id')->constrained('work_request')->onDelete('cascade');
            $table->string('scope_of_work', 255);
            $table->string('contract_type', 255);
            $table->string('safety_aspect', 255);
            $table->string('reporting', 255);
            $table->string('provider_requirements', 255);
            $table->string('payment_procedures', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_request_spesification');
    }
};
