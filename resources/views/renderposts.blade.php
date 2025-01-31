@extends("layouts.main")
@section("content")

{{--  Весь смысл этой вью - рендерить переданный массив с постами  --}}
{{--  Если пост 1, просто отрендерить, без ссылки  --}}

@if(count($posts) === 1)
    @php($post = $posts[0])
    <h1 style="text-align: center">#{{ $post->id }} {{ $post->title }}</h1>
    <div>{{ $post->content }}</div>
@else
    <script>
        function deleteClickHandler(e, id) {
            e.preventDefault();

            const isDelete = confirm("Delete #" + id + "?");
            if (!isDelete) return;
            // После того как отработает пхп на месте функции route будет строка с ссылкой на удаление
            // Только вместо id будет флаг __ID__, который мы заменим на реальный айдишник, только уже
            // через js

            // в любом случае я так не буду делать на рил проектах, на рил проектах урл будет в жс
            // прописана как литерал, потому что js файлы будут лежат как статик файлы
            const url = `{{ route('posts.destroy', ['id' => '__ID__']) }}`.replace("__ID__", id);
            fetch(url, {
                method: "DELETE"
            })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    }
                })
                .then(data => console.log("Success:", data))
                .catch(error => alert("Error:" + error));

        }
    </script>
    @foreach($posts as $post)
        <h3 class="post__title">
            <a href="{{ route("posts.show", ["id" => $post->id]) }}">
                #{{ $post->id }} {{ $post->title }}
            </a>
            <a href="{{ route("posts.edit", ["id" => $post->id]) }}" class="post__link-edit">
                <img src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png" alt="edit">
            </a>
            <a href="#" class="post__link-trash" id="delete-post-{{ $post->id }}">
                <img src="https://cdn-icons-png.flaticon.com/512/5258/5258411.png" alt="edit">
            </a>
            <script>
                document.getElementById("delete-post-{{ $post->id }}")
                    .addEventListener("click", (e) => deleteClickHandler(e, {{ $post->id }}))
            </script>
        </h3>
        <div>{{ $post->content }}</div>
        <hr>
    @endforeach
@endif

@endsection
