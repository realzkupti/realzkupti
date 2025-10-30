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
        Schema::create('sys_branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('code', 50)->unique();
            $table->string('name', 150);
            $table->string('address', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_head_office')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->index('company_id');
            $table->index('code');

            $table->foreign('company_id')
                  ->references('id')
                  ->on('sys_companies')
                  ->onDelete('cascade');

            // Using NO ACTION to prevent SQL Server cascade path conflicts
            $table->foreign('created_by')
                  ->references('id')
                  ->on('sys_users')
                  ->onDelete('no action');

            $table->foreign('updated_by')
                  ->references('id')
                  ->on('sys_users')
                  ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_branches');
    }
};
