<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sports Scores Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        header {
            text-align: center;
            padding: 20px;
            background-color: #1f1f1f;
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
        main {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul.sports, ul.games {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-bottom: 20px;
        }
        li.sport, li.game {
            background: #1f1f1f;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
            flex-basis: calc(33.333% - 20px);
            text-align: center;
        }
        li.sport:hover, li.game:hover {
            background-color: #303030;
        }
        li.game {
            background-color: #2a2a2a; /* Slightly different background for games */
        }
    </style>
</head>
<body>
    <header>
        <h1>Sports Scores Dashboard</h1>
    </header>
    <main>
        <ul class="sports">

        </ul>
        <ul class="games" id="games-list">
            <!-- Games will be populated here based on the selected sport -->
        </ul>
    </main>
    <footer>
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>
    
    <script>
        function showGames(gamesJson) {
            // Parse the JSON-encoded games and populate the list
            const games = JSON.parse(gamesJson.replace(/&quot;/g, "\""));
            const gamesList = document.getElementById('games-list');
            gamesList.innerHTML = ''; // Clear the current list of games
            games.forEach(function(game) {
                const li = document.createElement('li');
                li.className = 'game';
                li.innerHTML = game.teamA + ' vs ' + game.teamB + ' - <strong>' + game.scoreA + ':' + game.scoreB + '</strong>';
                gamesList.appendChild(li);
            });
        }
    </script>
</body>
</html>