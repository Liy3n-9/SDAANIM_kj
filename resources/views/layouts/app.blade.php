<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | SDAANIM</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            background: #f4f7f6;
            color: #333;
        }

        a {
            text-decoration: none;
        }

        .admin-header {
            background: @yield('header-bg', 'linear-gradient(90deg,#4a90e2,#007acc)');
            color: white;
            padding: 12px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .admin-header .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-header img {
            height: 45px;
        }

        .admin-header h2 {
            font-family: 'Pacifico', cursive;
            font-size: 1.8em;
            margin: 0;
            color: white;
        }

        .auth-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .auth-info span {
            font-weight: bold;
        }

        .logout-btn {
            background: none;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: 0.3s;
            padding: 0;
            font-size: 1rem;
        }

        .logout-btn:hover {
            border-bottom: 2px solid white;
        }

        main {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
            min-height: 80vh;
        }

        footer {
            background: @yield('footer-bg', '#007acc');
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
            font-size: 0.9em;
        }
    </style>
    @yield('styles')
</head>

<body>
    <header class="admin-header">
        <div class="logo">
            <img src="{{ asset('img/a.png') }}" alt="Logo">
            <h2>@yield('panel-title', 'SDAANIM')</h2>
        </div>
        <div class="auth-info">
            @auth
            <span>{{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">Cerrar sesión</button>
            </form>
            @else
            <a href="{{ route('login') }}">Iniciar sesión</a>
            @endauth
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>© 2025 Esperanza Animal BQ | @yield('footer-text', 'SDAANIM')</p>
    </footer>
</body>

</html>