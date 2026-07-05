<?php

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Http\Controllers\ExtensionController;

Route::prefix(config('eam.api.prefix', 'eam/api'))
    ->middleware(config('eam.api.middleware', ['api']))
    ->group(function () {
        Route::post('extensions', [ExtensionController::class, 'store']);
        Route::get('extensions/{id}', [ExtensionController::class, 'show']);
    });
