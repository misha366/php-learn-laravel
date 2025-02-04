<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\FilterRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\MetaService;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
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
        $meta = $this->metaService->getCategoriesAndTags();

        return view("post/create", [
            "title" => "Create post",
            "categories" => $meta["categories"],
            "tags" => $meta["tags"],
        ]);
    }

    public function edit(Post $post): View
    {
        $meta = $this->metaService->getCategoriesAndTags();
        return view("post/edit", [
            "title" => "Edit post",
            "post" => $post,
            "categories" => $meta["categories"],
            "tags" => $meta["tags"],
        ]);
    }

    // Вместо такого подхода можно писать более короткий вариант
    // В таком случае мы должны будем вместо int id принимать в роуте post
    // и сам ларавел в аргумент будет подтягивать нам post

    // Сама переменная $post принимает любое значение, но подтягивать запись
    // она будет только если мы передали валидный id (findOrFail)
//    public function show(int $id) : View {
//        $post = Post::findOrFail($id);
    public function show(Post $post): View
    {
        return view("post/show", [
            "post" => $post,
            "title" => $post->title,
        ]);
    }

    public function index(FilterRequest $request): View
    {
        $validated = $request->validated();

        $posts = $this->postService->index($validated);
        $meta = $this->metaService->getCategoriesAndTags();

        return view("post/index", [
            "posts" => $posts,
            "categories" => $meta["categories"],
            "title" => "All posts",
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $post = $this->postService->store($validated);

        return redirect()->route("posts.show", [
            "post" => $post
        ]);
    }

    public function update(UpdateRequest $request, Post $post): RedirectResponse
    {
        $validated = $request->validated();

        $this->postService->update($validated, $post);

        return redirect()->route("posts.show", [
            "post" => $post->id
        ]);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();
        return redirect()->route("posts.index");
    }
}
