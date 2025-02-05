<?php

namespace App\Services;

use App\DTO\PostDTO;
use App\Models\Post;
use App\Repository\Post\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPaginatedAndFilteredPosts(?bool $isPublished, ?int $categoryId): LengthAwarePaginator
    {
        return $this->postRepository->getPaginatedAndFilteredPosts($isPublished, $categoryId);
    }

    public function store(PostDTO $postDTO): Post
    {
        return $this->postRepository->store($postDTO);
    }

    public function update(PostDTO $postDTO, Post $post): Post
    {
        return $this->postRepository->update($postDTO, $post);
    }

    public function destroy(Post $post): void {
        $this->postRepository->destroy($post);
    }
}
