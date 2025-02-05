<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\View\View;

class AdminController
{
    private PostService $postService;

    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    public function index(): View
    {
        $posts = $this->postService->getPaginatedAndFilteredPosts(null, null);
        return view("admin.index", [
            "posts" => $posts,
        ]);
    }
}
