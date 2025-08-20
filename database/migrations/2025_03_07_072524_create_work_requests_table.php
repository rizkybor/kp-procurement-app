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
        Schema::create('work_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('work_name_request', 50);
            $table->string('request_number', 50);
            $table->string('department', 100);
            $table->string('project_title', 255);
            $table->string('project_type', 255);
            // $table->string('project_owner', 255);
            // $table->string('contract_number', 100);
            $table->string('procurement_type', 50);
            $table->date('request_date');
            $table->date('deadline');
            $table->string('pic', 100);
            // $table->string('aanwijzing', 255);
            $table->string('time_period', 255)->nullable();
            $table->string('status', 255);
            $table->string('last_reviewers', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_requests');
    }
};
