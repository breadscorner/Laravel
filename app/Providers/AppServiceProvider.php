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
                    'X-RapidAPI-Key' => '44d8ed49afmsh6cce59ece69b346p1b2e22jsnd653d547172b',
                ],
            ]);
        });

        $this->app->singleton('App\Services\APIService', function ($app) {
            $client = $app->make(Client::class); // Make sure to use the configured Guzzle client
            return new class($client) {
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

                public function fetchTeamLogo($teamName)
                {
                    $response = $this->client->request('GET', '/api/placeholder/team.svg', [
                        'headers' => [
                            'X-RapidAPI-Host' => 'allsportsapi2.p.rapidapi.com',
                            'X-RapidAPI-Key' => '2e0661fcf4mshd92ea5a77f2c19ep1c4802jsnbad996327241',
                        ],
                    ]);

                    return $response->getBody();
                }
            };
        });
    }
}
