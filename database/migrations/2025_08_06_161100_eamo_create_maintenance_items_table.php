<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eamo_maintenance_items', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('maintenance_category_id', 36);
            $table->foreignUuid('user_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('maintenance_category_id')
                ->references('id')
                ->on('eamo_maintenance_categories')
                ->cascadeOnDelete();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eamo_maintenance_items');
    }
};
