<?php

declare(strict_types=1);

namespace Modules\Masterdata\Equipment\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Unit extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'eamo_units';
    protected $fillable = ['name', 'code', 'description'];

    public function equipmentParameters(): HasMany
    {
        return $this->hasMany(EquipmentParameter::class, 'unit_id');
    }

    public function parameterLogs(): HasMany
    {
        return $this->hasMany(\Modules\Equipment\ParameterLog\Models\EquipmentParameterLog::class, 'unit_id');
    }
}
