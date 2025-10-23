<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTables extends Migration
{
    public function up(): void
    {
        /**
         * 1️⃣ RACKS TABLE
         * Lokasi penyimpanan barang.
         */
        Schema::create('racks', function (Blueprint $table) {
            $table->id();
            $table->string('rack_code')->unique(); // contoh: R-01, R-02
            $table->string('rack_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        /**
         * 2️⃣ VALVES TABLE
         * Master data Valve
         */
        Schema::create('valves', function (Blueprint $table) {
            $table->id();
            $table->string('valve_code')->unique(); // contoh: VLV-001
            $table->string('valve_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        /**
         * 3️⃣ SPARE PARTS TABLE
         * Master data Spare Part
         */
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->id();
            $table->string('spare_part_code')->unique(); // contoh: SP-001
            $table->string('spare_part_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        /**
         * 4️⃣ MATERIALS TABLE
         * Master gabungan Valve & Spare Part.
         */
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('material_code')->unique(); // contoh: MTR-001
            $table->foreignId('spare_part_id')->nullable()->constrained('spare_parts')->onDelete('set null');
            $table->string('no_drawing')->nullable();
            $table->string('heat_lot_no')->nullable();
            $table->string('dimensi')->nullable();
            $table->integer('stock_awal')->default(0);
            $table->integer('stock_minimum')->default(0);
            $table->foreignId('rack_id')->nullable()->constrained('racks')->onDelete('set null');
            $table->timestamps();
        });

        /**
         * 5️⃣ MATERIAL-VALVE PIVOT TABLE
         * Relasi many-to-many antara material dan valve.
         */
        Schema::create('material_valve', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->foreignId('valve_id')->constrained('valves')->onDelete('cascade');
            $table->timestamps();
        });

        /**
         * 6️⃣ MATERIAL IN TABLE
         * Catatan barang masuk.
         */
        Schema::create('material_in', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('date_in');
            $table->integer('qty_in')->default(0);
            $table->integer('stock_after')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        /**
         * 7️⃣ MATERIAL OUT TABLE
         * Catatan barang keluar.
         */
        Schema::create('material_out', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('date_out');
            $table->integer('qty_out')->default(0);
            $table->integer('stock_after')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        /**
         * 8️⃣ STOCK OPNAME TABLE
         * Hasil perbandingan stok sistem vs fisik.
         */
        Schema::create('stock_opname', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->date('date_opname');
            $table->integer('stock_system')->default(0);
            $table->integer('stock_actual')->default(0);
            $table->integer('selisih')->default(0);
            $table->string('warning')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // urutan rollback dari yang punya foreign key ke yang independen
        Schema::dropIfExists('stock_opname');
        Schema::dropIfExists('material_out');
        Schema::dropIfExists('material_in');
        Schema::dropIfExists('material_valve');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('spare_parts');
        Schema::dropIfExists('valves');
        Schema::dropIfExists('racks');
    }
}
