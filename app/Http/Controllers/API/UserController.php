<?php

namespace App\Http\Controllers\API;

use DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Negotiation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function me()
    {
        //retorna o usuario logado como objeto...

        $userLogged = Auth::user();

        return response()->json([
            'user' => $userLogged
        ], Response::HTTP_OK);
    }

    //simples função que retorna o nome de todos os usuarios do BD, pode ser util futuramente...

    /*public function getUsers()
    {
        $names = User::pluck('name');

        return response()->json([
            'names' => $names
        ], Response::HTTP_OK);
    }*/

    public function index()
    {
        $userLogged = Auth::user();

        //chat desativado para admins...

        /*if($userLogged->role_id === 1) {
            $negotiations = "";
            $users = User::where('id', '!=', $userLogged->id)->get();

            return response()->json([
                'users' => $users,
                'negotiations' => $negotiations
            ], Response::HTTP_OK);
        }*/

        //chat referente a EMPRESA
        //BUG2 - parte2
        //Query precisa ser ajustada, para listar somente o nome dos freelancers através da tabela pivot "negotiation_user"

        if($userLogged->role_id === 2) {
            $users = DB::table('negotiations')
            ->join('negotiation_user', 'negotiations.id', '=', 'negotiation_user.negotiation_id')
            ->join('users', 'negotiation_user.user_id', '=', 'users.id')
            ->join('projects', 'negotiations.project_id', '=', 'projects.id')
            ->select('negotiations.*', 'projects.title', 'users.name', 'users.id as chat_id')
            ->where(function($query) {
                $query->where('negotiation_user.user_id', '!=', Auth::user()->id);
            })
            ->get();

            $negotiation = "";

            return response()->json([
                'users' => $users,
                'negotiation' => $negotiation
            ], Response::HTTP_OK);
        }

        //chat referente ao FREELANCER
        //BUG2 - parte2
        //Query precisa ser ajustada, para listar somente o nome das empresas através da tabela pivot "negotiation_user"

        if($userLogged->role_id === 3) {
            $users = DB::table('negotiations')
            ->join('negotiation_user', 'negotiations.id', '=', 'negotiation_user.negotiation_id')
            ->join('users', 'negotiation_user.user_id', '=', 'users.id')
            ->join('projects', 'negotiations.project_id', '=', 'projects.id')
            ->select('negotiations.*', 'projects.title', 'users.name', 'users.id as chat_id')
            ->where(function($query) {
                $query->where('negotiation_user.user_id', '!=', Auth::user()->id);
            })
            ->get();

            $negotiation = "";

            return response()->json([
                'users' => $users,
                'negotiation' => $negotiation
            ], Response::HTTP_OK);
        }
    }

    public function show(User $user)
    {
        return response()->json(['user' => $user], Response::HTTP_OK);
    }
}
