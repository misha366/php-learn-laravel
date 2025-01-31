@extends("layouts.main")
@section("content")
<style>
    {{--  На страницах с формой не должно быть кнопки добавления поста  --}}
    .float {
        display: none;
    }
</style>

    <form action="{{ route("posts.store") }}" method="POST" class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                @if($mode === "CREATE")
                    <h3 class="mb-3 text-center">Create Post</h3>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter title" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea id="content" name="content" class="form-control" rows="3" placeholder="Enter content" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image URL</label>
                        <input type="text" id="image" name="image" class="form-control" placeholder="Enter image URL">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Create</button>

                @elseif($mode === "UPDATE")
                    <h3 class="mb-3 text-center">Edit Post #{{ $post->id }}</h3>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ $post->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea id="content" name="content" class="form-control" rows="3" required>{{ $post->content }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image URL</label>
                        <input type="text" id="image" name="image" class="form-control" value="{{ $post->image }}">
                    </div>

                    <button type="submit" id="submitBtn" class="btn btn-success w-100">Update</button>

                    <script>
                        function submitClickHandlerf(event) {
                            event.preventDefault();
                            const data = {
                                title: document.getElementById("title").value,
                                content: document.getElementById("content").value,
                                image: document.getElementById("image").value
                            }
                            const jsonData = JSON.stringify(data);

                            console.log("Отправляемые данные:", data);
                            fetch("{{ route('posts.update', ['post' => $post->id]) }}", {
                                method: "PATCH",
                                body: jsonData,
                                headers: { "Content-Type": "application/json" },
                                // redirect: "manual"
                            }).then(response => {
                                console.log(response);
                                // if (response.redirected) {
                                //     window.location.href = response.url;
                                // }
                            }).catch(error => alert("Error:" + error));
                        }
                        function submitClickHandler(e) {
                            e.preventDefault();
                            const data = {
                                title: document.getElementById("title").value,
                                content: document.getElementById("content").value,
                                image: document.getElementById("image").value
                            }
                            console.log("{{ route("posts.update", ["post" => $post->id]) }}");
                            fetch("{{ route("posts.update", ["post" => $post->id]) }}", {
                                method: "PATCH",
                                body: data,
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded"
                                }
                            })
                                .then(response => {
                                    console.log(response);
                                })
                                .catch(e => console.log(e));
                        }

                        document.getElementById("submitBtn").addEventListener("click", submitClickHandler);
                    </script>
                @endif
            </div>
        </div>
    </form>


@endsection
