<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} - POSTS SITE</title>
    <style>
        body {
            background: #a0aec0;
            margin: 10px 15%;
        }
        * {
            font-family: Roboto, sans-serif;
        }
    </style>
</head>
<body>

    <nav>

        <ul>
            <li><a href="{{ route("main.home") }}">Home</a></li>
            <li><a href="{{ route("post.getFirstPost") }}">All Posts</a></li>
            <li><a href="{{ route("post.getAllPosts") }}">First Post</a></li>
            <li><a href="{{ route("post.getPublishedPosts") }}">Published Posts</a></li>
        </ul>

        <style>
            nav ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
            }

            nav ul li {
                margin-right: 15px;
            }

            nav ul li:last-child {
                margin-right: 0;
            }

            nav ul li a {
                color: #ef4444;
                transition: .2s ease-in;
                text-decoration: none;
            }


            nav ul li a:hover {
                color: rgba(239, 68, 68, 0.75);
                transition: .2s ease-in;
            }

        </style>
    </nav>

    @yield("content")

</body>
</html>
