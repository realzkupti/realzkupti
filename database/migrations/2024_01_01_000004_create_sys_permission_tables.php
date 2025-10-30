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
        // Department Menu Permissions
        Schema::create('sys_department_menu_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('menu_id');
            $table->boolean('can_view')->default(false);
            $table->boolean('can_create')->default(false);
            $table->boolean('can_update')->default(false);
            $table->boolean('can_delete')->default(false);
            $table->boolean('can_export')->default(false);
            $table->boolean('can_approve')->default(false);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->unique(['department_id', 'menu_id'], 'dept_menu_unique');
            $table->index('department_id');
            $table->index('menu_id');

            $table->foreign('department_id')
                  ->references('id')
                  ->on('sys_departments')
                  ->onDelete('cascade');

            $table->foreign('menu_id')
                  ->references('id')
                  ->on('sys_menus')
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

        // User Menu Permissions
        Schema::create('sys_user_menu_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('menu_id');
            $table->boolean('can_view')->default(false);
            $table->boolean('can_create')->default(false);
            $table->boolean('can_update')->default(false);
            $table->boolean('can_delete')->default(false);
            $table->boolean('can_export')->default(false);
            $table->boolean('can_approve')->default(false);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->unique(['user_id', 'menu_id'], 'user_menu_unique');
            $table->index('user_id');
            $table->index('menu_id');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('sys_users')
                  ->onDelete('cascade');

            $table->foreign('menu_id')
                  ->references('id')
                  ->on('sys_menus')
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
        Schema::dropIfExists('sys_user_menu_permissions');
        Schema::dropIfExists('sys_department_menu_permissions');
    }
};
