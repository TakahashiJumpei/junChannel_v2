<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8' />
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
