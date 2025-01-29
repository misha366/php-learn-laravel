<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{

    /*
     * View Names
     * */
    const VIEW_NAME_RENDER_POSTS = "renderposts";
    const VIEW_NAME_FORM = "form";

    /*
     * View Data
     * */
    const VIEW_DATA_KEY_POSTS = "posts";
    const VIEW_DATA_KEY_TITLE = "title";

    const VIEW_TITLE_GET_ALL_POSTS = "All posts";
    const VIEW_TITLE_PUBLISHED_POSTS = "Published posts";
    const VIEW_TITLE_CREATE_POST = "Create post";

    /*
     * Laravel Request Validation
     * */
    const VALIDATION_KEY_TITLE = "title";
    const VALIDATION_KEY_CONTENT = "content";
    const VALIDATION_KEY_IMAGE = "image";
    const VALIDATE_CONDITION_CREATE_TITLE = "required|string|max:255";
    const VALIDATE_CONDITION_CREATE_CONTENT = "required|string";
    const VALIDATE_CONDITION_CREATE_IMAGE = "nullable|string";
    const VALIDATE_CONDITION_UPDATE_TITLE = "string|max:255";
    const VALIDATE_CONDITION_UPDATE_CONTENT = "string";
    const VALIDATE_CONDITION_UPDATE_IMAGE = "nullable|string";

    /*
     * Other
     * */
    const POST_INDEX_FIRST = 1;
    const COLUMN_NAME_IS_PUBLISHED = "is_published";
    const COLUMN_IS_PUBLISHED_WHERE_CONDITION = 1;
    const DELETE_IMAGE_FLAG = "DEL_IMG";

    public function getCreatePostForm() : View {
        return view(self::VIEW_NAME_FORM, [
            self::VIEW_DATA_KEY_TITLE => self::VIEW_TITLE_CREATE_POST
        ]);
    }

    public function getPost(int $id) : View {
        $post = Post::findOrFail($id);
        return view(self::VIEW_NAME_RENDER_POSTS, [
            self::VIEW_DATA_KEY_POSTS => [$post],
            self::VIEW_DATA_KEY_TITLE => $post->title,
        ]);
    }

    public function getFirstPost() : View {
        $post = Post::findOrFail(self::POST_INDEX_FIRST);
        return view(self::VIEW_NAME_RENDER_POSTS, [
            self::VIEW_DATA_KEY_POSTS => [$post],
            self::VIEW_DATA_KEY_TITLE => $post->title,
        ]);
    }

    public function getAllPosts() : View
    {
        return view(self::VIEW_NAME_RENDER_POSTS, [
            self::VIEW_DATA_KEY_POSTS => Post::all(),
            self::VIEW_DATA_KEY_TITLE => self::VIEW_TITLE_GET_ALL_POSTS,
        ]);
    }

    public function getPublishedPosts() : View {
        $posts = Post::where(
            self::COLUMN_NAME_IS_PUBLISHED,
            self::COLUMN_IS_PUBLISHED_WHERE_CONDITION
        )->get();

        return view(self::VIEW_NAME_RENDER_POSTS, [
            self::VIEW_DATA_KEY_POSTS => $posts,
            self::VIEW_DATA_KEY_TITLE => self::VIEW_TITLE_PUBLISHED_POSTS,
        ]);
    }

    public function createPost(Request $request) : JsonResponse {
        $validated = $request->validate([
            self::VALIDATION_KEY_TITLE => self::VALIDATE_CONDITION_CREATE_TITLE,
            self::VALIDATION_KEY_CONTENT => self::VALIDATE_CONDITION_CREATE_CONTENT,
            self::VALIDATION_KEY_IMAGE => self::VALIDATE_CONDITION_CREATE_IMAGE,
        ]);

        $post = Post::create($validated);

        return response()->json($post);
    }

    public function updatePost(Request $request, int $id) : JsonResponse {
        $validated = $request->validate([
            self::VALIDATION_KEY_TITLE => self::VALIDATE_CONDITION_UPDATE_TITLE,
            self::VALIDATION_KEY_CONTENT => self::VALIDATE_CONDITION_UPDATE_CONTENT,
            self::VALIDATION_KEY_IMAGE => self::VALIDATE_CONDITION_UPDATE_IMAGE,
        ]);

        // Если мы в постмане передали DEL_IMG, то удалить картинку
        // В нормальном проекте нужно отдельным роутом (или отдельным параметром) удалять картинку,
        // тк в большинстве случаев редактирование картинки не находится рядом с формой личных данных
        if (isset($validated[self::VALIDATION_KEY_IMAGE])) {
            $validated[self::VALIDATION_KEY_IMAGE] =
                ($validated[self::VALIDATION_KEY_IMAGE] === self::DELETE_IMAGE_FLAG) ? null
                    : $validated[self::VALIDATION_KEY_IMAGE];
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
}
