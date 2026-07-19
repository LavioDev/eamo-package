<?php

declare(strict_types=1);

namespace Modules\Masterdata\Equipment\Actions\Unit;

use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

final class DeleteUnitAction
{
    use AsAction;

    public function asController(string $id): JsonResponse
    {
        return response()->json([]);
    }
}
