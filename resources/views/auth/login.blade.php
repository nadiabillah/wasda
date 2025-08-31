<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Sidoarjo">
        </div>
        <div class="login-form">
            <h2>Login</h2>
            @if ($errors->has('login'))
                <div class="alert-danger">
                    {{ $errors->first('login') }}
                </div>
            @endif
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input type="text" name="username" placeholder="Username" required autofocus value="{{ old('username') }}">
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>