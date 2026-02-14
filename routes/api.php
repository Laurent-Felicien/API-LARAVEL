<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\PostController;

//Creer un lien qui permettra aux clients: React | Angular | Vue | Node | JS Native de se connecter

//Recuperer la liste des articles

Route::get('posts', [PostController::class, 'index']);

//Ajouter un post POST | PUT | PATCH

Route::post('posts/create', [PostController::class, 'store']);

//Editer un post
Route::put('posts/edit/{post}', [PostController::class, 'update']);

//Supprimer un post
Route::delete('posts/{post}', [PostController::class, 'delete']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
