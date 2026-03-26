<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectImageToDocumentProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_projects', function (Blueprint $table) {
            // Menambahkan kolom project_image setelah kolom description
            $table->string('project_image')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_projects', function (Blueprint $table) {
            // Menghapus kolom jika dilakukan rollback
            $table->dropColumn('project_image');
        });
    }
}
