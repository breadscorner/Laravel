<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use DateTime;
use Illuminate\Support\Facades\Log; // Import the Log facade

class AppServiceProvider extends ServiceProvider
{
  public function boot()
  {
    //
  }

  public function register()
  {
    $this->app->singleton(Client::class, function ($app) {
      return new Client([
        'base_uri' => 'https://allsportsapi2.p.rapidapi.com',
        'headers' => [
          'X-RapidAPI-Host' => 'allsportsapi2.p.rapidapi.com',
          'X-RapidAPI-Key' => '2e0661fcf4mshd92ea5a77f2c19ep1c4802jsnbad996327241',
        ],
      ]);
    });

    $this->app->singleton('App\Services\APIService', function ($app) {
      $client = $app->make(Client::class); // Make sure to use the configured Guzzle client
      return new class($client)
      {
        protected $client;

        public function __construct(Client $client)
        {
          $this->client = $client;
        }

        public function fetchLiveMatches()
        {
          $response = $this->client->request('GET', '/api/ice-hockey/matches/live');
          return json_decode($response->getBody()->getContents(), true);
        }

        public function fetchNextMatches($teamId)
        {
          $response = "/api/ice-hockey/team/{$teamId}/matches/next/{page}";

          // Make a request to fetch the next matches using the constructed URL
          $response = $this->client->request('GET', $response, [
            'headers' => [
              'X-RapidAPI-Host' => 'allsportsapi2.p.rapidapi.com',
              'X-RapidAPI-Key' => '2e0661fcf4mshd92ea5a77f2c19ep1c4802jsnbad996327241',
            ],
          ]);

          return json_decode($response->getBody()->getContents(), true);
        }

        public function fetchLeagueStandings()
        {
          // Fetch the current season ID
          $currentSeasonId = $this->fetchCurrentSeason(234); // Assuming tournament ID is 234
          // Logging to see the currentSeasonId
          Log::info('Current Season ID: ' . $currentSeasonId);
          // Fetch the standings for the current season
          $response = $this->client->request('GET', "/api/ice-hockey/tournament/234/season/{$currentSeasonId}/standings/total", [
            'headers' => [
              'X-RapidAPI-Host' => 'allsportsapi2.p.rapidapi.com',
              'X-RapidAPI-Key' => '2e0661fcf4mshd92ea5a77f2c19ep1c4802jsnbad996327241',
            ],
          ]);
          return json_decode($response->getBody()->getContents(), true);
        }

        public function fetchTeamLogo($teamId)
        {
          // Construct the URL with the team ID dynamically
          $url = "https://allsportsapi2.p.rapidapi.com/api/ice-hockey/team/{$teamId}/image";

          // Create a new Guzzle client
          $client = new Client();

          // Set the required headers
          $headers = [
            'X-RapidAPI-Host' => 'allsportsapi2.p.rapidapi.com',
            'X-RapidAPI-Key' => '2e0661fcf4mshd92ea5a77f2c19ep1c4802jsnbad996327241',
          ];

          // Send the GET request with the headers
          $response = $client->request('GET', $url, ['headers' => $headers]);

          // Assuming the API returns a direct URL to the image
          $logoUrl = (string) $response->getBody();

          return $logoUrl;
        }

        public function fetchCurrentSeason($tournamentId)
        {
          $response = $this->client->request('GET', "/api/ice-hockey/tournament/{$tournamentId}/seasons", [
            'headers' => [
              'X-RapidAPI-Host' => 'allsportsapi2.p.rapidapi.com',
              'X-RapidAPI-Key' => '2e0661fcf4mshd92ea5a77f2c19ep1c4802jsnbad996327241',
            ],
          ]);

          $seasons = json_decode($response->getBody()->getContents(), true)['seasons'];

          // Get the current year
          $currentYear = date('y');

          // Loop through each season to find the current one
          foreach ($seasons as $season) {
            if (strpos($season['year'], $currentYear) !== false) {
              return $season['id'];
            }
          }

          // If no current season is found, return null
          return null;
        }
        public function fetchStandingsByYear($year)
        {
            try {
                // Construct the API endpoint URL with the provided year
                $url = "/api/standings?year={$year}";
        
                // Make a GET request to the API
                $response = $this->client->request('GET', $url);
        
                // Check if the request was successful (status code 200)
                if ($response->getStatusCode() === 200) {
                    // Decode the JSON response
                    $responseData = json_decode($response->getBody()->getContents(), true);
        
                    // Log the response data for debugging
                    Log::info('Standings API Response: ' . json_encode($responseData));
        
                    // Return the decoded response data
                    return $responseData;
                } else {
                    // Log an error if the request was not successful
                    Log::error('Standings API Error: Unexpected status code - ' . $response->getStatusCode());
        
                    // Return null or an empty array as appropriate
                    return [];
                }
            } catch (\Exception $e) {
                // Log any exceptions that occur during the request
                Log::error('Standings API Exception: ' . $e->getMessage());
        
                // Return null or an empty array as appropriate
                return [];
            }
        }
        
      };
    });
  }
}
