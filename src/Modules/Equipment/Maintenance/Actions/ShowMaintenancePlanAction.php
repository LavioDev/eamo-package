<?php

declare(strict_types=1);

namespace Modules\Equipment\Maintenance\Actions;

use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Equipment\Maintenance\Models\MaintenancePlan;
use Throwable;

final class ShowMaintenancePlanAction
{

    use AsAction;public function asController(string $id): JsonResponse
     {
        // TODO: Implement custom logic
        return response()->json([]);
    }
}
