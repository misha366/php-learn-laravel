<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    const FIRST_POST_INDEX = 1;
    const EMPTY_STRING = "";
    const IS_PUBLISHED_COLUMN_NAME = "is_published";
    const IS_PUBLISHED_COLUMN_CONDITION_VALUE = 1;

    const TITLE_KEY = "title";
    const CONTENT_KEY = "content";
    const IMAGE_KEY = "image";

    const TITLE_VALIDATE_CONDITION = "required|string|max:255";
    const CONTENT_VALIDATE_CONDITION = "required|string";
    const IMAGE_VALIDATE_CONDITION = "nullable|string";

    public function getFirstPost() : string {
        $post = Post::find(self::FIRST_POST_INDEX);
        return $this->htmlPost($post);
    }

    public function getAllPosts() : string
    {
        $result = self::EMPTY_STRING;
        foreach (Post::all() as $post) {
            $result .= $this->htmlPost($post);
        }
        return $result;
    }

    public function getPublishedPosts() : string {
        $result = self::EMPTY_STRING;
        foreach (Post::where(
            self::IS_PUBLISHED_COLUMN_NAME,
            self::IS_PUBLISHED_COLUMN_CONDITION_VALUE
        )->get() as $post) {
            $result .= $this->htmlPost($post);
        }
        return $result;
    }

    public function createPost(Request $request) : JsonResponse {
        $validated = $request->validate([
            self::TITLE_KEY => self::TITLE_VALIDATE_CONDITION,
            self::CONTENT_KEY => self::CONTENT_VALIDATE_CONDITION,
            self::IMAGE_KEY => self::IMAGE_VALIDATE_CONDITION,
        ]);

        $post = Post::create($validated);

        return response()->json($post);
    }

    // Accepts a Post object and returns it in html form
    private function htmlPost(Post $post) : string {
        return "
            <h1>#$post->id $post->title</h1>
            <div>$post->content</div>
            <hr>
       ";
    }
}
