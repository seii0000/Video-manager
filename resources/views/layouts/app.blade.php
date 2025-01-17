<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Video Dashboard</a>
        <div class="navbar-nav ml-auto">
            @auth
                <span class="nav-item nav-link">Welcome, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="nav-item">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link">Logout</button>
                </form>
            @else
                <a class="nav-item nav-link" href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>