<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MsgUserRequest;
use App\Models\MsgUser;
use Illuminate\Http\Request;

class MsgUserController extends Controller
{
    public function sendUserMsg(Request $request)
    {
        if(empty($request->titulo)){
            $json = "Por favor preencha o campo <strong>título</strong>";
            return response()->json(['error' => $json]);
        }
        
        if(empty($request->content)){
            $json = "Por favor preencha o campo <strong>Mensagem</strong>";
            return response()->json(['error' => $json]);
        }

        $createMsg = MsgUser::create($request->all());
        $createMsg->save();

        $json = "Sua mensagem foi enviada com sucesso!"; 
        return response()->json(['sucess' => $json]);
    }
}
