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
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID sebagai primary key
            $table->string('menu_label'); // Label menu
            $table->string('menu_route')->nullable(); // Route yang terkait dengan menu
            $table->integer('menu_level'); // Level menu (misalnya untuk hierarki menu)
            $table->uuid('menu_parent')->nullable(); // UUID dari parent menu
            $table->uuid('menu_permission')->nullable(); // UUID untuk permission yang terkait
            $table->boolean('menu_is_active')->default(true); // Status aktif atau tidak
            $table->timestamps(); // Kolom created_at dan updated_at
            // Foreign key untuk menu_parent (opsional, jika ada hierarki menu)
            $table->foreign('menu_parent')->references('id')->on('menus')->onDelete('cascade');
            // Foreign key untuk menu_permission (opsional, jika terkait dengan permission)
            $table->foreign('menu_permission')->references('id')->on('permissions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
