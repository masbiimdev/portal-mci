<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToNcrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ncrs', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom tertentu agar urutannya rapi
            $table->string('no_po')->nullable()->after('issue_date')->comment('Nomor Purchase Order');
            $table->integer('qty')->nullable()->after('no_po')->comment('Jumlah barang');
            $table->string('report_reff')->nullable()->after('qty')->comment('Referensi Laporan');
            $table->text('tindakan')->nullable()->after('issue')->comment('Tindakan perbaikan/koreksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ncrs', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn(['no_po', 'qty', 'report_reff', 'tindakan']);
        });
    }
}
