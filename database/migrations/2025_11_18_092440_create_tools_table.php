<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();

            $table->string('nama_alat');
            $table->string('merek')->nullable();
            $table->string('no_seri')->nullable();
            $table->string('kapasitas')->nullable();

            // QR Code
            $table->string('qr_token')->unique()->nullable();
            $table->string('qr_code_path')->nullable();

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
        Schema::dropIfExists('tools');
    }
}
