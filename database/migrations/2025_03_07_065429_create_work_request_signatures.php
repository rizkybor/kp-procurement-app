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
        Schema::create('work_request_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_request_id')->constrained('work_request')->onDelete('cascade');
            $table->text('sign_mgr_keuangan')->nullable(false);
            $table->integer('sign_dir_keuangan')->nullable(false);
            $table->string('sign_dir_utama', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_request_signatures');
    }
};
