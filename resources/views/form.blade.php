@extends("layouts.main")
@section("content")
<style>
    {{--  На страницах с формой не должно быть кнопки добавления поста  --}}
    .float {
        display: none;
    }
</style>

    <form action="{{ route("post.createPostAction") }}"
          method="POST">
        @if($mode === "CREATE")
            <h3>Create Post</h3>
            <input type="text" name="title" placeholder="title">
            <input type="text" name="content" placeholder="content">
            <input type="text" name="image" placeholder="image">
            <input type="submit">
        @elseif($mode === "UPDATE")
            <h3>Edit Post #{{ $post->id }}</h3>
            <input id="title" value="{{ $post->title }}" type="text" name="title" placeholder="title">
            <input id="content" value="{{ $post->content }}" type="text" name="content" placeholder="content">
            <input id="image" value="{{ $post->image }}" type="text" name="image" placeholder="image">
            <input type="submit" id="submitBtn">

            <script>
                {{-- JS модуль нужен для того чтобы отправлять PATCH запрос --}}
                {{-- тут валидация абсолютно сломана и вообще не работает, на реальном --}}
                {{-- проекте нужно будет писать нормальную валидацию, как на серваке так и на фронте --}}
                function submitClickHandler(event) {
                    event.preventDefault();
                    const data = {
                        title: document.getElementById("title").value,
                        content: document.getElementById("content").value,
                        image: document.getElementById("image").value
                    }
                    const jsonData = JSON.stringify(data);
                    const contentLength = new TextEncoder().encode(jsonData).length;
                    fetch("{{ route('post.updatePostAction', ['id' => $post->id]) }}", {
                        method: "PATCH",
                        body: jsonData,
                        headers: {
                            "Content-Type": "application/json",
                            "Content-Length": contentLength
                        }
                    }).then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                        }
                    })
                    .then(data => console.log("Success:", data))
                    .catch(error => alert("Error:" + error));
                }

                const submitBtn = document.getElementById("submitBtn");
                submitBtn.addEventListener("click", submitClickHandler, false);
            </script>
        @endif
    </form>

@endsection
