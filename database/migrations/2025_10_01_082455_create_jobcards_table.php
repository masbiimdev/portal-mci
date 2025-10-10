<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobcardsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobcards', function (Blueprint $table) {
            $table->id();

            $table->string('jobcard_id', 50)->unique();
            $table->string('ws_no', 50);                     // WS No.
            $table->string('customer', 100);                 // Customer
            $table->enum('category', ['Reused', 'Repair', 'New Manufacture', 'Supplied'])
                ->default('New Manufacture'); // pilih salah satu dari enum
            // Type Jobcard
            $table->string('type_valve', 50)->nullable();    // Type Valve
            $table->string('size_class', 50)->nullable();    // Size / Class
            $table->string('drawing_no', 100)->nullable();   // Drawing No.
            $table->enum('type_jobcard', ['Jobcard Machining', 'Jobcard Assembling'])
                ->default('Jobcard Machining');            // Type Jobcard
            $table->date('date_line')->nullable();           // Date Line
            $table->text('remarks')->nullable();            // Remarks
            $table->text('detail')->nullable();             // Detail
            $table->string('batch_no', 50)->nullable();     // Batch No
            $table->string('material', 50)->nullable();     // Material
            $table->integer('qty')->default(0);             // Qty
            $table->string('part_name', 100)->nullable();   // Part Name
            $table->string('serial_no', 100)->nullable();   // Serial No
            $table->string('body', 50)->nullable();         // Body
            $table->string('bonnet', 50)->nullable();       // Bonnet
            $table->string('disc', 50)->nullable();         // Disc
            $table->integer('qty_acc_po')->default(0);      // Qty Acc PO
            $table->string('no_joborder', 100)->nullable(); // No Job Order
            $table->unsignedBigInteger('created_by');       // User pembuat
            $table->timestamps();

            // Relasi ke users
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        // Tabel jobcard_histories tetap sama
        Schema::create('jobcard_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobcard_id')
                ->constrained('jobcards')
                ->onDelete('cascade');  // FK ke jobcards
            $table->string('process_name', 100); // "Machining", "Assembly", dll
            $table->string('action', 50);        // "Scan In", "Scan Out", "Update Status"
            $table->foreignId('scanned_by')
                ->constrained('users');      // FK ke users
            $table->timestamp('scanned_at')->useCurrent();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop jobcard_histories dulu karena ada FK ke jobcards
        Schema::dropIfExists('jobcard_histories');
        Schema::dropIfExists('jobcards');
    }
}
