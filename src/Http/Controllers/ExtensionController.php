<?php

declare(strict_types=1);

namespace Spatie\LaravelPackageTools\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Spatie\LaravelPackageTools\Extensions\ColumnDefinition;
use Spatie\LaravelPackageTools\Extensions\ExtensionRegistry;
use Spatie\LaravelPackageTools\Extensions\ExtensionValidator;
use Spatie\LaravelPackageTools\Http\Requests\StoreExtensionRequest;
use Spatie\LaravelPackageTools\Jobs\GenerateExtensionMigrationJob;
use Spatie\LaravelPackageTools\Migration\MigrationFileChecker;
use Spatie\LaravelPackageTools\Models\ExtensionRequest;

class ExtensionController extends Controller
{
    public function __construct(
        private readonly ExtensionValidator   $validator,
        private readonly MigrationFileChecker $checker,
    ) {
    }

    /**
     * POST /eam/api/extensions
     */
    public function store(StoreExtensionRequest $request): JsonResponse
    {
        $table   = $request->input('table');
        $rawCols = $request->input('columns');

        // Validate table whitelist
        try {
            ExtensionRegistry::validateTable($table);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        // Map array to ColumnDefinition objects
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
            $rawCols
        );

        // Validate column definitions
        try {
            $this->validator->validate($table, $columns);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        // Filter already existing/migrated columns
        $newColumns = $this->checker->filterNewColumns($table, $columns);

        if (empty($newColumns)) {
            return response()->json([
                'message' => 'All specified columns already exist. Nothing to do.',
            ], 200);
        }

        // Log extension request
        $extensionRequest = ExtensionRequest::create([
            'table_name' => $table,
            'columns'    => array_map(
                fn (ColumnDefinition $c) => [
                    'name'     => $c->name,
                    'type'     => $c->type,
                    'nullable' => $c->nullable,
                    'default'  => $c->default,
                    'length'   => $c->length,
                    'after'    => $c->after,
                    'unsigned' => $c->unsigned,
                ],
                $newColumns
            ),
            'status'       => 'queued',
            'requested_by' => $request->ip(),
        ]);

        // Dispatch background job
        $queueName = config('eam.queue.name', 'eam-extensions');
        $connection = config('eam.queue.connection', config('queue.default', 'sync'));

        GenerateExtensionMigrationJob::dispatch($extensionRequest)
            ->onConnection($connection)
            ->onQueue($queueName);

        return response()->json([
            'message'   => 'Extension request queued successfully.',
            'id'        => $extensionRequest->id,
            'status'    => 'queued',
            'table'     => $table,
            'columns'   => array_map(fn ($c) => $c->name, $newColumns),
            'check_url' => url("/eam/api/extensions/{$extensionRequest->id}"),
        ], 202);
    }

    /**
     * GET /eam/api/extensions/{id}
     */
    public function show(int $id): JsonResponse
    {
        $request = ExtensionRequest::findOrFail($id);

        return response()->json([
            'id'             => $request->id,
            'table'          => $request->table_name,
            'status'         => $request->status,
            'migration_file' => $request->migration_file,
            'error_message'  => $request->error_message,
            'created_at'     => $request->created_at,
            'updated_at'     => $request->updated_at,
        ]);
    }
}
