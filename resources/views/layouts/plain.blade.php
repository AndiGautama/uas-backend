<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Aplikasi')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- atau sesuaikan --}}
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>