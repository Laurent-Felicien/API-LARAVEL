<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{

    //Récupérer la liste des posts
    public function index(Request $request) {
        try {

            //Paginer la liste des posts

            //Recuperer la liste des posts
            $query = Post::query();
            //Nombre d'element à retourner par page
            $perPage = 1;
            //Recuperer la page actuelle de l'utilisateur
            $page = $request->input('page', 1);
            //Pour la recherche
            $search = $request->input('search', '');

            //L'utilisateur a saisi une recherche
            if ($search) {
                //Recherché ce que l'utilisateur a tapé ou une correspondance avec ce que l'utilisateur a saisi
                $query->whereRaw("title LIKE '%" . $search . "%'");
            }

            //Nombre de post total dans la bdd
            $total = $query->count();

            //Pagination avec Laravel
            $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Liste des posts récupérée avec succès',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result
            ]);
        } catch(Exception $e) {
            return response()->json($e);
        }
    }

    //Ajouter un post
    public function store(CreatePostRequest $request){
try {
       $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Post ajouté avec succès',
            'data' => $post
        ]);
     } catch(Exception $e) {
      return response()->json($e);
}
    }

    //Editer un post
    public function update(EditPostRequest $request, Post $post) {
        try {

            // dd($post);
            $post->title = $request->title;
            $post->description = $request->description;
            $post->save();

            return response()->json([
                'status_code' => 201,
                'status_message' => 'Post modifié avec succès',
                'data' => $post
            ]);
        } catch(Exception $e) {
            return response()->json($e);
        }
    }

    //Supprimer un post
    public function delete(Post $post) {
        try {
            $post->delete();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Post supprimé avec succès',
            ]);
        } catch(Exception $e) {
            return response()->json($e);
        }
    }
}
