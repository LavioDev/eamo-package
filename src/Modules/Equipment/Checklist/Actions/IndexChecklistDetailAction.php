<?php

declare(strict_types=1);

namespace Modules\Equipment\Checklist\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Equipment\Checklist\Models\ChecklistDetail;
use Throwable;

final class IndexChecklistDetailAction
{

    use AsAction;public function asController(Request $request): JsonResponse
     {
        // TODO: Implement custom logic
        return response()->json([]);
    }
}
