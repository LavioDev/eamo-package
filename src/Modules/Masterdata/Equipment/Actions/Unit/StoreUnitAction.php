<?php

declare(strict_types=1);

namespace Modules\Masterdata\Equipment\Actions\Unit;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

final class StoreUnitAction
{
    use AsAction;

    public function asController(Request $request): JsonResponse
    {
        return response()->json([]);
    }
}
