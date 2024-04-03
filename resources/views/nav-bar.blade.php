<style>
    .nav-menu {
        list-style-type: none; /* Remove bullet points */
        padding: 10px; /* Add padding */
        margin: 0; /* Remove default margin */
        display: flex; /* Display items inline */
        align-items: center; /* Center items vertically */
        justify-content: center; /* Center items horizontally */
        background-color: black; /* Set background color */
        position: sticky; /* Make it sticky to the top */
        top: 0; /* Stick to the top of the viewport */
        z-index: 1000; /* Ensure it appears above other content */
        width: 100%; /* Take up full width */
    }
    .nav-item {
        margin-right: 20px; /* Add some space between the items */
    }
    .nav-link {
        text-decoration: none; /* Optional: Removes the underline from links */
        color: white; /* Set default text color to white */
    }
    .active {
        font-weight: bold; /* Optional: Highlight the active link */
        color: yellow; /* Change color of active link */
    }
</style>

<ul class="nav-menu">
    <li class="nav-item">
        <a class="nav-link @if(Route::currentRouteName() == 'home') active @endif" href="{{ route('home') }}">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Route::currentRouteName() == 'standings') active @endif" href="{{ route('standings') }}">Standings</a>
    </li>
</ul>
