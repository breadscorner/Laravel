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
      background-color: #1F2833;
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
      align-items: center;
      /* Center align items vertically */
      color: #F1FAEE;
    }

    .team-logo {
      width: 30px;
      /* Adjust the width of the logo */
      height: auto;
      /* Maintain aspect ratio */
      margin-right: 10px;
      /* Add some spacing between the logo and team name */
    }

    .standings {
      margin-top: 30px;
      padding: 20px;
      border-radius: 10px;
    }

    .standings h2 {
      display: flex;
      justify-content: center;
      color: yellow;
      font-size: 2rem;
      margin-bottom: 20px;
    }

    .conference-container {
      display: flex;
      justify-content: space-around;
    }

    .conference {
      flex: 0 0 45%;
      background-color: #1F2833;
      border-radius: 10px;
      border: 1px solid #A8DADC;
      padding: 20px;
    }

    .conference h3 {
      display: flex;
      justify-content: center;
      color: yellow;
      font-size: 1.5rem;
      margin-bottom: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 8px;
      text-align: center;
      border-bottom: 1px solid #fff;
    }

    th {
      background-color: #45A29E;
      color: #fff;
    }

    td {
      background-color: #1F2833;
      color: #fff;
    }

    tbody tr:nth-child(even) {
      background-color: #0B0C10;
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
          <a href="/game/{{ $event['id'] }}">
            <img src="{{ $apiService->fetchTeamLogo($event['homeTeam']['id']) }}" alt="{{ $event['homeTeam']['name'] }} Logo" class="team-logo">
            <strong>{{ $event['homeTeam']['name'] ?? 'Home Team' }}</strong>
          </a>
          vs.
          <a href="/game/{{ $event['id'] }}">
            <img src="{{ $apiService->fetchTeamLogo($event['awayTeam']['id']) }}" alt="{{ $event['awayTeam']['name'] }} Logo" class="team-logo">
            <strong>{{ $event['awayTeam']['name'] ?? 'Away Team' }}</strong>
          </a>
        </div>
        <div class="score">{{ $event['homeScore']['current'] ?? 'N/A' }} : {{ $event['awayScore']['current'] ?? 'N/A' }}</div>
        <div>Status: {{ $event['status']['description'] ?? 'N/A' }}</div>
      </li>
      @empty
      <li class="game">No games available</li>
      @endforelse
    </ul>

    <div class="standings">
      <h2>League Standings</h2>
      <div class="conference-container">
        <!-- Eastern Conference standings -->
        <div class="conference">
          <h3>Eastern Conference</h3>
          <table>
            <thead>
              <tr>
                <th>Team</th>
                <th>Wins</th>
                <th>Losses</th>
                <th>Points</th>
              </tr>
            </thead>
            <tbody>
              <!-- Loop through standings data for Eastern Conference -->
              @foreach ($standings['standings'][0]['rows'] as $row)
              @if (in_array($row['team']['name'], array_merge($easternConference['Atlantic Division'], $easternConference['Metropolitan Division'])))
              <tr>
                <td>{{ $row['team']['name'] }}</td>
                <td>{{ $row['wins'] }}</td>
                <td>{{ $row['losses'] }}</td>
                <td>{{ $row['points'] }}</td>
              </tr>
              @endif
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Western Conference standings -->
        <div class="conference">
          <h3>Western Conference</h3>
          <table>
            <thead>
              <tr>
                <th>Team</th>
                <th>Wins</th>
                <th>Losses</th>
                <th>Points</th>
              </tr>
            </thead>
            <tbody>
              <!-- Loop through standings data for Western Conference -->
              @foreach ($standings['standings'][0]['rows'] as $row)
              @if (in_array($row['team']['name'], array_merge($westernConference['Pacific Division'], $westernConference['Central Division'])))
              <tr>
                <td>{{ $row['team']['name'] }}</td>
                <td>{{ $row['wins'] }}</td>
                <td>{{ $row['losses'] }}</td>
                <td>{{ $row['points'] }}</td>
              </tr>
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>


  </main>
  <footer>
    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
  </footer>
</body>

</html>