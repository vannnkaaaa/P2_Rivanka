<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('jamaahs', function (Blueprint $table) {
            $table->string('batch_id')->nullable()->after('registration_number');
        });
    }

    public function down()
    {
        Schema::table('jamaahs', function (Blueprint $table) {
            $table->dropColumn('batch_id');
        });
    }
};
