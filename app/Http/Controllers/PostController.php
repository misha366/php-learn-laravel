<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function create() : View {
        return view("form", [
            "title" => "Create post",
            "mode" => "CREATE"
        ]);
    }

    public function edit(Post $post) : View {
        return view("form", [
            "title" => "Create post",
            "mode" => "UPDATE",
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
        return view("renderposts", [
            "posts" => [$post],
            "title" => $post->title,
        ]);
    }

    public function getFirstPost() : View {
        $post = Post::findOrFail(1);
        return view("renderposts", [
            "posts" => [$post],
            "title" => $post->title,
        ]);
    }

    public function index() : View
    {
        return view("renderposts", [
            "posts" => Post::all(),
            "title" => "All posts",
        ]);
    }

    public function getPublishedPosts() : View {
        $posts = Post::where("is_published", 1)->get();

        return view("renderposts", [
            "posts" => $posts,
            "title" => "Published posts",
        ]);
    }

    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "content" => "required|string",
            "image" => "nullable|string",
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
