<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    public function create(): View
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view("post/create", [
            "title" => "Create post",
            "categories" => $categories,
            "tags" => $tags
        ]);
    }

    public function edit(Post $post): View
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view("post/edit", [
            "title" => "Edit post",
            "post" => $post,
            "categories" => $categories,
            "tags" => $tags
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

    public function index(): View
    {
        $posts = Post::paginate(10);
        return view("post/index", [
            "posts" => $posts,
            "title" => "All posts",
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $post = Post::create($validated);

        // https://stackoverflow.com/questions/23968415/laravel-eloquent-attach-vs-sync
        // Обновляет записи в post_tags
        if (!empty($validated["tag_ids"])) {
            $post->tags()->sync($validated["tag_ids"]);
        }

        return redirect()->route("posts.show", [
            "post" => $post
        ]);
    }

    public function update(UpdateRequest $request, Post $post): RedirectResponse
    {
        $validated = $request->validated();

        $post->update($validated);
        // Помню, что валидатор конвертит пустые значения в null, поэтому добавляю
        //  ?? [], чтобы не было ошибок и данные корректно записались
        $post->tags()->sync($validated["tag_ids"] ?? []);

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
