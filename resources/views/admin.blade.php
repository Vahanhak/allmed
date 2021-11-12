@if(!isset($_COOKIE['user_role']) || $_COOKIE['user_role'] != 'admin')
    <script>window.location = "/";</script>
@endif
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
        <div class="d-exit"><a href="/logout">Выйти</a></div>
        <h2>Панель Администратора</h2>
        <div>
            <table class="admin-table">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role</th>
                </tr>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->username }}</td>
                        <td>{{ $item->password }}</td>
                        <td>{{ $item->role }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    </body>
</html>
