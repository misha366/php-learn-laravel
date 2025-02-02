@extends("layouts.main")
@section("content")
    <style>
        {{--  На страницах с формой не должно быть кнопки добавления поста  --}}
    .float {
            display: none;
        }
    </style>

    @if($errors->any())
        <div class="toast-container position-fixed bottom-0 end-0 p-3 user-select-none">
            @foreach($errors->all() as $error)
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <img
                            class="validation__toast-image"
                            src="https://cdn-icons-png.flaticon.com/512/12434/12434856.png" alt="Alert">
                        <strong class="me-auto">Error Post</strong>
                        <small>Validation Error</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ $error }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($mode === "UPDATE")
        <form
            action="{{ route("posts.update", ["post" => $post->id]) }}"
            method="POST"
            class="container mt-4"
            novalidate
        >
            @method("PATCH")
            @elseif($mode === "CREATE")
                <form
                    action="{{ route("posts.store") }}"
                    method="POST"
                    class="container mt-4"
                    novalidate
                >
                    @endif

                    <div class="card shadow-sm">
                        <div class="card-body">
                            @if($mode === "CREATE")
                                <h3 class="mb-3 text-center">Create Post</h3>

                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" id="title" name="title" class="form-control"
                                           placeholder="Enter title" required>
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea id="content" name="content" class="form-control" rows="3"
                                              placeholder="Enter content" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image URL</label>
                                    <input type="text" id="image" name="image" class="form-control"
                                           placeholder="Enter image URL">
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Create</button>
                            @elseif($mode === "UPDATE")
                                <h3 class="mb-3 text-center">Edit Post #{{ $post->id }}</h3>

                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" id="title" name="title" class="form-control"
                                           value="{{ $post->title }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea id="content" name="content" class="form-control" rows="3"
                                              required>{{ $post->content }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image URL</label>
                                    <input type="text" id="image" name="image" class="form-control"
                                           value="{{ $post->image }}">
                                </div>

                                <button type="submit" id="submitBtn" class="btn btn-success w-100">Update</button>
                            @endif
                        </div>
                    </div>
                </form>


        @endsection
