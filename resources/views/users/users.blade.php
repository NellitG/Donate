<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>All Users</h1>
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->username }} - Role: {{ $user->role }}</li>
        @endforeach
    </ul>
</body>
</html>
