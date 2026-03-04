<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            // Identitas perusahaan
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();

            // Legalitas
            $table->string('ppiu_license_number')->nullable();
            $table->string('pihk_license_number')->nullable();
            $table->string('npwp')->nullable();

            // Relasi ke association
            $table->foreignId('association_id')
                ->nullable()
                ->constrained('associations')
                ->nullOnDelete();

            // Kontak utama
            $table->text('main_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive', 'suspended'])
                ->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
