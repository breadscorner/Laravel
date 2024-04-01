<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/', [ApiController::class, 'index']);

Route::get('/game/{id}', [ApiController::class, 'show']);

Route::get('/standings/search', [ApiController::class, 'search'])->name('standings.search');
