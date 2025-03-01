<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SET CUSTOM TITLE - POSTS SITE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="container">
<div style="display: none" class="page row">

    @if(Auth::check())
        <div class="sideoptions">
            <form class="sideoptions__form" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">
                    Logout
                </button>
            </form>
            <a href="{{ route("posts.index") }}" class="sideoptions__link btn btn-primary">
                Posts
            </a>
        </div>
    @endif
    @yield("content")
</div>

<x-common.preloader></x-common.preloader>

</body>
</html>
