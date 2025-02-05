<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\VersionController;

Route::group(['prefix' => 'version/{version}', 'as' => 'version.'], function() {
    Route::group(['prefix' => '/topics', 'as' => 'topics.'], function() {
        Route::get('/all', [TopicController::class, 'index']);
        Route::get('/{slug}', [TopicController::class, 'getTopicBlocks']);
    });

    Route::get('search', [SearchController::class, 'search']);
});

Route::get('/versions', [VersionController::class, 'index']);
