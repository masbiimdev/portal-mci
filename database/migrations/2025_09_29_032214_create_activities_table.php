<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['meeting', 'production', 'other']);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('kegiatan');
            $table->string('customer');
            $table->string('po')->nullable();
            $table->json('items')->nullable(); // <- part_name, material, qty, remarks dalam JSON
            $table->enum('status', ['Pending', 'On Going', 'Reschedule', 'Done'])->default('Pending');
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
        Schema::dropIfExists('activities');
    }
}
