<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_request_spesifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('work_request_id')->constrained('work_request')->onDelete('cascade');

            $table->string('scope_of_work', 255)->nullable();
            $table->string('contract_type', 255)->nullable();
            $table->string('payment_procedures', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_request_spesifications');
    }
};
