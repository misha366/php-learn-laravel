<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", [MainController::class, "index"])->name("main.home");
Route::get("/get-first-post", [PostController::class, "getFirstPost"])->name("post.getFirstPost");
Route::get("/get-published-posts", [PostController::class, "getPublishedPosts"])->name("post.getPublishedPosts");

// Гайд на роуты:
// https://laravel.com/docs/11.x/controllers#actions-handled-by-resource-controllers

// CREATE
Route::get("/posts/create", [PostController::class, "create"])->name("post.createPostView");
Route::post("/posts", [PostController::class, "store"])->name("post.createPostAction");

// READ
Route::get("/posts", [PostController::class, "index"])->name("post.getAllPosts");
Route::get("/posts/{id}", [PostController::class, "show"])->name("post.getPost");

// UPDATE
Route::get("/posts/{id}/edit", [PostController::class, "edit"])->name("post.updatePostView");
Route::patch("/posts/{id}", [PostController::class, "update"])->name("post.updatePostAction");

// DELETE
Route::delete("/posts/{id}", [PostController::class, "destroy"])->name("post.deletePostAction");
