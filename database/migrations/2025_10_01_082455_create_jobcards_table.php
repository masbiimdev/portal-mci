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
        // Tabel jobcards
        Schema::create('jobcards', function (Blueprint $table) {
            $table->id();
            $table->string('jobcard_no', 50)->unique();   // Nomor job card
            $table->string('ws_no', 50);                  // WS No.
            $table->string('customer', 100);              // Customer
            $table->string('serial_no', 100);             // Serial Number
            $table->string('drawing_no', 100);            // Drawing No.
            $table->string('disc', 50)->nullable();       // Disc
            $table->string('body', 50)->nullable();       // Body
            $table->string('bonnet', 50)->nullable();     // Bonnet
            $table->string('size_class', 50)->nullable(); // Size / Class
            $table->string('type', 100)->nullable();      // Type (Globe Valve, dll.)
            $table->integer('qty_acc_po')->default(0);    // Qty acc PO
            $table->date('date_line')->nullable();        // Date Line
            $table->enum('category', ['Reused','Repair','New Manufacture','Supplied'])
                  ->default('New Manufacture');           // Category
            $table->unsignedBigInteger('created_by');     // User pembuat
            $table->timestamps();

            // Relasi ke users
            $table->foreign('created_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });

        // Tabel jobcard_histories
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
        // Urutan drop harus jobcard_histories dulu karena ada FK ke jobcards
        Schema::dropIfExists('jobcard_histories');
        Schema::dropIfExists('jobcards');
    }
}
