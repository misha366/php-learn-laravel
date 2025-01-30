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
        <h3 class="post__title">
            <a href="{{ route("post.getPost", ["id" => $post->id]) }}">
                #{{ $post->id }} {{ $post->title }}
            </a>
            <a href="{{ route("post.updatePostView", ["id" => $post->id]) }}" class="post__link-edit">
                <img src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png" alt="edit">
            </a>
            <a href="#" class="post__link-trash">
                <img src="https://cdn-icons-png.flaticon.com/512/5258/5258411.png" alt="edit">
            </a>
        </h3>
        <div>{{ $post->content }}</div>
        <hr>
    @endforeach
@endif

@endsection
