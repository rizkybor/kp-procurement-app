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
        Schema::create('work_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_request_id')->constrained('work_request')->onDelete('cascade');
            $table->text('description')->nullable(false);
            $table->integer('quantity')->nullable(false);
            $table->string('unit', 50)->nullable();
            $table->text('notes')->nullable()->length(255);
            $table->string('price', 12)->nullable();
            $table->string('total_price', 12)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_request_items');
    }
};
