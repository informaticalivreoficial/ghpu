<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MsgUser;
use App\Models\User;
use App\Notifications\MsgUser as NotificationsMsgUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MsgUserController extends Controller
{
    public function index()
    {
        $mensagens = MsgUser::latest()->where('user', Auth::user()->id)->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('M d'); // grouping by day
            });
        return view('admin.mensagens.index', [
            'mensagens' => $mensagens
        ]);
        
        // $datas = MsgUser::orderBy('created_at', 'DESC')->available()->get();
        // return view('admin.mensagens.index',[
        //     'mensagens' => $mensagens,
        //     'datas' => $datas
        // ]);
    }

    public function sendUserMsg(Request $request)
    {
        if(empty($request->titulo)){
            $json = "Por favor preencha o campo <strong>Assunto</strong>";
            return response()->json(['error' => $json]);
        }
        
        if(empty($request->content)){
            $json = "Por favor preencha o campo <strong>Mensagem</strong>";
            return response()->json(['error' => $json]);
        }

        $createMsg = MsgUser::create($request->all());
        $createMsg->save();

        $mensagem = User::find($createMsg->user);
        $mensagem->notify(new NotificationsMsgUser($createMsg));

        $json = "Sua mensagem foi enviada com sucesso!"; 
        return response()->json(['sucess' => $json]);
    }

    public function sendResposta(Request $request)
    {
        if($request->content == ''){
            $json['error'] = 'Por favor digite a resposta';
            return response()->json($json);
        } 
        
        $createMensagem = MsgUser::create($request->all());
        $createMensagem->save();

        $mensagem = User::find($createMensagem->user);
        $mensagem->notify(new NotificationsMsgUser($createMensagem));
        
        $json = [
            'success' => 'Resposta cadastrada com sucesso!',
            'ocorrenciaid' => $createMensagem->id
        ];
        return response()->json($json);
    }

    public function loadResposta(Request $request)
    {
        $mensagens = MsgUser::where('id', $request->id)->get();
        
        if(!empty($comentarios)){
            $json = ['id' => $request->id];
            $comments = [];
            foreach($comentarios as $key => $comment){
                $comments[$key]['user'] = $comment->userObject->name . ' - ' . Carbon::parse($comment->created_at)->format('m/d - H:i');
                $comments[$key]['content'] = $comment->content;
                $comments[$key]['ocorrencia'] = $comment->ocorrencia;
            }            
            return response()->json([$comments,$json]);
        }
    }

    public function msgSetStatus(Request $request)
    {        
        $post = MsgUser::find($request->id);
        $post->status = $request->status;
        $post->save();
        return response()->json(['success' => true]);
    }
}
