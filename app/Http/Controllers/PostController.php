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

    public function edit(int $id) : View {
        $post = Post::findOrFail($id);
        return view("form", [
            "title" => "Create post",
            "mode" => "UPDATE",
            "post" => $post
        ]);
    }

    public function show(int $id) : View {
        $post = Post::findOrFail($id);
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
            "id" => $post->id
        ]);
    }

    public function update(Request $request, int $id) : RedirectResponse {
        $validated = $request->validate([
            "title" => "string|max:255",
            "content" => "string",
            "image" => "nullable|string",
        ]);

        if (isset($validated["image"])) {
            $validated["image"] = ($validated["image"] === "DEL_IMG") ? null : $validated["image"];
        }

        $post = Post::findOrFail($id);
        $post->update($validated);

        return redirect()->route("posts.show", [
            "id" => $post->id
        ]);
    }

    public function destroy(int $id) : RedirectResponse {
        Post::findOrFail($id)->delete();
        return redirect()->route("posts.index");
    }
}
