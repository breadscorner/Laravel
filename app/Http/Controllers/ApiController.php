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

    // Fetch league standings from the API service
    $standings = $apiService->fetchLeagueStandings();

    // Fetch team logos
    $teamLogos = $apiService->fetchTeamLogos();

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

    // Return the view with the fetched live matches, standings data, and conference/division arrays
    return view('home', compact('games', 'standings', 'easternConference', 'westernConference'));
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
}
