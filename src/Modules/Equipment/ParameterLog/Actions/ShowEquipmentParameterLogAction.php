<?php

declare(strict_types=1);

namespace Modules\Equipment\ParameterLog\Actions;

use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Equipment\ParameterLog\Models\EquipmentParameterLog;
use Throwable;

final class ShowEquipmentParameterLogAction
{

    use AsAction;public function asController(string $id): JsonResponse
     {
        // TODO: Implement custom logic
        return response()->json([]);
    }
}
