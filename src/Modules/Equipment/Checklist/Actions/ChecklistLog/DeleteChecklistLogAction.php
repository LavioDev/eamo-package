<?php

declare(strict_types=1);

namespace Modules\Equipment\Checklist\Actions\ChecklistLog;

use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

final class DeleteChecklistLogAction
{
    use AsAction;

    public function asController(string $id): JsonResponse
    {
        return response()->json([]);
    }
}
