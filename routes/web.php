<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/', [ApiController::class, 'index'])->name('home');

Route::get('/game/{id}', [ApiController::class, 'show']);

Route::get('/standings', [ApiController::class, 'standings'])->name('standings');

Route::get('/standings/search', [ApiController::class, 'search'])->name('standings.search');
