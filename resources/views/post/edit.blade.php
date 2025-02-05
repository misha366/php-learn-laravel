@extends("layouts.main")
@section("content")
    <style>
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
                        <option value="">No Category</option>
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
                        @php
                            /** @var \Illuminate\Support\ViewErrorBag $errors */
                            $isFirstAttempt = count($errors->all()) === 0;

                            // про нуллсейф ?-> оператор написал в пхптипс
                            $tagsFromDB = $post->tags?->pluck("id")->toArray() ?? [];
                            $tagsOld = array_map("intval", old("tag_ids", []));
                        @endphp
                        @foreach($tags as $tag)
                            <option
                                value="{{ $tag->id }}"

                                {{--

                                 Отмечать данный тег как выбранные если:
                                 1. Если есть старый набор тегов, то выбирать из него
                                 2. Если нет, то из заранее выбранных тегов

                                 --}}

                                {{-- Подтягиваем значения из БД, только если это первая попытка пройти
                                валидацию (при второй попытке, очевидно массив с ошибками будет не пуст)

                                Проблема заключается в том, что есть баг - если например пользователь во
                                время редактирования (при первой попытке) убрал все теги, то массив
                                old("tag_ids") будет пустой, так будто бы это первая попытка юзера
                                пройти валидацию. И в таком кейсе (когда юзер убрал при первой попытке
                                все теги) на вторую попытку подтянутся теги из базы, что есть неправильно

                                Мой подход заключается в том, чтобы маркировать теги из базы только при
                                первой попытке (когда ошибок нету), при таком поведении, подгружены данные
                                из таблицы будут только 1 раз, когда юзер зашёл на форму при первой попытке
                                и не совершил ошибок валидации.
                                --}}
{{--                                Старое условие: --}}
{{--                                @if (old("tag_ids") === NULL)--}}

                                @selected(
                                    ($isFirstAttempt && in_array($tag->id, $tagsFromDB))
                                    ||
                                    in_array($tag->id, $tagsOld)
                                )
                            >{{ $tag->title }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" id="submitBtn" class="btn btn-success w-100">Update</button>
            </div>
        </div>
    </form>

@endsection
