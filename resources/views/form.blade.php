@extends("layouts.main")
@section("content")
<style>
    {{--  На страницах с формой не должно быть кнопки добавления поста  --}}
    .float {
        display: none;
    }
</style>

    <form action="{{ route("post.createPostAction") }}" method="POST">
        <input type="text" name="title" placeholder="title">
        <input type="text" name="content" placeholder="content">
        <input type="text" name="image" placeholder="image">

        <input type="submit">
    </form>

@endsection
