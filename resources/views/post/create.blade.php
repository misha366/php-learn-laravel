@extends("layouts.main")
@section("content")
    <style>
    .float {
            display: none;
        }
    </style>

    <x-error-messages></x-error-messages>

    <form
        action="{{ route("posts.store") }}"
        method="POST"
        class="container mt-4"
        novalidate
    >

        <div class="card shadow-sm">
            <div class="card-body">
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

                <div class="mb-3">
                    <label for="image" class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="null">No Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Create</button>
            </div>
        </div>
    </form>

@endsection
