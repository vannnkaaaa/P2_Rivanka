<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();

            // Relasi ke company
            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            // Data rekening
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_number');

            // Penanda rekening utama
            $table->boolean('is_main')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
