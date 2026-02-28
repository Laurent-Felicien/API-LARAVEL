<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Creer un lien qui permettra aux clients: React | Angular | Vue | Node | JS Native de se connecter

// Inscrire un utilisateur
Route::post('register', [UserController::class, 'register']);

// Connecter un utilisateur
Route::post('login', [UserController::class, 'login']);

// Routes protégées par Sanctum (il faut être connecté avec un token valide)
Route::middleware('auth:sanctum')->group(function () {

    // Récupérer l'utilisateur connecté
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Déconnecter l'utilisateur connecté
    Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);

    // Recuperer la liste des articles
    Route::get('posts', [PostController::class, 'index']);

    // Ajouter un post POST | PUT | PATCH
    Route::post('posts/create', [PostController::class, 'store']);

    // Editer un post
    Route::put('posts/edit/{post}', [PostController::class, 'update']);

    // Supprimer un post
    Route::delete('posts/{post}', [PostController::class, 'delete']);
});
