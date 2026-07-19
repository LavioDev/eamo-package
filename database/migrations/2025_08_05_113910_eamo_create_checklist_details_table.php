<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('eamo_checklist_details', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('checklist_id', 36);
            $table->string('session_id', 36);

            $table->string('description')->nullable();
            // $table->json('image_ids')->nullable();
            $table->timestamps();

            $table->foreign('session_id')
                ->references('id')
                ->on('eamo_checklist_sessions')
                ->cascadeOnDelete();
        });

        Schema::create('eamo_checklist_schedules', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('equipment_id', 36);
            $table->string('checklist_session_id', 36);
            $table->string('checklist_detail_id', 36);
            $table->foreignUuid('user_id')->nullable();
            $table->date('date');
            $table->boolean('is_rescheduled')->default(false);
            $table->date('original_date')->nullable();
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')->on('eamo_equipment')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('checklist_session_id')->references('id')->on('eamo_checklist_sessions')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('checklist_detail_id')->references('id')->on('eamo_checklist_details')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });

        Schema::create('eamo_checklist_logs', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('checklist_schedule_id', 36);
            $table->foreignUuid('user_id')->nullable();
            $table->enum('result', ['pass', 'fail'])->default('fail')->nullable();
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();

            $table->foreign('checklist_schedule_id')->references('id')->on('eamo_checklist_schedules')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eamo_checklist_logs');
        Schema::dropIfExists('eamo_checklist_schedules');
        Schema::dropIfExists('eamo_checklist_details');
    }
};
