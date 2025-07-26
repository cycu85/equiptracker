<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Tools\Controllers\ToolController;

Route::middleware(['auth', 'module:Tools'])->group(function () {
    Route::resource('tools', ToolController::class);
});