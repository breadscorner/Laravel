<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Live Scores</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600&display=swap" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #000000;
      color: #F1FAEE;
      font-family: 'Digital-7 Mono', sans-serif;
      position: relative;
    }

    header {
      text-align: center;
      padding: 0px;
      top: 0;
      width: 100%
    }

    ul {
      padding: 0px;
    }

    h1 {
      color: #F1FAEE;
      font-family: "Exo 2", sans-serif;
      font-optical-sizing: auto;
      font-style: normal;
      text-transform: uppercase;
      font-size: 3rem;
      color: yellow;
    }

    a {
      display: flex;
      padding-bottom: 10px;
      justify-content: center;
      color: yellow;

      hover {
        color: #A8DADC;
      }
    }

    .main {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
    }

    .teams-container {
      display: flex;
      justify-content: center;
      width: 100%;
    }

    .home-team,
    .away-team {
      flex: 1;
      text-align: right;
    }

    .score {
      font-size: 2rem;
      text-align: center;
      color: white;
      padding: 25px;
    }

    .games {
      list-style-type: none;
      padding: 0;
      display: flex;
      flex-direction: column;
      flex-wrap: wrap;
      justify-content: center;
    }

    .game {
      margin: 0px auto 10px auto;
      /* Top, Right, Bottom, Left */
      padding: 20px;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .no-game {
      text-align: center;
      padding: 20px;
    }

    .team {
      width: auto;
    }

    /* For larger screens, adjust the width of .game to 50% */
    @media (min-width: 768px) {
      .game {
        width: 50%;
        /* Adjust the width for larger screens */
        margin-bottom: 20px;
        /* Specific bottom margin */
      }
    }

    .game h2,
    .game div {
      display: flex;
      justify-content: center;
      align-items: center;
      color: #F1FAEE;
    }

    .tournament-type>h2 {
      color: yellow;
      font-family: "Exo 2", sans-serif;
      text-transform: uppercase;
      font-size: 2rem;
      text-align: center;
    }

    /* Add a bottom border to all .game elements, except the last one */
    .tournament-type>ul>.game:not(:last-child) {
      border-bottom: 1px solid #A8DADC;
    }

    .status {
      margin-bottom: 20px;
    }

    footer {
      text-align: center;
      padding: 10px;
      position: absolute;
      left: 0;
      bottom: 0;
      width: 100%;
      min-height: 100vh;
    }
  </style>
</head>

@extends('layouts.app')

@section('title', 'Home')

@section('content')

<body>
  <header>
    <h1>Live Ice Hockey Scores</h1>
  </header>

  <main>
    <ul class="games" id="games-list">
      @forelse ($groupedGames as $tournamentType => $events)
      <li class="tournament-type">
        <h2>{{ $tournamentType ?? 'Unknown League' }}</h2>
        <ul>
          @foreach ($events as $event)
          <li class="game">
            <div class="teams-container">
              <a href="/game/{{ $event['id'] }}" class="team home-team">{{ $event['homeTeam']['name'] ?? 'Home Team' }}</a>
              <div class="vs">v</div>
              <a href="/game/{{ $event['id'] }}" class="team away-team">{{ $event['awayTeam']['name'] ?? 'Away Team' }}</a>
            </div>
            <div class="score">{{ $event['homeScore']['current'] ?? 'N/A' }} : {{ $event['awayScore']['current'] ?? 'N/A' }}</div>
            <div class="status">{{ $event['status']['description'] ?? 'N/A' }}</div>
          </li>
          @endforeach
        </ul>
      </li>
      @empty
      <li class="no-game">No games available</li>
      @endforelse
    </ul>
  </main>

  <footer>
    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
  </footer>
</body>

</html>

@endsection