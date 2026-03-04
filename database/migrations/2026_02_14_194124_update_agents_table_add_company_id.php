<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->foreignId('company_id')
                ->after('id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->dropColumn('company_name');
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->string('company_name')->nullable();
            $table->dropConstrainedForeignId('company_id');
        });
    }
};
