<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function create() : View {
        $categories = Category::all();
        $tags = Tag::all();
        return view("post/create", [
            "title" => "Create post",
            "categories" => $categories,
            "tags" => $tags
        ]);
    }

    public function edit(Post $post) : View {
        return view("post/edit", [
            "title" => "Edit post",
            "post" => $post
        ]);
    }

    // Вместо такого подхода можно писать более короткий вариант
    // В таком случае мы должны будем вместо int id принимать в роуте post
    // и сам ларавел в аргумент будет подтягивать нам post

    // Сама переменная $post принимает любое значение, но подтягивать запись
    // она будет только если мы передали валидный id (findOrFail)
//    public function show(int $id) : View {
//        $post = Post::findOrFail($id);
    public function show(Post $post) : View {
        return view("post/show", [
            "post" => $post,
            "title" => $post->title,
        ]);
    }

    public function index() : View
    {
        return view("post/index", [
            "posts" => Post::all(),
            "title" => "All posts",
        ]);
    }

    public function store(Request $request) : RedirectResponse
    {

        if ($request->request->all()["category_id"] === "null") {
            $request->request->add(["category_id" => NULL]);
        }

        $validated = $request->validate([
            "title" => "required|string|max:255",
            "content" => "required|string",
            "image" => "nullable|string",
            "category_id" => "nullable|integer|exists:categories,id",
        ]);

        $post = Post::create($validated);

        return redirect()->route("posts.show", [
            "post" => $post
        ]);
    }

    public function update(Request $request, Post $post) : RedirectResponse {
        $validated = $request->validate([
            "title" => "string|max:255",
            "content" => "string",
            "image" => "nullable|string",
        ]);

        if (isset($validated["image"])) {
            $validated["image"] = ($validated["image"] === "DEL_IMG") ? null : $validated["image"];
        }

        $post->update($validated);

        return redirect()->route("posts.show", [
            "post" => $post->id
        ]);
    }

    public function destroy(Post $post) : RedirectResponse {
        $post->delete();
        return redirect()->route("posts.index");
    }
}
