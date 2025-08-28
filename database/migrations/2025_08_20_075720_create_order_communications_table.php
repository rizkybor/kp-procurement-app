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
            $table->string('company_name')->nullable(); // Pastikan nullable
            $table->text('company_address')->nullable(); // Pastikan nullable
            $table->string('company_goal')->nullable(); // Pastikan nullable

            // Dokumen 2: Surat Permohonan Permintaan Harga
            $table->date('date_applicationletter')->nullable();
            $table->string('no_applicationletter')->nullable();

            // Dokumen 3: Surat Penawaran Harga
            $table->date('date_offerletter')->nullable();
            $table->string('no_offerletter')->nullable();
            $table->string('file_offerletter')->nullable();

            // Dokumen 4: Evaluasi Teknis
            $table->date('date_evaluationletter')->nullable();
            $table->string('no_evaluationletter')->nullable();
            $table->string('file_evaluationletter')->nullable();

            // Dokumen 5: Surat Undangan Negosiasi
            $table->date('date_negotiationletter')->nullable();
            $table->string('no_negotiationletter')->nullable();

            // Dokumen 6: Berita Acara Klarifikasi & Negosiasi
            $table->date('date_beritaacaraklarifikasi')->nullable();
            $table->string('no_beritaacaraklarifikasi')->nullable();
            $table->string('file_beritaacaraklarifikasi')->nullable();

            $table->string('nilaikontrak_lampiranberitaacaraklarifikasi')->nullable();
            $table->string('file_lampiranberitaacaraklarifikasi')->nullable();

            // Dokumen 7: Surat Penunjukan
            $table->date('date_suratpenunjukan')->nullable();
            $table->string('no_suratpenunjukan')->nullable();
            $table->string('file_suratpenunjukan')->nullable();

            // Dokumen 8: Bentuk Perikatan
            $table->date('date_bentukperikatan')->nullable();
            $table->string('no_bentukperikatan')->nullable();
            $table->string('file_bentukperikatan')->nullable();

            // Dokumen 9: Berita Acara Pemeriksaan (BAP)
            $table->date('date_bap')->nullable();
            $table->string('no_bap')->nullable();
            $table->string('file_bap')->nullable();

            // Dokumen 10: Berita Acara Serah Terima (BAST)
            $table->date('date_bast')->nullable();
            $table->string('no_bast')->nullable();
            $table->string('file_bast')->nullable();

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
