<?php

declare(strict_types=1);

namespace Spatie\LaravelPackageTools\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Spatie\LaravelPackageTools\Extensions\ColumnDefinition;
use Spatie\LaravelPackageTools\Migration\MigrationGenerator;
use Spatie\LaravelPackageTools\Models\ExtensionRequest;

class GenerateExtensionMigrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Set max tries to 1. Schema migration operations should not retry on failure.
     */
    public int $tries = 1;

    /**
     * Timeout after 120 seconds.
     */
    public int $timeout = 120;

    public function __construct(
        private readonly ExtensionRequest $extensionRequest,
    ) {
    }

    public function handle(MigrationGenerator $generator): void
    {
        $this->extensionRequest->update(['status' => 'processing']);

        try {
            // Rebuild ColumnDefinition objects from DB json data
            $columns = array_map(
                fn (array $col) => new ColumnDefinition(
                    name:     $col['name'],
                    type:     $col['type'],
                    nullable: $col['nullable'] ?? true,
                    default:  $col['default']  ?? null,
                    length:   $col['length']   ?? null,
                    after:    $col['after']    ?? null,
                    unsigned: $col['unsigned'] ?? false,
                ),
                $this->extensionRequest->columns
            );

            // Generate physical migration file
            $filePath = $generator->generate(
                $this->extensionRequest->table_name,
                $columns
            );

            // Force run migrations
            Artisan::call('migrate', ['--force' => true]);

            $this->extensionRequest->update([
                'status'         => 'done',
                'migration_file' => basename($filePath),
            ]);

        } catch (\Throwable $e) {
            $this->extensionRequest->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
