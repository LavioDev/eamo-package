<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eamo_equipment', function (Blueprint $table): void {
            $table->string('id', 36)->primary();
            $table->string('parent_id', 36)->nullable()->index();
            $table->string('code', 32)->unique();
            $table->string('equipment_category_id', 36)->nullable();
            $table->string('name')->nullable();
            $table->string('device_id', 36)->nullable();
            $table->unsignedInteger('maintenance_interval_hours')->nullable();
            $table->json('last_maintenance')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('eamo_equipment')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('equipment_category_id')->references('id')->on('eamo_equipment_categories')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eamo_equipment');
    }
};
