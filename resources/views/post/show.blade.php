@extends("layouts.main")
@section("content")

    <h1 style="text-align: center">#{{ $post->id }} {{ $post->title }}</h1>
    <div>{{ $post->content }}</div>

@endsection
