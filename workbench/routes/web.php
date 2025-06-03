<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Workbench\App\Http\Controllers\UserController;

Route::get('/', fn () => inertia('Home'))
    ->name('home.show');

Route::middleware('nav:primary')
    ->group(function () {
        Route::get('/contact', fn () => inertia('Contact'))
            ->name('contact.show');

        Route::middleware('nav:users')
            ->get('/about', fn () => inertia('About'))
            ->name('about.show');
    });

Route::middleware('nav:primary,users')
    ->resource('users', UserController::class);
