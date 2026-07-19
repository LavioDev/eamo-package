<?php

declare(strict_types=1);

namespace Modules\Equipment\Checklist\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\User\Infrastructure\Models\User;
use Modules\Masterdata\Equipment\Models\Equipment;

final class ChecklistSchedule extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'eamo_checklist_schedules';
    protected $fillable = ['equipment_id', 'checklist_session_id', 'checklist_detail_id', 'user_id', 'date', 'is_rescheduled', 'original_date'];
    protected $casts = ['date' => 'date', 'original_date' => 'date', 'is_rescheduled' => 'boolean'];

    public function equipment(): BelongsTo { return $this->belongsTo(Equipment::class, 'equipment_id'); }
    public function checklistSession(): BelongsTo { return $this->belongsTo(ChecklistSession::class, 'checklist_session_id'); }
    public function checklistDetail(): BelongsTo { return $this->belongsTo(ChecklistDetail::class, 'checklist_detail_id'); }
    public function user(): BelongsTo { return $this->belongsTo(User::class, 'user_id'); }
    public function logs(): HasMany { return $this->hasMany(ChecklistLog::class, 'checklist_schedule_id'); }
}
