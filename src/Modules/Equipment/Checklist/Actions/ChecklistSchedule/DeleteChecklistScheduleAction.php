<?php

declare(strict_types=1);

namespace Modules\Equipment\Checklist\Actions\ChecklistSchedule;

use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

final class DeleteChecklistScheduleAction
{
    use AsAction;

    public function asController(string $id): JsonResponse
    {
        return response()->json([]);
    }
}
