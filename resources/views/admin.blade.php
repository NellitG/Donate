<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Ensure you use Vite -->
</head>
<body>
    <div id="app">
        <nav>
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.events') }}">Events</a></li>
                <li><a href="{{ route('admin.users') }}">Users</a></li>
                <li><a href="{{ route('admin.donors') }}">Donors</a></li>
                <li><a href="{{ route('admin.donations') }}">Donations</a></li>
                <li><a href="{{ route('admin.subscriptions') }}">Subscriptions</a></li>
            </ul>
        </nav>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
