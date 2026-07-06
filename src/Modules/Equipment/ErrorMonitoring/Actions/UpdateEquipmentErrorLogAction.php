<?php

declare(strict_types=1);

namespace Modules\Equipment\ErrorMonitoring\Actions;

use App\Helpers\TranslateHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Equipment\ErrorMonitoring\Models\EquipmentErrorLog;
use Modules\Equipment\ErrorMonitoring\Requests\UpdateEquipmentErrorLogRequest;
use Throwable;
use Modules\Equipment\ErrorMonitoring\Domain\Events\Resources\EquipmentErrorLogUpdated;

final class UpdateEquipmentErrorLogAction
{

    use AsAction;/**
     * @throws Throwable
     */

    public function asController(string $id, UpdateEquipmentErrorLogRequest $request): JsonResponse
     {
        // TODO: Implement custom logic
        return response()->json([]);
    }
}
