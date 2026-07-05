<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('eam_extension_requests', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->json('columns');
            $table->string('migration_file')->nullable();
            $table->enum('status', [
                'queued',
                'processing',
                'done',
                'failed',
            ])->default('queued');
            $table->text('error_message')->nullable();
            $table->string('requested_by')->nullable();
            $table->timestamps();

            $table->index(['table_name', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eam_extension_requests');
    }
};
