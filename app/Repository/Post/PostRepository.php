<?php

namespace App\Repository\Post;

use App\DTO\PostDTO;
use App\Exceptions\Post\PostStoreException;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
        try {
            return DB::transaction(function () use ($postDTO) {
                $post = Post::create(PostDTO::toArray($postDTO));
                if (!empty($postDTO->getTagIds())) {
                    $post->tags()->sync($postDTO->getTagIds());
                }

                abort(500);
                return $post;
            });
        } catch (Throwable $e) {
            Log::channel("post")->error("FROM REPO: Transaction failed when storing a post.", [
                "exception" => $e->getMessage(),
            ]);

            throw new PostStoreException("Failed to store the post, Transaction rolled back", 0, $e);
        }
    }

    public function update(PostDTO $postDTO, Post $post): Post
    {
        return DB::transaction(function () use ($post, $postDTO) {
            $post->update(PostDTO::toArray($postDTO));

            $post->tags()->sync($postDTO->getTagIds() ?? []);
            return $post;
        });
    }

    public function destroy(Post $post): void
    {
        DB::transaction(function () use ($post) {
            $post->delete();
        });
    }

}
