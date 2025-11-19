<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalibrationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calibration_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tool_id')->constrained('tools')->onDelete('cascade');

            // Info Kalibrasi
            $table->date('tgl_kalibrasi')->nullable();
            $table->date('tgl_kalibrasi_ulang')->nullable();

            $table->string('no_sertifikat')->nullable();
            $table->string('file_sertifikat')->nullable(); // pdf per kalibrasi

            $table->string('lembaga_kalibrasi')->nullable();
            $table->string('interval_kalibrasi')->nullable();

            $table->enum('eksternal_kalibrasi', ['YA', 'TIDAK'])->default('YA');

            // Status periode ini
            $table->enum('status_kalibrasi', [
                'OK',
                'Proses'
            ])->default('OK');

            // Info catatan proses
            $table->string('keterangan')->nullable(); // "Sudah Berangkat 30-10-25"

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
        Schema::dropIfExists('calibration_histories');
    }
}
