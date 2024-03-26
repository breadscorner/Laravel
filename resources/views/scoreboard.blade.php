<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Live Sports Updates</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #121212;
      color: #fff;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    header {
      text-align: center;
      padding: 20px;
      background-color: #1f1f1f;
    }

    .scoreboard {
      display: flex;
      text-align: center;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    .match-card {
      background: #1f1f1f;
      padding: 20px;
      border-radius: 10px;
      flex-basis: calc(50% - 20px);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .match-card h5 {
      font-size: 18px;
      margin: 0 0 10px;
      color: #4caf50;
    }

    .match-card p {
      margin: 5px 0;
    }

    footer {
      text-align: center;
      margin-top: 50px;
      padding: 20px 0;
      background-color: #1f1f1f;
      color: rgba(255, 255, 255, 0.7);
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>

<body>
  <header>
    <h1>Laravel Sports Scores</h1>
  </header>
  <!-- Map through each game -->
  <div class="container">
    <div class="scoreboard">
      <div class="match-card">
        <h5>Match Title</h5>
        <p>Team A vs. Team B</p>
        <p>Score: 0 - 0</p>
        <p>Time: 00:00</p>
      </div>
    </div>
  </div>

  <footer>
    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
  </footer>
</body>

</html>