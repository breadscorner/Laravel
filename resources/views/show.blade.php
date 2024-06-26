<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel Live Sports</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600&display=swap" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    body {
      background-color: #000000;
      color: #F1FAEE;
      font-family: 'Digital-7 Mono', sans-serif;
    }

    header {
      text-align: center;
      padding: 20px;
      top: 0;
      width: 100%;
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
    }

    a:hover {
      color: #A8DADC;
    }

    .main {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
    }

    .teams-container {
      display: flex;
      justify-content: center;
    }

    .home-team,
    .away-team {
      flex: 1;
      text-align: right;
    }

    .vs {
      margin: 0 10px;
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
      background-color: #1F2833;
      margin: 10px;
      padding: 20px;
      border-radius: 10px;
      border: 1px solid #A8DADC;
      flex: 0 0 calc(50% - 20px);
      /* Two games per row, accounting for margins */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
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
      align-items: center;
      color: #F1FAEE;
    }

    footer {
      position: fixed;
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
      @forelse ($games as $event)
      <li class="game">
        <h2>{{ $event['tournament']['name'] ?? 'Unknown Tournament' }}</h2>
        <div class="teams-container">
          <a href="/game/{{ $event['id'] }}" class="team home-team">{{ $event['homeTeam']['name'] ?? 'Home Team' }}</a>
          <div class="vs">vs.</div>
          <a href="/game/{{ $event['id'] }}" class="team away-team">{{ $event['awayTeam']['name'] ?? 'Away Team' }}</a>
        </div>
        <div class="score">{{ $event['homeScore']['current'] ?? 'N/A' }} : {{ $event['awayScore']['current'] ?? 'N/A' }}</div>
        <div>{{ $event['status']['description'] ?? 'N/A' }}</div>

        <!-- Display home team schedule -->
        <div>
          <h3>{{ $event['homeTeam']['name'] ?? 'Home Team' }} Schedule:</h3>
          <ul>
            @forelse ($apiService->fetchNextMatches($event['homeTeam']['id']) ?? [] as $match)
            <li>{{ $match['homeTeam']['name'] }} vs {{ $match['awayTeam']['name'] }}</li>
            @empty
            <li>No upcoming matches</li>
            @endforelse
          </ul>
        </div>

        <!-- Display away team schedule -->
        <div>
          <h3>{{ $event['awayTeam']['name'] ?? 'Away Team' }} Schedule:</h3>
          <ul>
            @forelse ($apiService->fetchNextMatches($event['awayTeam']['id']) ?? [] as $match)
            <li>{{ $match['homeTeam']['name'] }} vs {{ $match['awayTeam']['name'] }}</li>
            @empty
            <li>No upcoming matches</li>
            @endforelse
          </ul>
        </div>
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