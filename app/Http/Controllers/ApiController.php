<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController
{
  public function index()
  {
    // Resolve the APIService using the Laravel application's service container
    $apiService = resolve('App\Services\APIService');

    // Fetch live matches from the API service
    $games = $apiService->fetchLiveMatches();

    // Convert the events array to a Collection to use the groupBy method
    // Make sure 'events' exists and is an array to avoid any errors
    $eventsCollection = collect($games['events'] ?? []);

    // Now you can use the groupBy method since you have a Collection
    $groupedGames = $eventsCollection->groupBy(function ($item) {
      // Attempt to access 'tournament.type', but provide a default value to avoid errors
      return $item['tournament']['name'] ?? 'Unknown';
    });

    // Return the view with the fetched live matches, standings data, and conference/division arrays
    return view('home', compact('games', 'groupedGames'));
  }

  public function Standings()
  {
    // Resolve the APIService using the Laravel application's service container
    $apiService = resolve('App\Services\APIService');

    // Fetch league standings from the API service
    $standings = $apiService->fetchLeagueStandings();

    // Define Eastern and Western conference teams by division
    $easternConference = [
      'Atlantic Division' => [
        'Boston Bruins', 'Buffalo Sabres', 'Detroit Red Wings', 'Florida Panthers', 'Montreal Canadiens', 'Ottawa Senators', 'Tampa Bay Lightning', 'Toronto Maple Leafs'
      ],
      'Metropolitan Division' => [
        'Carolina Hurricanes', 'Columbus Blue Jackets', 'New Jersey Devils', 'New York Islanders', 'New York Rangers', 'Philadelphia Flyers', 'Pittsburgh Penguins', 'Washington Capitals'
      ]
    ];

    $westernConference = [
      'Pacific Division' => [
        'Anaheim Ducks', 'Calgary Flames', 'Edmonton Oilers', 'Los Angeles Kings', 'San Jose Sharks', 'Seattle Kraken', 'Vancouver Canucks', 'Vegas Golden Knights'
      ],
      'Central Division' => [
        'Arizona Coyotes', 'Chicago Blackhawks', 'Colorado Avalanche', 'Dallas Stars', 'Minnesota Wild', 'Nashville Predators', 'St. Louis Blues', 'Winnipeg Jets'
      ]
    ];

    // Return the view with the fetched standings data and conference/division arrays
    return view('standings', compact('standings', 'easternConference', 'westernConference'));
  }

  public function show(Request $request, $id)
  {
    // Resolve the APIService using the Laravel application's service container
    $apiService = resolve('App\Services\APIService');

    $games = $apiService->fetchLiveMatches();

    $games = array_filter($games['events'], function ($event) use ($id) {
      return $event['id'] == (int) $id;
    });

    return view('show', compact('games', 'apiService'));
  }

  public function search(Request $request)
  {
    // Resolve the APIService using the Laravel application's service container
    $apiService = resolve('App\Services\APIService');

    $year = $request->input('year');

    // Fetch standings data for the entered year
    $standings = $apiService->fetchStandingsByYear($year);

    // Return the fetched standings data as JSON response
    return response()->json(['standings' => $standings]);
  }
}
