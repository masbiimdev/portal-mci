<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityItemResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('activity_item_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');
            $table->string('part_name');
            $table->string('material')->nullable();
            $table->integer('qty')->nullable();
            $table->string('inspector_name');
            $table->time('inspection_time')->nullable();
            $table->string('result')->nullable();
            $table->enum('status', ['Checked', 'Unchecked'])->default('Unchecked');
            $table->text('remarks')->nullable();
            $table->boolean('has_result')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_item_results');
    }
}
