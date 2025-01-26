<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    const FIRST_POST_INDEX = 1;

    public function getFirstPost() : string {
        $post = Post::find(self::FIRST_POST_INDEX);
        return "
            <h1>#$post->id $post->title</h1>
            <div>$post->content</div>
       ";
    }
}
