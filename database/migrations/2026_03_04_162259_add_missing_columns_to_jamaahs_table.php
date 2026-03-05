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
        Schema::table('jamaahs', function (Blueprint $table) {
            $table->foreignId('agent_id')->nullable()->after('people_id')
                ->constrained('agents')->nullOnDelete();
            $table->foreignId('group_id')->nullable()->after('package_id')
                ->constrained('jamaah_groups')->nullOnDelete();
            $table->string('registration_number')->nullable()->unique()->after('group_id');
            $table->date('departure_date')->nullable()->after('registration_number');
        });
    }

    public function down(): void
    {
        Schema::table('jamaahs', function (Blueprint $table) {
            $table->dropForeign(['agent_id']);
            $table->dropForeign(['group_id']);
            $table->dropColumn(['agent_id', 'group_id', 'registration_number', 'departure_date']);
        });
    }
};
