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
      color: #F1FAEE;
      font-family: 'Digital-7 Mono', sans-serif;
    }

    header {
      text-align: center;
      padding: 10px;
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
      color: #fff;
    }

    tbody tr:nth-child(even) {
      background: linear-gradient(to left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 1%, rgba(0, 0, 0, 0.2) 2%, rgba(0, 0, 0, 0.3) 3%, rgba(0, 0, 0, 0.4) 4%, rgba(0, 0, 0, 0.5) 5%, rgba(0, 0, 0, 0.6) 6%, rgba(0, 0, 0, 0.7) 7%, rgba(0, 0, 0, 0.8) 8%, rgba(0, 0, 0, 0.9) 9%, #0B0C10 10%, #0B0C10 90%, rgba(0, 0, 0, 0.9) 91%, rgba(0, 0, 0, 0.8) 92%, rgba(0, 0, 0, 0.7) 93%, rgba(0, 0, 0, 0.6) 94%, rgba(0, 0, 0, 0.5) 95%, rgba(0, 0, 0, 0.4) 96%, rgba(0, 0, 0, 0.3) 97%, rgba(0, 0, 0, 0.2) 98%, rgba(0, 0, 0, 0.1) 99%, rgba(0, 0, 0, 0) 100%);
    }


    .form-control {
      position: relative;
      margin-right: 0px;
    }

    .form-control input {
      background-color: transparent;
      border: 0;
      border-bottom: 2px #45A29E solid;
      display: block;
      width: 350px;
      padding: 15px 0;
      font-size: 16px;
      color: #fff;
    }

    .form-control input:focus,
    .form-control input:valid {
      outline: 0;
      border-bottom-color: #45A29E;
    }

    .form-control label {
      position: absolute;
      top: 15px;
      left: 0;
      pointer-events: none;
    }

    .form-control label span {
      display: inline-block;
      font-size: 18px;
      min-width: 5px;
      color: #fff;
      transition: 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .form-control input:focus+label span,
    .form-control input:valid+label span {
      color: #45A29E;
      transform: translateY(-30px);
    }

    ƒ .search-container {
      margin-top: 30px;
      margin-bottom: 30px;
      text-align: center;
    }

    .search-button {
      padding: 8px 20px;
      font-size: 1rem;
      border: none;
      border-radius: 5px 5px 5px 0;
      background-color: #45A29E;
      color: white;
      cursor: pointer;
    }

    .search-button:hover {
      background-color: #2d7d7a;
    }

    .search-form {
      display: flex;
      justify-content: center;
      margin-top: 40px;
      margin-bottom: 40px;
    }

    .search-container {
      margin-top: 20px;
      text-align: center;
    }

    .standings {
      margin-top: 0px;
      padding: 10px;
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
      padding: 20px;
    }

    .conference h3 {
      display: flex;
      justify-content: center;
      color: yellow;
      font-size: 1.5rem;
      margin-bottom: 10px;
    }

    footer {
      position: relative;
      text-align: center;
      padding: 10px;
      width: 100%;
      margin-top: auto;
    }
  </style>
</head>

@extends('layouts.app')

@section('title', 'Standings')

@section('content')

<body>
  <header>
    <h1>League Standings</h1>
  </header>

  <main>
    <div class="standings">
      <h2>NHL Standings</h2>

      <div class="search-container">
        <form autocomplete="off" action="{{ route('standings.search') }}" method="GET" class="search-form">
          <div class="form-control">
            <input autocomplete="off" type="text" id="year" name="year" required>
            <label>
              <span style="transition-delay:0ms">S</span>
              <span style="transition-delay:50ms">E</span>
              <span style="transition-delay:100ms">L</span>
              <span style="transition-delay:150ms">E</span>
              <span style="transition-delay:200ms">C</span>
              <span style="transition-delay:250ms">T</span>
              <span style="transition-delay:300ms">&nbsp;</span>
              <span style="transition-delay:350ms">Y</span>
              <span style="transition-delay:400ms">E</span>
              <span style="transition-delay:450ms">A</span>
              <span style="transition-delay:500ms">R</span>
            </label>
          </div>
          <button type="submit" class="search-button"> > </button>
        </form>
      </div>


      <div class="conference-container">
        <!-- Eastern Conference standings -->
        <div class="conference">
          <h3>Eastern Conference</h3>
          <table>
            <thead>
              <tr>
                <th>Team</th>
                <th>Wins</th>
                <th>OT Losses</th>
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
                <td>{{ $row['overtimeLosses'] }}</td>
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
                <th>OT Losses</th>
                <th>Losses</th>
                <th>Points</th>
              </tr>
            </thead>
            <tbody>
              <!-- Loop through standings data for Western Conference -->
              @foreach ($standings['standings'][1]['rows'] as $row)
              @if (in_array($row['team']['name'], array_merge($westernConference['Pacific Division'], $westernConference['Central Division'])))
              <tr>
                <td>{{ $row['team']['name'] }}</td>
                <td>{{ $row['wins'] }}</td>
                <td>{{ $row['overtimeLosses'] }}</td>
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

@endsection