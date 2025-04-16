@if (Auth::check())
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('logout') }}">Logout</a>
@else
    <a href="{{ route('login') }}">Login</a>
@endif