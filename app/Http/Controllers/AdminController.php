<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AdminController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(): View|RedirectResponse
    {
        $this->authorize('access-admin');
        $posts = $this->postService->getPaginatedAndFilteredPosts(null, null);
        return view("admin.index", [
                "posts" => $posts,
            ]);
    }
}
