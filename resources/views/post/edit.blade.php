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
                           value="{{ old("title", $post->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea id="content" name="content" class="form-control" rows="3"
                              required>{{ old("content", $post->content) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image URL</label>
                    <input type="text" id="image" name="image" class="form-control"
                           value="{{ old("image", $post->image) }}">
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="null">No Category</option>
                        @foreach($categories as $cat)
                            <option
                                value="{{ $cat->id }}"
                                {{--

                                Если у нас до этого был ввод, значит мы больше не учитываем те значения
                                которые подтянулись из БД, а ставим те что юзер вводил до этого

                                --}}
                                @selected($cat->id === (int) old("category_id", $post->category_id))
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

                                {{--

                                 Отмечать данный тег как выбранные если:
                                 1. Если есть старый набор тегов, то выбирать из него
                                 2. Если нет, то из заранее выбранных тегов

                                 --}}

                                @if (old("tag_ids") === NULL)
                                    @selected(isset($post->tags)
                                        && in_array($tag->id, $post->tags->pluck("id")->toArray()))
                                @else
                                    @selected(in_array(
                                    $tag->id,
                                    array_map("intval", old("tag_ids"))
                                ))
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
