<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComentarioOcorrencia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ComentarioOcorrenciaController extends Controller
{
    public function sendComment(Request $request)
    {
        if($request->content == ''){
            $json['error'] = 'Por favor digite o comentário';
            return response()->json($json);
        } 
        
        $createComentario = ComentarioOcorrencia::create($request->all());
        $createComentario->save();
        
        $json = [
            'success' => 'Mensagem cadastrada com sucesso!',
            'ocorrencia' => $request->ocorrencia
        ];
        return response()->json($json);
    }

    public function ocorrenciaCount(Request $request)
    {
        $readComment = ComentarioOcorrencia::where('ocorrencia', $request->ocorrencia)->get();
        $json = [
            'countok' => $readComment->count(),
            'id' => $request->ocorrencia
        ];
        return response()->json($json);
    }

    public function loadComentarios(Request $request)
    {
        $comentarios = ComentarioOcorrencia::where('ocorrencia', $request->id)->get();
        
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
}
