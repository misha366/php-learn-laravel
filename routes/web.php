<?php

use App\Http\Controllers\About\IndexController;
use App\Http\Controllers\AdminController;
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
Route::group(["namespace" => ""], function () {
    Route::get("/about", IndexController::class)->name("about.index");
});
Route::get("/admin", [AdminController::class, "index"])->name("admin.index");

// CREATE
Route::get("/posts/create", [PostController::class, "create"])->name("posts.create");
Route::post("/posts", [PostController::class, "store"])->name("posts.store");

// READ
Route::get("/posts", [PostController::class, "index"])->name("posts.index");
Route::get("/posts/{post}", [PostController::class, "show"])->name("posts.show");

// UPDATE
Route::get("/posts/{post}/edit", [PostController::class, "edit"])->name("posts.edit");
Route::patch("/posts/{post}", [PostController::class, "update"])->name("posts.update");

// DELETE
Route::delete("/posts/{post}", [PostController::class, "destroy"])->name("posts.destroy");
