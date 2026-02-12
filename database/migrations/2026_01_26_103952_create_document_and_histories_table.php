<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentAndHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_project_id');
            $table->unsignedBigInteger('document_folder_id');
            $table->string('document_no');
            $table->string('title');
            $table->string('revision')->nullable();
            $table->string('file_path');
            $table->boolean('is_final')->default(false);
            $table->timestamps();
        });

        Schema::create('document_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->string('action');
            $table->string('revision')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamp('created_at');

            $table->foreign('document_id')
                ->references('id')
                ->on('documents')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_histories');
        Schema::dropIfExists('documents');
    }
}
