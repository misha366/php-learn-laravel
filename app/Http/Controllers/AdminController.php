<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AdminController
{
    private PostService $postService;
    private AuthService $authService;

    public function __construct(PostService $postService, AuthService $authService)
    {
        $this->postService = $postService;
        $this->authService = $authService;
    }

    public function index(): View|RedirectResponse
    {
        $posts = $this->postService->getPaginatedAndFilteredPosts(null, null);
        return $this->authService->hasAbilityTo(
            'access-admin',
            view("admin.index", [
                "posts" => $posts,
            ])
        );
    }
}
