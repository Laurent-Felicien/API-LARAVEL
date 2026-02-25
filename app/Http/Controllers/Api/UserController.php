<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogUserRequest;
use App\Http\Requests\RegisterUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Enregistrer un nouvel utilisateur
    public function register(RegisterUser $request): JsonResponse
    {
        try {
            // Créer un nouvel utilisateur
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, [
                'rounds' => 12,
            ]);
            $user->save();

            // Créer un token Sanctum pour l'utilisateur inscrit
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'message' => 'Utilisateur enregistré avec succès',
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement de l\'utilisateur',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Connecter un utilisateur
    public function login(LogUserRequest $request): JsonResponse
    {

        // Comparer les données de l'utilisateur avec les données qu'il entre
        if (auth()->attempt($request->only(['email', 'password']))) {

            // Récupérer l'utilisateur connecté
            $user = auth()->user();

            // Créer un token Sanctum pour l'utilisateur connecté
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Utilisateur connecté avec succès',
                'user' => $user,
                'token' => $token,
            ]);
        } else {
            // Si les informations ne correspondent à aucun utilisateur
            return response()->json([
                'status_code' => 403,
                'message' => 'Identifiants invalides',
            ], 401);
        }

    }

    // Déconnecter un utilisateur (supprimer son token)
    public function logout(Request $request): JsonResponse
    {
        // Supprimer le token actuel de l'utilisateur
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status_code' => 200,
            'message' => 'Utilisateur déconnecté avec succès',
        ]);
    }
}
