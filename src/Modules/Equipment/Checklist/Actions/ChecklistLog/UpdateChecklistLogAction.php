<?php

declare(strict_types=1);

namespace Modules\Equipment\Checklist\Actions\ChecklistLog;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

final class UpdateChecklistLogAction
{
    use AsAction;

    public function asController(string $id, Request $request): JsonResponse
    {
        return response()->json([]);
    }
}
