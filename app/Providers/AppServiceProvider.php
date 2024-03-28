<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

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
          $response = $this->client->request('GET', 'https://allsportsapi2.p.rapidapi.com/api/ice-hockey/tournament/234/season/42681/standings/total', [
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
        
      };
    });
  }
}
