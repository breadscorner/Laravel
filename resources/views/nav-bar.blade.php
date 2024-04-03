<li class="nav-item">
    <a class="nav-link @if(Route::currentRouteName() == 'home') active @endif" href="{{ route('home') }}">Home</a>
</li>

<li class="nav-item">
    <a class="nav-link @if(Route::currentRouteName() == 'standings') active @endif" href="{{ route('standings') }}">Standings</a>
</li>