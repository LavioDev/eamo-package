<?php

declare(strict_types=1);

namespace Modules\Masterdata\Equipment\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class EquipmentParameter
 *
 * @property string $id
 * @property string $equipment_id
 * @property string|null $unit_id
 * @property string $code
 * @property float|null $standard
 * @property float|null $standard_max
 * @property float|null $standard_min
 * @property-read Equipment $equipment
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 */
final class EquipmentParameter extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $fillable = [
        'equipment_id',
        'unit_id',
        'code',
        'standard',
        'standard_max',
        'standard_min',
    ];

    protected $keyType = 'string';

    protected $table = 'eamo_equipment_parameters';

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function equipmentCategory(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class, 'equipment_category_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function parameterLogs(): HasMany
    {
        return $this->hasMany(\Modules\Equipment\ParameterLog\Models\EquipmentParameterLog::class, 'equipment_parameter_id');
    }

    protected function casts(): array
    {
        return [
            'standard' => 'float',
            'standard_max' => 'float',
            'standard_min' => 'float',
        ];
    }
}

