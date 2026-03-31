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
            $table->string('no_ncr')->unique()->comment('Nomor dokumen NCR');
            $table->date('issue_date')->comment('Tanggal NCR diterbitkan');
            $table->text('issue')->comment('Deskripsi temuan ketidaksesuaian');
            $table->enum('audit_scope', ['Internal', 'External', 'Supplier'])->default('Internal');

            // Analitik & Prioritas
            $table->enum('severity', ['Critical', 'High', 'Medium', 'Low'])->default('Medium');

            // Status & Tracking
            $table->enum('status', ['Open', 'Monitoring', 'Closed'])->default('Open');


            // Timestamp bawaan Laravel (created_at, updated_at)
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
