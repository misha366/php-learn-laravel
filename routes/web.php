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
Route::get("/get-all-posts", [PostController::class, "getAllPosts"])->name("post.getAllPosts");
Route::get("/get-published-posts", [PostController::class, "getPublishedPosts"])->name("post.getPublishedPosts");

Route::get("/get-post/{id}", [PostController::class, "getPost"])->name("post.getPost");

Route::post("/create-post", [PostController::class, "createPost"]);

Route::patch("/update-post/{id}", [PostController::class, "updatePost"]);

Route::delete("/delete-post/{id}", [PostController::class, "deletePost"]);
