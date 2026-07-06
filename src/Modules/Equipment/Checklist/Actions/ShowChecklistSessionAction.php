<?php

declare(strict_types=1);

namespace Modules\Equipment\Checklist\Actions;

use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Equipment\Checklist\Models\ChecklistSession;
use Throwable;

final class ShowChecklistSessionAction
{

    use AsAction;public function asController(string $id): JsonResponse
     {
        // TODO: Implement custom logic
        return response()->json([]);
    }
}
