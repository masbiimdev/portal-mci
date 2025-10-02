<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartemenNikToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('departemen', ['QC', 'ASSEMBLING', 'MACHINING', 'PACKING'])
                ->nullable()
                ->after('email');
            $table->string('nik')->nullable()->after('departemen');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['departemen', 'nik']);
        });
    }
}
