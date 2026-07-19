<?php

declare(strict_types=1);

namespace Modules\Equipment\Checklist\Actions\ChecklistLog;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

final class StoreChecklistLogAction
{
    use AsAction;

    public function asController(Request $request): JsonResponse
    {
        return response()->json([]);
    }
}
