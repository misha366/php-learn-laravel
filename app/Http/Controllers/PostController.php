<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PostController extends Controller
{
    const FIRST_POST_INDEX = 1;

    public function getFirstPost() : string {
        $post = Post::find(self::FIRST_POST_INDEX);
        return $this->htmlPost($post);
    }

    public function getAllPosts() : string
    {
        $result = "";
        foreach (Post::all() as $post) {
            $result .= $this->htmlPost($post);
        }
        return $result;
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
