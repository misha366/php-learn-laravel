<?php

namespace App\Repository\Post;

use App\DTO\PostDTO;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function getPaginatedAndFilteredPosts(
        ?bool $isPublished,
        ?int  $categoryId): LengthAwarePaginator;
    public function store(PostDTO $postDTO): Post;
    public function update(PostDTO $postDTO, Post $post): Post;
    public function destroy(Post $post): void;
}
