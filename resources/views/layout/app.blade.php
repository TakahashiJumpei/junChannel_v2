<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    @yield('header')
    <div class="flex-center position-ref full-height container">
        <div class="row justify-content-center">
            @yield('categories_list')
            @yield('content')
        </div>
    </div>
    @yield('footer')
</body>

<style>
    .container {
        min-height: calc(100vh - 265px);
    }
</style>


</html>
