<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Helpers\PaginationHelper;
use App\Models\Negotiation;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;

class NegotiationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function freelancer()
    {
        #BUG2 - parte1
        //corrigivel se descomentar a query abaixo e remover a query acima da que está comentada... porem não retorna o NOME da empresa!

        $showPerPage = 30;

        $lists = DB::table('negotiations')
            ->join('negotiation_user', 'negotiations.id', '=', 'negotiation_user.negotiation_id')
            ->join('users', 'negotiation_user.user_id', '=', 'users.id')
            ->join('projects', 'negotiations.project_id', '=', 'projects.id')
            ->select('negotiations.*', 'projects.title', 'users.name', 'users.id')
            ->where(function($query) {
                $query->where('negotiation_user.user_id', '!=', Auth::user()->id);
                //$query->where('negotiation_user.user_id', '=', Auth::user()->id);
            })
            ->get();

        $rawList = $lists;

        $paginate = PaginationHelper::paginate($lists, $showPerPage);

        return Inertia::render('Freelancer/List/Index', ['lists' => $paginate, 'rawList' => $rawList]);
    }

    public function company()
    {
        $showPerPage = 30;

        #BUG2 - parte1
        //corrigivel se descomentar a query abaixo e remover a query acima da que está comentada... porem não retorna o NOME do freelancer!

        $lists = DB::table('negotiations')
            ->join('negotiation_user', 'negotiations.id', '=', 'negotiation_user.negotiation_id')
            ->join('users', 'negotiation_user.user_id', '=', 'users.id')
            ->join('projects', 'negotiations.project_id', '=', 'projects.id')
            ->select('negotiations.*', 'projects.title', 'users.name', 'users.id')
            ->where(function($query) {
                $query->where('negotiation_user.user_id', '!=', Auth::user()->id);
                //$query->where('negotiation_user.user_id', '=', Auth::user()->id);
            })
            ->get();

        $rawList = $lists;

        $paginate = PaginationHelper::paginate($lists, $showPerPage);

        return Inertia::render('Freelancer/List/Index', ['lists' => $paginate, 'rawList' => $rawList]);
    }

    public function negotiate(Request $request)
    {
        //tenta a negociação, mas somente inicia se o projeto solicitado não tiver um vencedor/designado. (fechado para propostas)

        $selectedProject = Project::where('id', '=', $request->project_id)->first();

        if($selectedProject->winner == null) {
            return response()->json([
                'message' => 'Você quer negociar com esse profissional?'
            ], 200);
        } else {
            return response()->json([
                'message' => 'O projeto já foi negociado, desculpe...'
            ], 203);
        }
    }

    public function confirmNegotiation(Request $request)
    {
        //caso a negociação seja possível, e seja confirmada pela empresa... ela é criada com sucesso!

        $selectedNegotiation = Negotiation::where('id', '=', $request->negotiation_id)->first();
        $selectedNegotiation->status = 'fechado';
        $selectedNegotiation->save();

        $selectedProject = Project::where('id', '=', $request->project_id)->first();
        $selectedProject->status = 'fechado';
        $selectedProject->winner = $request->freelancer_id;
        $selectedProject->save();


        return response()->json([
                'message' => 'Parabens! Você selecionou o profissional para seu projeto!'
        ], 201);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Negotiation $negotiation)
    {
        //cria a negociação se ela já não existir...

        $exists = DB::table('negotiation_user')
                        ->where('user_id', $request->freelancer_id)
                        ->where('project_id', $request->project_id)
                        ->get();

    	if(!$exists->count() > 0){
    	    $negotiation = new Negotiation();
            $negotiation->project_id = $request->project_id;
            $negotiation->status = 'aberto';
            $negotiation->save();

            $user = User::find([$request->company_id, $request->freelancer_id]);
            $negotiation->users()->attach($user, ['project_id' => $request->project_id]);

            return response()->json([
                'negotiation' => $negotiation,
                'message' => 'Negociação iniciada com sucesso!'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Você já está negociando esse projeto!'],
            401);
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Negotiation  $negotiation
     * @return \Illuminate\Http\Response
     */
    public function show(Negotiation $negotiation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Negotiation  $negotiation
     * @return \Illuminate\Http\Response
     */
    public function edit(Negotiation $negotiation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Negotiation  $negotiation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Negotiation $negotiation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Negotiation  $negotiation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Negotiation $negotiation)
    {
        //
    }
}
