<?php

namespace App\Http\Controllers;

use App\Models\Post;
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

    const UPDATE_TITLE_VALIDATE_CONDITION = "string|max:255";
    const UPDATE_CONTENT_VALIDATE_CONDITION = "string";
    const UPDATE_IMAGE_VALIDATE_CONDITION = "nullable|string";

    const DELETE_IMAGE_FLAG = "DEL_IMG";

    public function getPost(int $id) : string {
        $post = Post::findOrFail($id);
        return $this->htmlPost($post);
    }

    public function getFirstPost() : string {
        $post = Post::findOrFail(self::FIRST_POST_INDEX);
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

    public function updatePost(Request $request, int $id) : JsonResponse {
        $validated = $request->validate([
            self::TITLE_KEY => self::UPDATE_TITLE_VALIDATE_CONDITION,
            self::CONTENT_KEY => self::UPDATE_CONTENT_VALIDATE_CONDITION,
            self::IMAGE_KEY => self::UPDATE_IMAGE_VALIDATE_CONDITION,
        ]);

        // Если мы в постмане передали DEL_IMG, то удалить картинку
        // В нормальном проекте нужно отдельным роутом (или отдельным параметром) удалять картинку,
        // тк в большинстве случаев редактирование картинки не находится рядом с формой личных данных
        if (isset($validated[self::IMAGE_KEY])) {
            $validated[self::IMAGE_KEY] = $validated[self::IMAGE_KEY] === self::DELETE_IMAGE_FLAG ?
                null : $validated[self::IMAGE_KEY];
        }

        $post = Post::findOrFail($id);
        $post->update($validated);

        return response()->json($post);
    }

    // Это акшн с хард delete, чтобы сделать soft delete надо добавлять поле
    // is_delete и в этом акшне менять его значение (рекомендуется soft delete)

    // либо

    // Можно использовать встроенный софт delete от ларавел, гайд:
    // https://youtu.be/H6YyZb3ssS8?si=A6yxXvth4-0fZ_hY&t=182
    public function deletePost(int $id) : bool {
        $post = Post::findOrFail($id);
        return $post->delete();
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
