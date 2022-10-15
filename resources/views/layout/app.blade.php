<!DOCTYPE html>
<html>

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8FBGKW5FFX"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-8FBGKW5FFX');
    </script>
    
    <meta charset='utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <meta property="og:type" content="website" />
    <meta property="og:title" content="じゅんちゃんねる" />
    <meta property="og:url" content="https://junchannel.herokuapp.com/" />
    <meta property="og:site_name" content="JunChannel" />
    <meta property="og:locale" content="ja_JP" />
    <meta
      property="og:description"
      name="description"
      content="じゅんちゃんねるは某有名掲示板を真似た匿名掲示板です。スレッドでのコメントを通じて趣味が合う者同士（雑談でも何でもOK）の楽しい交流の場としてご利用ください。"
    />
    <meta property="og:image" content="https://junchannel.herokuapp.com/favicon.ico" />

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
