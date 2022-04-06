<?php

use Illuminate\Support\Facades\Route;
use Vittozich\Modulara\Modular\Modules\Controllers\TemplateController;

Route::prefix('modulara/template')->group(function () {
    Route::get('/test', [TemplateController::class, 'test']);
});
