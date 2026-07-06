<?php

declare(strict_types=1);

namespace Modules\Equipment\Maintenance\Actions;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Equipment\Maintenance\Models\EquipmentErrorLog; 
use Modules\Manufacturing\Lot\Infrastructure\Models\LotHistory;
final class IndexStockOeeChartAction
{

    use AsAction;public function asController(Request $request): JsonResponse
     {
        // TODO: Implement custom logic
        return response()->json([]);
    }
}
