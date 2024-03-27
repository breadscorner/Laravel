<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController
{
    public function index()
    {
        // Resolve the APIService using the Laravel application's service container
        $apiService = resolve('App\Services\APIService');

        $games = $apiService->fetchLiveMatches();

        return view('home', compact('games'));
    }
    public function show(Request $request, $id)
    {
        // Resolve the APIService using the Laravel application's service container
        $apiService = resolve('App\Services\APIService');

        $games = $apiService->fetchLiveMatches();

        $games = array_filter($games['events'], function ($event) use ($id) {
          return $event['id'] == (int) $id;
        });

        return view('show', compact('games'));
    }
}

// 11384172