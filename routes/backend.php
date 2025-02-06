<?php

use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\ManageTopicBlockController;
use App\Http\Controllers\Backend\TopicBlockController;
use App\Http\Controllers\Backend\TopicController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\VersionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Auth::routes();
Auth::routes(['register' => false]);

Route::middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('change-password', [UserController::class, 'changePasswordAdmin'])->name('changepassword');
    Route::post('update-password', [UserController::class, 'updatePasswordAdmin'])->name('updatepassword');

    Route::get('/', [HomeController::class, 'root'])->name('home');

    Route::resource('version', VersionController::class);

    Route::group(['prefix' => 'topic', 'as' => 'topic.'], function () {
        Route::get('/version/{version}', [TopicController::class, 'index'])->name('index'); // Listing route
        Route::get('create', [TopicController::class, 'create'])->name('create'); // Create route
        Route::post('store', [TopicController::class, 'store'])->name('store'); // Store route
        Route::get('edit/{topic}', [TopicController::class, 'edit'])->name('edit'); // Edit route
        Route::put('update/{topic}', [TopicController::class, 'update'])->name('update'); // Update route
        Route::delete('destroy/{topic}', [TopicController::class, 'destroy'])->name('destroy'); // Destroy route
    });

    Route::group(['prefix' => 'manage-topic-block', 'as' => 'manage-topic-block.'], function () {
        Route::get('/{topic}', [ManageTopicBlockController::class, 'index'])->name('index');
        Route::get('create/{topic}', [ManageTopicBlockController::class, 'create'])->name('create');
        Route::get('/{topic}/edit/{topic_block}', [ManageTopicBlockController::class, 'edit'])->name('edit');
    });

    Route::group(['prefix' => 'topic-block', 'as' => 'topic-block.'], function () {
        Route::get('/version/{version}', [TopicBlockController::class, 'index'])->name('index'); // Listing route
        Route::get('create', [TopicBlockController::class, 'create'])->name('create'); // Create route
        Route::post('store', [TopicBlockController::class, 'store'])->name('store'); // Store route
        Route::get('edit/{topic_block}', [TopicBlockController::class, 'edit'])->name('edit'); // Edit route
        Route::put('update/{topic_block}', [TopicBlockController::class, 'update'])->name('update'); // Update route
        Route::delete('destroy/{topic_block}', [TopicBlockController::class, 'destroy'])->name('destroy'); // Destroy route
    });
});


