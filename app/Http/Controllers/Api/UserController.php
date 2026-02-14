<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUser;
use App\Http\Requests\LogUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    //Enregistrer un nouvel utilisateur
    public function register(RegisterUser $request) {
        //Envelopper tout le code dans un try catch
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, [
                'rounds' => 12
            ]);
            $user->save();

            return response()->json([
                'status_code' => 200,
                'message' => 'Utilisateur enregistré avec succès',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement de l\'utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Connecter un utilisateur
    public function login(LogUserRequest $request) {

        //Connecter l'utilisateur

        //Comparer les données de l'utilisateur avec les données qu'il entre
        if(auth()->attempt($request->only(['email', 'password']))) {
            return response()->json([
                'success' => true,
                'message' => 'Utilisateur connecté avec succès',
                'user' => auth()->user()
            ]);
        }else {
            //Si les informations ne correspondent à aucun utilisateur
            return response()->json([
                'status_code' => 403,
                'message' => 'Identifiants invalides'
            ], 401);
        }

}
}
