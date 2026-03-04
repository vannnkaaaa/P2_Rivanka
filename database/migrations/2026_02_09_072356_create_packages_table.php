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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['umrah', 'haji']);
            $table->string('code')->unique();
            $table->string('name');
            $table->string('slug')->unique();

            $table->decimal('price', 15, 2);
            $table->integer('quota');
            $table->integer('quota_used')->default(0);

            $table->date('departure_date');
            $table->integer('duration_days');

            $table->string('departure_city');
            $table->string('airline')->nullable();

            $table->string('hotel_makkah')->nullable();
            $table->string('hotel_madinah')->nullable();

            $table->enum('room_type', ['quad', 'triple', 'double'])->nullable();

            $table->enum('status', ['draft', 'published', 'closed'])
                ->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
