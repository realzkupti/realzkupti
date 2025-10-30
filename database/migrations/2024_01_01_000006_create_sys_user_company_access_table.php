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
        Schema::create('sys_user_company_access', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->unique(['user_id', 'company_id']);
            $table->index('user_id');
            $table->index('company_id');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('sys_users')
                  ->onDelete('cascade');

            $table->foreign('company_id')
                  ->references('id')
                  ->on('sys_companies')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_user_company_access');
    }
};
