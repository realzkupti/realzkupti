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
        Schema::create('sys_companies', function (Blueprint $table) {
            $table->id();
            $table->string('key', 50)->unique();
            $table->string('label', 150);
            $table->string('logo', 255)->nullable();
            $table->string('driver', 20)->default('mysql');
            $table->string('host', 150);
            $table->integer('port')->nullable();
            $table->string('database', 150);
            $table->string('username', 150);
            $table->string('password', 255)->nullable();
            $table->string('charset', 20)->nullable();
            $table->string('collation', 50)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->index('key');

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
        Schema::dropIfExists('sys_companies');
    }
};
