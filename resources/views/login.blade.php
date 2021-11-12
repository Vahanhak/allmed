<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AlmaMed</title>
        <link rel="stylesheet" type="text/css" href="/css/app.css">
    </head>
    <body>
    @include('metrika')
    <div class="container">
        <div class="d-top">AlmaMed</div>
        <div class="d-exit"></div>
        <h2>Авторизация</h2>
        @if (session('status'))
            <h6 class="alert-error">{{ session('status') }}</h6>
        @endif
        <form action="/login" method="post">
            @csrf
            <div class="login-form">
                <input type="text" name="username" id="username" placeholder="Username">
                <input type="password" name="password" id="password" placeholder="Password">
                <input type="submit" name="submit" value="Вход">
            </div>
        </form>
    </div>
    </body>
</html>
