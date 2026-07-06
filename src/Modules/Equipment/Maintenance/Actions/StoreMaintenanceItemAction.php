<?php

declare(strict_types=1);

namespace Modules\Equipment\Maintenance\Actions;

use App\Helpers\TranslateHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Equipment\Maintenance\Models\MaintenanceCategory;
use Modules\Equipment\Maintenance\Models\MaintenanceItem;
use Modules\Equipment\Maintenance\Requests\StoreMaintenanceItemRequest;
use Throwable;

final class StoreMaintenanceItemAction
{

    use AsAction;/**
     * @throws Throwable
     */

    public function asController(StoreMaintenanceItemRequest $request): JsonResponse
     {
        // TODO: Implement custom logic
        return response()->json([]);
    }
}
