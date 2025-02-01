@php use App\Models\Category; @endphp
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
                <a href="{{ route("posts.show", ["post" => $post->id]) }}">
                    #{{ $post->id }} {{ $post->title }}
                </a>
                <a href="{{ route("posts.edit", ["post" => $post->id]) }}" class="post__link-edit">
                    <img src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png" alt="edit">
                </a>
                <form class="post__link-form" action="{{ route("posts.destroy", ["post" => $post->id]) }}"
                      method="POST">
                    @method("delete")
                    <button type="submit" class="post__link-trash btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-trash" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                        </svg>
                    </button>
                </form>
            </h3>
            <div class="mb-2">
                <i class="badge text-bg-primary text-wrap">
                    {{ $post->category === NULL ? "No category" : $post->category->title }}
                </i>

                <i class="badge text-bg-warning text-wrap">
{{--                    {{ dd($post->tags->toArray()[0]) }}--}}
                    {{ count($post->tags) === 0 ?
                            "No tags" :
                            implode(", ", $post->tags->pluck("title")->toArray()) }}
                </i>
            </div>
            <div  class="mb-4">{{ $post->content }}</div>
            <hr>
        @endforeach
    @endif

@endsection
