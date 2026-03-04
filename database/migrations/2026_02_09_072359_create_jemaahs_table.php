<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jamaahs', function (Blueprint $table) {
            $table->id();

            // relasi ke people (polymorphic root)
            $table->foreignId('people_id')
                ->constrained('people')
                ->cascadeOnDelete();

            // relasi ke paket (umrah / haji)
            $table->foreignId('package_id')
                ->constrained('packages')
                ->cascadeOnDelete();

            // status proses jemaah
            $table->enum('status', [
                'draft',                // baru daftar
                'booked',               // sudah booking
                'paid',                 // DP / lunas
                'documents_verified',   // dokumen lengkap
                'ready',                // siap berangkat
                'departed'              // sudah berangkat
            ])->default('draft');

            $table->timestamps();

            // 1 people hanya boleh punya 1 jamaah aktif
            $table->unique('people_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jemaahs');
    }
};
