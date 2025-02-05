<?php

namespace App\Repository\Post;

use App\DTO\PostDTO;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
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

        if (!empty($postDTO->getTagIds())) {
            $post->tags()->sync($postDTO->getTagIds());
        }

        return $post;
    }

    public function update(PostDTO $postDTO, Post $post): Post
    {
        $post->update(PostDTO::toArray($postDTO));

        $post->tags()->sync($postDTO->getTagIds() ?? []);
        return $post;
    }

    public function destroy(Post $post): void
    {
        $post->delete();
    }
}
