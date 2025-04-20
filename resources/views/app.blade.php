<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
   
    <title>@yield('title', $title)</title>
</head>

<body>

    <div class="container">
        <h1>@yield('title', $title)</h1>
        @yield('content')
    </div>
    <script src="{{ asset('js/background.js') }}"></script>

</body>

</html>