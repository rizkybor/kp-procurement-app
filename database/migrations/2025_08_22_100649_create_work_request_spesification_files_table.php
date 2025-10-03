<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_request_spesification_files', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('work_request_spesification_id');
            $table->foreign('work_request_spesification_id', 'fk_wr_spec_files_spec')
                  ->references('id')->on('work_request_spesifications')
                  ->cascadeOnDelete();

            $table->string('file_name');
            $table->string('original_name');
            $table->string('description')->nullable();;
            $table->string('extension', 20)->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->string('path')->nullable();

            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->foreign('uploaded_by', 'fk_wr_spec_files_user')
                  ->references('id')->on('users')
                  ->nullOnDelete();

            $table->timestamps();

            $table->index('work_request_spesification_id', 'idx_wr_spec_files_spec');
        });
    }

    public function down(): void
    {
        Schema::table('work_request_spesification_files', function (Blueprint $table) {
            $table->dropForeign('fk_wr_spec_files_spec');
            $table->dropForeign('fk_wr_spec_files_user');
            $table->dropIndex('idx_wr_spec_files_spec');
        });
        Schema::dropIfExists('work_request_spesification_files');
    }
};