<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPicToActivityItemResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('activity_item_results', function (Blueprint $table) {
            $table->string('pic')->nullable()->after('inspector_name');
        });
    }

    public function down(): void
    {
        Schema::table('activity_item_results', function (Blueprint $table) {
            $table->dropColumn('pic');
        });
    }
}
