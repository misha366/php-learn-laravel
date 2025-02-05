<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} - POSTS SITE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset("build/assets/app-CfotbXjl.css") }}">
</head>
<body class="container bg-body-secondary pb-3">

    <div class="row">
        <nav>

            <ul>
                <li><a href="{{ route("main.home") }}">Home</a></li>
                <li><a href="{{ route("posts.index") }}">All Posts</a></li>
                <li><a href="{{ route("about.index") }}">About</a></li>
            </ul>
        </nav>
    </div>

    <div class="float">
        <div class="float__circle btn btn-success">
            <a href="{{ route("posts.create") }}" class="float__link">
                <span class="float__link-wrapper">
                    ADD
                </span>
            </a>
        </div>
    </div>

    <div class="row">
        @yield("content")
    </div>
</body>
</html>
