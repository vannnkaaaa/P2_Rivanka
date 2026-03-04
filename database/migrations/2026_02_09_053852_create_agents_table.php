<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();

            // Relasi ke identitas manusia (people)
            $table->foreignId('people_id')
                  ->constrained('people')
                  ->cascadeOnDelete();

            // Data legalitas & perusahaan
            $table->string('company_name');
            $table->string('ppiu_license_number')->unique();
            $table->string('pihk_license_number')->nullable();
            $table->text('office_address');
            $table->string('bank_name');
            $table->string('bank_account_name');
            $table->string('bank_account_number');
            $table->string('association_name')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
