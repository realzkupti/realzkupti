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
        Schema::create('sys_menus', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->string('label', 150);
            $table->string('icon', 100)->nullable();
            $table->string('route', 150)->nullable();
            $table->string('url', 255)->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('department_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system')->default(false);
            $table->boolean('has_sticky_note')->default(false);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->index('key');
            $table->index('parent_id');
            $table->index('department_id');
            $table->index('sort_order');

            // Using NO ACTION to prevent SQL Server cascade path conflicts
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('sys_menus')
                  ->onDelete('no action');

            $table->foreign('department_id')
                  ->references('id')
                  ->on('sys_departments')
                  ->onDelete('set null');

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
        Schema::dropIfExists('sys_menus');
    }
};
