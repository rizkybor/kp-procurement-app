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
            $table->string('subject');
            $table->text('message');
            $table->string('status')->default('pending');
            $table->string('document_1_path')->nullable();
            $table->string('document_2_path')->nullable();
            $table->string('document_3_path')->nullable();
            $table->string('document_4_path')->nullable();
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
