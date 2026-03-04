<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // polymorphic relation
            $table->unsignedBigInteger('userable_id');
            $table->string('userable_type');

            // login credentials
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');

            // security & status
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            $table->timestamps();

            $table->index(['userable_id', 'userable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
