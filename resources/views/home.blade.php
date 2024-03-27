<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Live NHL Scores</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600&display=swap" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #000000;
      /* Black */
      color: #F1FAEE;
      /* Light Cream */
      font-family: 'Digital-7 Mono', sans-serif;
    }

    header {
      text-align: center;
      padding: 20px;
      top: 0;
      width: 100%
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
      flex-direction: row;
      flex-wrap: wrap;
      justify-content: space-around;
    }

    .game {
      background-color: #333333;
      /* Dark Grey */
      margin: 10px;
      padding: 20px;
      border-radius: 10px;
      border: 1px solid #A8DADC;
      flex: 0 0 100%;
      /* Default to full width on small screens */
    }

    @media (min-width: 600px) {

      /* Medium screens and up */
      .game {
        flex: 0 0 calc(50% - 20px);
        /* Two games per row, accounting for margins */
      }
    }

    .game h2,
    .game div {
      display: flex;
      justify-content: center;
      color: #F1FAEE;
    }

    footer {
      text-align: center;
      padding: 10px;
      left: 0;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>

<body>
  <header>
    <h1>Live NHL Scores</h1>
  </header>
  <main>
    <ul class="games" id="games-list">
      @forelse ($games['events'] as $event)
      <li class="game">
        <h2>{{ $event['tournament']['name'] ?? 'Unknown Tournament' }}</h2>
        <div>
          <a href="/game/{{ $event['id'] }}"><strong>{{ $event['homeTeam']['name'] ?? 'Home Team' }} </strong> vs. <strong>{{ $event['awayTeam']['name'] ?? 'Away Team' }}</strong></a>
        </div>
        <div class="score">{{ $event['homeScore']['current'] ?? 'N/A' }} : {{ $event['awayScore']['current'] ?? 'N/A' }}</div>
        <div>Status: {{ $event['status']['description'] ?? 'N/A' }}</div>
        <!-- <div>Start Time: {{ date('Y-m-d H:i:s', $event['startTimestamp']) }}</div> -->
      </li>
      @empty
      <li class="game">No games available</li>
      @endforelse
    </ul>
  </main>
  <footer>
    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
  </footer>
</body>

</html>