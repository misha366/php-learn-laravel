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

                <div class="mb-3">
                    <label for="image" class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="null">No Category</option>
                        @foreach($categories as $cat)
                            <option
                                value="{{ $cat->id }}"
                                @if($post->category_id === $cat->id)
                                    selected
                                @endif
                            >{{ $cat->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Tags</label>
                    <select multiple name="tag_ids[]" class="form-select">
                        @foreach($tags as $tag)
                            <option
                                value="{{ $tag->id }}"
                                @if(isset($post->tags)
                                    && in_array($tag->id, $post->tags->pluck("id")->toArray()))
                                    selected
                                @endif
                            >{{ $tag->title }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" id="submitBtn" class="btn btn-success w-100">Update</button>
            </div>
        </div>
    </form>

@endsection
