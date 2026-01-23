<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_code')->unique();
            $table->string('project_number');
            $table->string('project_name');
            $table->text('description')->nullable(); // cukup 1 description
            $table->string('status', 20)->default('PENDING'); // status project
            $table->date('start_date')->nullable(); // tanggal mulai project
            $table->date('end_date')->nullable();   // tanggal selesai project (target atau real)
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
        Schema::dropIfExists('document_projects');
    }
}
