<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agents', function (Blueprint $table) {

            // hapus kolom lama
            $table->dropColumn('association_name');

            // tambah foreign key baru
            $table->foreignId('association_id')
                ->nullable()
                ->after('company_id')
                ->constrained('associations')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {

            $table->dropForeign(['association_id']);
            $table->dropColumn('association_id');

            $table->string('association_name')->nullable();
        });
    }
};
