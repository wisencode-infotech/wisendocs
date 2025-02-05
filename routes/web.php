<?php

use Illuminate\Support\Facades\Route;

// Exclude assets folder from routing
Route::get('*/assets/{any}', function () {
    abort(404); // Prevent Laravel from handling static files
})->where('any', '.*')->name('assets');

// Serve backend routes first
Route::prefix('backend')
    ->namespace('App\\Http\\Controllers\\Backend')
    ->group(base_path('routes/backend.php'));

Route::view('/{any}', 'app')->where('any', '.*');