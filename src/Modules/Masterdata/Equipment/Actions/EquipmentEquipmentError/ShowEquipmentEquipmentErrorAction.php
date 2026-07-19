<?php

declare(strict_types=1);

namespace Modules\Masterdata\Equipment\Actions\EquipmentEquipmentError;

use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

final class ShowEquipmentEquipmentErrorAction
{
    use AsAction;

    public function asController(string $id): JsonResponse
    {
        return response()->json([]);
    }
}
