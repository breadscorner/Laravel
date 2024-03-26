<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/scoreboard', function () {
    return view('scoreboard');
});

