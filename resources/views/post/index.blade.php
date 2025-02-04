@extends("layouts.main")
@section("content")
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Posts list</h2>
            <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                Filters
            </button>
        </div>
        @foreach($posts as $post)
            <h3 class="post__title">
                <a href="{{ route("posts.show", ["post" => $post->id]) }}">
                    #{{ $post->id }} {{ $post->title }}
                </a>
                <a href="{{ route("posts.edit", ["post" => $post->id]) }}" class="post__link-edit">
                    <img src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png" alt="edit">
                </a>
                <form class="post__link-form" action="{{ route("posts.destroy", ["post" => $post->id]) }}"
                      method="POST">
                    @method("delete")
                    <button type="submit" class="post__link-trash btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-trash" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                        </svg>
                    </button>
                </form>
            </h3>
            <div class="mb-2">
                <i class="badge text-bg-primary text-wrap">
                    {{  $post->category?->title ?? "No category" }}
                </i>

                <i class="badge text-bg-warning text-wrap">
                    {{ count($post->tags) === 0 ?
                            "No tags" :
                            implode(", ", $post->tags->pluck("title")->toArray()) }}
                </i>
            </div>
            <div class="mb-4">{{ $post->content }}</div>
            <hr>
        @endforeach
        <div class="navigation">
            {{ $posts->links() }}
        </div>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebar">
            {{-- Этот скрипт тут нужен для того чтобы убрать из запроса пустые строки.
             Сами строки не мешают, просто эстетическая правка. Делаю это не на сервере,
             потому что это чисто косметический момент, который не касается логики работы сайта --}}
            <script>
                function removeEmptyGetParams() {
                    const url = new URL(window.location.href);
                    const params = new URLSearchParams(url.search);

                    // Удаляем пустые параметры
                    for (const [key, value] of params.entries()) {
                        if (value === "") {
                            params.delete(key);
                        }
                    }

                    // Обновляем URL без перезагрузки
                    const newUrl = url.pathname + (params.toString() ? `?${params}` : "");
                    window.history.replaceState(null, "", newUrl);
                }

                // Вызываем функцию при загрузке страницы
                removeEmptyGetParams();
            </script>
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Filter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <form method="GET" action="/posts">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="is_published">
                            <option @selected(request("is_published") === NULL) value="">All</option>
                            <option @selected(request("is_published") === "1") value="1">Only published</option>
                            <option @selected(request("is_published") === "0") value="0">Only not published</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category_id">
                            <option value="">All categories</option>
                            @foreach($categories as $cat)
                                <option
                                    value="{{ $cat->id }}"
                                    @selected($cat->id === (int) request("category_id"))
                                >{{ $cat->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Применить</button>
                </form>
            </div>
        </div>
    </div>

@endsection
