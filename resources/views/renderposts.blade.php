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
    {{--  Весь смысл этой вью - рендерить переданный массив с постами  --}}
    {{--  Если пост 1, просто отрендерить, без ссылки  --}}

    @if(count($posts) === 1)
        @php($post = $posts[0])
        <h1 style="text-align: center">#{{ $post->id }} {{ $post->title }}</h1>
        <div>{{ $post->content }}</div>
    @else
        @foreach($posts as $post)
            <h3>
                <a href="/get-post/{{ $post->id  }}">
                    #{{ $post->id }} {{ $post->title }}
                </a>
            </h3>
            <div>{{ $post->content }}</div>
            <hr>
        @endforeach
    @endif
</body>
</html>
