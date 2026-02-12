<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentFoldersTable extends Migration
{
    public function up()
    {
        Schema::create('document_folders', function (Blueprint $table) {
            $table->id();

            // relasi ke document_projects
            $table->foreignId('document_project_id')
                  ->constrained('document_projects')
                  ->cascadeOnDelete();

            $table->string('folder_name');
            $table->string('folder_code');
            $table->text('description')->nullable();

            $table->timestamps();

            // folder unik per project
            $table->unique(['document_project_id', 'folder_name']);
            $table->unique(['document_project_id', 'folder_code']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_folders');
    }
}
