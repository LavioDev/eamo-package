<?php

declare(strict_types=1);

namespace Spatie\LaravelPackageTools\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelPackageTools\Extensions\ColumnDefinition;

class StoreExtensionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'table'                => ['required', 'string'],
            'columns'              => ['required', 'array', 'min:1'],
            'columns.*.name'       => ['required', 'string', 'regex:/^[a-z][a-z0-9_]*$/'],
            'columns.*.type'       => ['required', 'string', 'in:' . implode(',', ColumnDefinition::SUPPORTED_TYPES)],
            'columns.*.nullable'   => ['sometimes', 'boolean'],
            'columns.*.default'    => ['sometimes', 'nullable'],
            'columns.*.length'     => ['sometimes', 'nullable', 'integer', 'min:1'],
            'columns.*.after'      => ['sometimes', 'nullable', 'string'],
            'columns.*.unsigned'   => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'columns.*.name.regex' => 'Column name must start with a letter and contain only lowercase letters, digits, and underscores.',
            'columns.*.type.in'    => 'Column type is not supported. Supported: ' . implode(', ', ColumnDefinition::SUPPORTED_TYPES),
        ];
    }
}
