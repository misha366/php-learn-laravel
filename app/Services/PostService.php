<?php

namespace App\Services;

use App\DTO\PostDTO;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    public function index(array $data): LengthAwarePaginator
    {
        $query = Post::query();

        if (isset($data["is_published"])) {
            $query->where("is_published", $data["is_published"]);
        }

        if (isset($data["category_id"])) {
            $query->where("category_id", $data["category_id"]);
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
