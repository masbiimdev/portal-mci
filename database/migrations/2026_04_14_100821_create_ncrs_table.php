<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNcrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ncrs', function (Blueprint $table) {
            $table->id();
            // Identitas Utama NCR
            $table->string('id_ncr')->unique()->comment('Kode Unik Upload NCR'); // Ditambah dan diset unique
            $table->string('no_ncr')->comment('Nomor dokumen NCR'); // unique() dihilangkan
            $table->date('issue_date')->comment('Tanggal NCR diterbitkan');

            // Detail Dokumen & Barang 
            $table->string('no_po')->nullable()->comment('Nomor Purchase Order');
            $table->integer('qty')->nullable()->comment('Jumlah barang');
            $table->string('report_reff')->nullable()->comment('Referensi Laporan');

            // Temuan & Tindakan 
            $table->text('issue')->comment('Deskripsi temuan ketidaksesuaian');
            $table->text('tindakan')->nullable()->comment('Tindakan perbaikan/koreksi');

            // Klasifikasi Audit
            $table->enum('audit_scope', ['Internal', 'External', 'Supplier'])->default('Internal');

            // Analitik & Prioritas
            $table->enum('severity', ['Critical', 'High', 'Medium', 'Low'])->default('Medium');

            // Status & Tracking
            $table->enum('status', ['Open', 'Monitoring', 'Closed'])->default('Open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ncrs');
    }
}
