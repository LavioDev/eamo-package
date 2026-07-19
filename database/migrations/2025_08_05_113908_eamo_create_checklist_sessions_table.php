<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('eamo_checklist_sessions', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('name');
            $table->string('equipment_id', 36);
            $table->dateTime('session_date')->nullable();
            $table->foreignUuid('user_id')->nullable();
            $table->string('cycle_type')->nullable();
            $table->integer('cycle_interval')->nullable();
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')->on('eamo_equipment')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eamo_checklist_sessions');
    }
};
