<?php

declare(strict_types=1);

namespace Spatie\LaravelPackageTools\Models;

use Illuminate\Database\Eloquent\Model;

class ExtensionRequest extends Model
{
    protected $table = 'eamo_extension_requests';

    protected $fillable = [
        'table_name',
        'columns',
        'migration_file',
        'status',
        'error_message',
        'requested_by',
    ];

    protected $casts = [
        'columns' => 'array',
    ];
}
