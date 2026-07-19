<?php

declare(strict_types=1);

namespace Modules\Equipment\Checklist\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\User\Infrastructure\Models\User;

final class ChecklistLog extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'eamo_checklist_logs';
    protected $fillable = ['checklist_schedule_id', 'user_id', 'result', 'status', 'checked_at'];
    protected $casts = ['checked_at' => 'immutable_datetime'];

    public function checklistSchedule(): BelongsTo { return $this->belongsTo(ChecklistSchedule::class, 'checklist_schedule_id'); }
    public function user(): BelongsTo { return $this->belongsTo(User::class, 'user_id'); }
}
