<?php

namespace App\Http\Controllers;

use App\DTO\PostDTO;
use App\Http\Requests\Post\IndexRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Services\AuthService;
use App\Services\MetaService;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostController extends Controller
{
    // если бы я это делал в однометодных контроллерах, мне бы нужно было
    // создавать общий BaseController, который будут наследовать все контроллеры
    // и уже в нём создавать инстанс сервиса
    public PostService $postService;
    public MetaService $metaService;

    public function __construct(PostService $postService, MetaService $metaService)
    {
        $this->postService = $postService;
        $this->metaService = $metaService;
    }

    public function create(): View
    {
        $this->authorize('create-post');
        $meta = $this->metaService->getCategoriesAndTags();

        return view("post/create", [
            "title" => "Create post",
            "categories" => $meta["categories"],
            "tags" => $meta["tags"],
        ]);
    }

    public function edit(Post $post): View
    {
        $this->authorize('update-post', $post);
        $meta = $this->metaService->getCategoriesAndTags();
        return view("post/edit", [
            "title" => "Edit post",
            "post" => $post,
            "categories" => $meta["categories"],
            "tags" => $meta["tags"],
        ]);
    }

    public function show(Post $post): View
    {
        return view("post/show", [
            "post" => $post,
            "title" => $post->title,
        ]);
    }

    public function index(IndexRequest $request): View
    {
        $params = $request->validated();

        $posts = $this->postService->getPaginatedAndFilteredPosts(
            $params["is_published"] ?? null,
            $params["category_id"] ?? null
        );
        $meta = $this->metaService->getCategoriesAndTags();

        return view("post/index", [
            "posts" => $posts,
            "categories" => $meta["categories"],
            "title" => "All posts",
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->authorize('create-post');
        $postDTO = PostDTO::fromArray($request->validated());
        $post = $this->postService->store($postDTO);

        return redirect()->route("posts.show", [
            "post" => $post
        ]);
    }

    public function update(UpdateRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update-post', $post);
        $this->postService->update(PostDTO::fromArray($request->validated()), $post);

        return redirect()->route("posts.show", [
            "post" => $post->id
        ]);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete-post', $post);
        $this->postService->destroy($post);
        return redirect()->route("posts.index");
    }
}
