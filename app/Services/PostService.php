<?php

namespace App\Services;

use App\DTO\PostDTO;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    public function getPaginatedAndFilteredPosts(?bool $isPublished, ?int $categoryId): LengthAwarePaginator
    {
        $query = Post::query();

        if (isset($isPublished)) {
            $query->where("is_published", $isPublished);
        }

        if (isset($categoryId)) {
            $query->where("category_id", $categoryId);
        }

        return $query->paginate(10);
    }

    public function store(PostDTO $postDTO): Post
    {
        $post = Post::create(PostDTO::toArray($postDTO));

        // https://stackoverflow.com/questions/23968415/laravel-eloquent-attach-vs-sync
        // Обновляет записи в post_tags
        if (!empty($postDTO->getTagIds())) {
            $post->tags()->sync($postDTO->getTagIds());
        }

        return $post;
    }

    public function update(PostDTO $postDTO, Post $post): Post
    {
        $post->update(PostDTO::toArray($postDTO));
        // Помню, что валидатор конвертит пустые значения в null, поэтому добавляю
        //  ?? [], чтобы не было ошибок и данные корректно записались
        $post->tags()->sync($postDTO->getTagIds() ?? []);
        return $post;
    }
}
