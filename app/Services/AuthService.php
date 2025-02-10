<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AuthService
{
    public function hasAbilityTo(String $ability, View|RedirectResponse $resource): View|RedirectResponse {
        if (Gate::allows($ability)) {
            return $resource;
        } else {
            return redirect(route('posts.index'));
        }
    }

    public function hasAbilityToInteractWithPost(String $ability, View|RedirectResponse $resource, Post $post): View|RedirectResponse {
        if (Gate::allows($ability, $post)) {
            return $resource;
        } else {
            return redirect(route('posts.index'));
        }
    }
}
