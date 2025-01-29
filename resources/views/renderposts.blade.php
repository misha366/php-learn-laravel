@extends("layouts.main")
@section("content")

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

@endsection
