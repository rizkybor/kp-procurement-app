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
        Schema::create('order_communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_request_id')->constrained('work_request')->onDelete('cascade');
            $table->string('company_name');
            $table->string('company_address');
            $table->string('company_goal');
            $table->string('date_applicationletter');
            $table->string('no_applicationletter');
            $table->string('date_offerletter');
            $table->string('no_offerletter');
            $table->string('file_offerletter');
            $table->string('date_evaluationletter');
            $table->string('no_evaluationletter');
            $table->string('date_negotiationletter');
            $table->string('no_negotiationletter');
            $table->string('file_beritaacaraklarifikasi');
            $table->string('file_bentukperikatan');
            $table->string('file_BAD');
            $table->string('file_BAST');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_communications');
    }
};
