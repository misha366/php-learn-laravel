@extends("layouts.main")

@section("content")
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title text-center">#{{ $post->id }} {{ $post->title }}</h1>

                @if($post->image)
                    <div class="text-center mb-3">
                        <img src="{{ asset("storage/" . $post->image) }}" class="img-fluid rounded" alt="{{ $post->title }}">
                    </div>
                @endif

                <p class="card-text">{{ $post->content }}</p>

                <hr>

                <p><strong>Category:</strong>
                    {{ $post->category->title ?? "No category" }}
                </p>

                <p><strong>Теги:</strong>
                    @forelse($post->tags as $tag)
                        <span class="badge bg-primary">{{ $tag->title }}</span>
                    @empty
                        <span class="text-muted">No tags</span>
                    @endforelse
                </p>

                <p><strong>Likes:</strong> {{ $post->likes }}</p>
                <p><strong>Author:</strong> {{ $post->author->name ?? "No author" }}</p>
                <p><strong>Status:</strong>
                    <span class="badge {{ $post->is_published ? "bg-success" : "bg-danger" }}">
                        {{ $post->is_published ? "Published" : "Not published" }}
                    </span>
                </p>

                <p class="text-muted">
                    Created: {{ $post->created_at->format("d.m.Y H:i") }}<br>
                    Updated: {{ $post->updated_at->format("d.m.Y H:i") }}
                </p>

                <a href="{{ route("posts.index") }}" class="btn btn-secondary">Back to list</a>
            </div>
        </div>
    </div>
@endsection
