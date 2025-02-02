@extends("layouts.main")
@section("content")
    <style>
        {{--  На страницах с формой не должно быть кнопки добавления поста  --}}
    .float {
            display: none;
        }
    </style>

    <x-error-messages></x-error-messages>

    <form
        action="{{ route("posts.update", ["post" => $post->id]) }}"
        method="POST"
        class="container mt-4"
        novalidate
    >
        @method("PATCH")
        <div class="card shadow-sm">
            <div class="card-body">

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
            </div>
        </div>
    </form>

@endsection
