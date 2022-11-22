<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Whatsapp;
use App\Models\WhatsappCat;
use Illuminate\Http\Request;

class SendWhatsappController extends Controller
{
    public function sendWhatsapp(Request $request)
    {
        if($request->nome == ''){
            $json = "Por favor preencha o campo <strong>Nome</strong>";
            return response()->json(['error' => $json]);
        }
        if($request->numero == ''){
            $json = "Por favor preencha o campo <strong>Número</strong>";
            return response()->json(['error' => $json]);
        }
        if(!empty($request->bairro) || !empty($request->cidade)){
            $json = "<strong>ERRO</strong> Você está praticando SPAM!";  
            return response()->json(['error' => $json]);
        }else{   
            $validaNews = Whatsapp::where('numero', $this->clearField($request->numero))->first();            
            if(!empty($validaNews)){
                Whatsapp::where('numero', $this->clearField($request->numero))->update(['status' => 1]);
                $json = "Obrigado Cadastro realizado com sucesso!"; 
                return response()->json(['sucess' => $json]);
            }else{
                $categoriaPadrão = WhatsappCat::where('sistema', 1)->first();                
                $data = $request->all();
                $data['autorizacao'] = 1;
                $data['categoria'] = $categoriaPadrão->id;
                $data['nome'] = $request->nome ?? '#Cadastrado pelo Site';
                $data['numero'] = $this->clearField($request->numero);
                $NumeroCreate = Whatsapp::create($data);
                $NumeroCreate->save();
                $json = "Obrigado Cadastrado com sucesso!"; 
                return response()->json(['sucess' => $json]);
            }            
        }
    }

    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
