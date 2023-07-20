<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @yield('load-css')
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}"/>
</head>
<body>
    @include('components.loader')
    @yield('main-content')
    @yield('include-scripts');
</body>

</html>