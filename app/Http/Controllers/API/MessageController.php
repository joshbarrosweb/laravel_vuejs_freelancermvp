<?php

namespace App\Http\Controllers\API;

use App\Events\Chat\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class MessageController extends Controller
{
    //lista as mensagens no chat
    public function listMessages(Request $request)
    {
        $userFrom = Auth::user()->id;
        $userTo = $request->user_id;
        $projectId = $request->project_id;
        $negotiationId = $request->negotiation_id;

        $messages = Message::where(
            function ($query) use ($userFrom, $userTo, $projectId, $negotiationId) {
                $query->where([
                    'from' => $userFrom,
                    'to' => $userTo,
                    'negotiation_id' => $negotiationId,
                    'project_id' => $projectId
                ]);
            }
        )->orWhere(
            function ($query) use ($userFrom, $userTo, $projectId, $negotiationId) {
                $query->where([
                    'from' => $userTo,
                    'to' => $userFrom,
                    'negotiation_id' => $negotiationId,
                    'project_id' => $projectId
                ]);
            }
        )->orderBy('created_at', 'ASC')->get();

        return response()->json([
            'messages' => $messages
        ], Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //BUG #1
        //por alguma razão, a mensagem não envia apos adicionar 2 chaves estrangeiras no Model e Migration (messages)...

        $message = new Message();
        /*$message->fill([
            'from' => Auth::user()->id,
            'to' => $request->to,
            'content' => $request->content,
            'project_id' => $request->project_id,
            'negotiation_id' => $request->negotiation_id,
        ]);*/
        $message->from = Auth::user()->id;
        $message->to = $request->to;
        $message->content = filter_var($request->content, FILTER_SANITIZE_STRIPPED);
        $message->created_at = Carbon::now();
        $message->updated_at = Carbon::now();
        $message->project_id = $request->project_id;
        $message->negotiation_id = $request->negotiation_id;

        $message->save();

        Event::dispatch(new SendMessage($message, $request->to));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
