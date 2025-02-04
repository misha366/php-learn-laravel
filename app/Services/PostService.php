<?php

namespace App\Services;

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

    public function store(array $data): Post
    {
        $post = Post::create($data);

        // https://stackoverflow.com/questions/23968415/laravel-eloquent-attach-vs-sync
        // Обновляет записи в post_tags
        if (!empty($data["tag_ids"])) {
            $post->tags()->sync($data["tag_ids"]);
        }

        return $post;
    }

    public function update(array $data, Post $post): Post
    {
        $post->update($data);
        // Помню, что валидатор конвертит пустые значения в null, поэтому добавляю
        //  ?? [], чтобы не было ошибок и данные корректно записались
        $post->tags()->sync($data["tag_ids"] ?? []);
        return $post;
    }
}
