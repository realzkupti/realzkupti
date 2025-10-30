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
        Schema::create('sys_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('department_id')->nullable();

            // Two Factor Authentication
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->index('email');
            $table->index('department_id');

            $table->foreign('department_id')
                  ->references('id')
                  ->on('sys_departments')
                  ->onDelete('set null');
        });

        // Add foreign keys for created_by and updated_by
        Schema::table('sys_users', function (Blueprint $table) {
            $table->foreign('created_by')
                  ->references('id')
                  ->on('sys_users')
                  ->onDelete('set null');

            $table->foreign('updated_by')
                  ->references('id')
                  ->on('sys_users')
                  ->onDelete('set null');
        });

        // Add foreign keys to sys_departments
        Schema::table('sys_departments', function (Blueprint $table) {
            $table->foreign('created_by')
                  ->references('id')
                  ->on('sys_users')
                  ->onDelete('set null');

            $table->foreign('updated_by')
                  ->references('id')
                  ->on('sys_users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_users');
    }
};
