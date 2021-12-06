<?php

namespace App\Http\Controllers\Company;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Company/Projects/Index', ['projects' => Project::where('company_id', '=', Auth::user()->id)->orderBy('id', 'desc')->paginate()]);
    }

    public function show(Project $project)
    {
        return response()->json(['project' => $project], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:8|max:160',
            'details' => 'required|string|min:40|max:999',
            'skills' => 'required|string|min:4|max:160'
        ]);

        $project = new Project();
        $project->company_id = Auth::user()->id;
        $project->title = $request->title;
        $project->details = $request->details;
        $project->skills = $request->skills;
        $project->status = 'aberto';

        $project->save();

        //Project::create($request->validated());

        return back(303);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $project->update($request->validated());

        return back(303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return back(303);
    }
}
