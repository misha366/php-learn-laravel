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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("style/style.css") }}">
</head>
<body>

    <nav>

        <ul>
            <li><a href="{{ route("main.home") }}">Home</a></li>
            <li><a href="{{ route("post.getAllPosts") }}">All Posts</a></li>
            <li><a href="{{ route("post.getFirstPost") }}">First Post</a></li>
            <li><a href="{{ route("post.getPublishedPosts") }}">Published Posts</a></li>
        </ul>
    </nav>

    <div class="float">
        <div class="float__circle">
            <a href="{{ route("post.createPost") }}" class="float__link">
                <span class="float__link-wrapper">
                    ADD
                </span>
            </a>
        </div>
    </div>

    @yield("content")

</body>
</html>
