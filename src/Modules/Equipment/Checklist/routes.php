<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Equipment\Checklist\Actions\IndexChecklistDetailAction;
use Modules\Equipment\Checklist\Actions\StoreChecklistDetailAction;
use Modules\Equipment\Checklist\Actions\ShowChecklistDetailAction;
use Modules\Equipment\Checklist\Actions\UpdateChecklistDetailAction;
use Modules\Equipment\Checklist\Actions\DeleteChecklistDetailAction;
use Modules\Equipment\Checklist\Actions\IndexChecklistSessionAction;
use Modules\Equipment\Checklist\Actions\StoreChecklistSessionAction;
use Modules\Equipment\Checklist\Actions\ShowChecklistSessionAction;
use Modules\Equipment\Checklist\Actions\UpdateChecklistSessionAction;
use Modules\Equipment\Checklist\Actions\DeleteChecklistSessionAction;
use Modules\Equipment\Checklist\Actions\JudgeSessionAction;
use Modules\Equipment\Checklist\Actions\ChecklistSchedule\IndexChecklistScheduleAction;
use Modules\Equipment\Checklist\Actions\ChecklistSchedule\StoreChecklistScheduleAction;
use Modules\Equipment\Checklist\Actions\ChecklistSchedule\ShowChecklistScheduleAction;
use Modules\Equipment\Checklist\Actions\ChecklistSchedule\UpdateChecklistScheduleAction;
use Modules\Equipment\Checklist\Actions\ChecklistSchedule\DeleteChecklistScheduleAction;
use Modules\Equipment\Checklist\Actions\ChecklistLog\IndexChecklistLogAction;
use Modules\Equipment\Checklist\Actions\ChecklistLog\StoreChecklistLogAction;
use Modules\Equipment\Checklist\Actions\ChecklistLog\ShowChecklistLogAction;
use Modules\Equipment\Checklist\Actions\ChecklistLog\UpdateChecklistLogAction;
use Modules\Equipment\Checklist\Actions\ChecklistLog\DeleteChecklistLogAction;

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::get('checklist-details', IndexChecklistDetailAction::class);
    Route::post('checklist-details', StoreChecklistDetailAction::class);
    Route::get('checklist-details/{id}', ShowChecklistDetailAction::class);
    Route::put('checklist-details', UpdateChecklistDetailAction::class);
    Route::delete('checklist-details/{id}', DeleteChecklistDetailAction::class);

    Route::get('checklist-sessions', IndexChecklistSessionAction::class);
    Route::post('checklist-sessions', StoreChecklistSessionAction::class);
    Route::get('checklist-sessions/{id}', ShowChecklistSessionAction::class);
    Route::put('checklist-sessions/{id}', UpdateChecklistSessionAction::class);
    Route::delete('checklist-sessions/{id}', DeleteChecklistSessionAction::class);
    Route::post('checklist-sessions/judge', JudgeSessionAction::class);

    Route::get('checklist-schedules', IndexChecklistScheduleAction::class);
    Route::post('checklist-schedules', StoreChecklistScheduleAction::class);
    Route::get('checklist-schedules/{id}', ShowChecklistScheduleAction::class);
    Route::put('checklist-schedules/{id}', UpdateChecklistScheduleAction::class);
    Route::delete('checklist-schedules/{id}', DeleteChecklistScheduleAction::class);

    Route::get('checklist-logs', IndexChecklistLogAction::class);
    Route::post('checklist-logs', StoreChecklistLogAction::class);
    Route::get('checklist-logs/{id}', ShowChecklistLogAction::class);
    Route::put('checklist-logs/{id}', UpdateChecklistLogAction::class);
    Route::delete('checklist-logs/{id}', DeleteChecklistLogAction::class);
});
