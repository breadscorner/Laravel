<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel Live Sports</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600&display=swap" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    /* Your existing CSS */
  </style>
</head>

<body>
  <header>
    <h1>Laravel Live Sports</h1>
  </header>
  <main>
  <ul class="games" id="games-list">
      @forelse ($games as $event)
        <li class="game">
          <h2>{{ $event['tournament']['name'] ?? 'Unknown Tournament' }}</h2>
          <div>
            <strong>{{ $event['homeTeam']['name'] ?? 'Home Team' }}</strong> vs. <strong>{{ $event['awayTeam']['name'] ?? 'Away Team' }}</strong>
          </div>
          <div>Home Score: {{ $event['homeScore']['current'] ?? 'N/A' }}</div>
          <div>Away Score: {{ $event['awayScore']['current'] ?? 'N/A' }}</div>
          <div>Status: {{ $event['status']['description'] ?? 'N/A' }}</div>
          <div>Start Time: {{ date('Y-m-d H:i:s', $event['startTimestamp']) }}</div>
          <div>{{ $event['id'] }}</div>
        </li>
      @empty
        <li class="game">No games available</li>
      @endforelse
    </ul>
  </main>
  <?php var_dump($games); ?>
  <footer>
    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
  </footer>
</body>

</html>
