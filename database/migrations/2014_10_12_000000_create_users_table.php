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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role',  ['user', 'admin'])->default('user');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            ['email' => 'user@mail.com', 'username' => 'John Johnny James', 'password' => bcrypt('pass1234'), 'role' => 'user'],
            ['email' => 'admin@mail.com', 'username' => 'Administrator', 'password' => bcrypt('pass1234'), 'role' => 'admin']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
