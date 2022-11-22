<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WhatsappCatRequest;
use App\Http\Requests\Admin\WhatsappRequest;
use App\Models\Whatsapp;
use App\Models\WhatsappCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WhatsappController extends Controller
{
    public function listas()
    {
        $listas = WhatsappCat::orderBy('created_at', 'DESC')->paginate(25);

        return view('admin.whatsapp.listas',[
            'listas' => $listas
        ]);
    }

    public function listaCreate()
    {
        return view('admin.whatsapp.listas-create');
    }

    public function listaStore(WhatsappCatRequest $request)
    {
        $listaCreate  = WhatsappCat::create($request->all());

        return Redirect::route('lista.whatsapp.edit', [
            'id' => $listaCreate->id
        ])->with([
            'color' => 'success',
            'message' => 'Lista de números cadastrada com sucesso!'
        ]);
    }

    public function listaEdit($id)
    {
        $lista = WhatsappCat::where('id', $id)->first();

        return view('admin.whatsapp.listas-edit',[
            'lista' => $lista
        ]);
    }

    public function listaUpdate(WhatsappCatRequest $request, $id)
    {
        $listaUpdate = WhatsappCat::where('id', $id)->first();
        $listaUpdate->fill($request->all());
        $listaUpdate->save();

        return Redirect::route('lista.whatsapp.edit', [
            'id' => $listaUpdate->id
        ])->with([
            'color' => 'success',
            'message' => 'Lista Atualizada com sucesso!'
        ]);
    }

    public function listaSetStatus(Request $request)
    {        
        $lista = WhatsappCat::find($request->id);
        $lista->status = $request->status;
        $lista->save();

        return response()->json(['success' => true]);
    }

    public function listaDelete(Request $request)
    {
        $lista = WhatsappCat::where('id', $request->id)->first();
        $nome = \App\Helpers\Renato::getPrimeiroNome(auth()->user()->name);

        if(!empty($lista)){
            if($lista->whatsapp->count() > 0){
                $json = "<b>$nome</b> você tem certeza que deseja excluir esta Lista de Números?<br> Ela possui {$lista->whatsapp->count()} números cadastrados e todos serão excluídos!";
                return response()->json(['error' => $json,'id' => $lista->id]);
            }else{
                $json = "<b>$nome</b> você tem certeza que deseja excluir esta Lista de Números?";
                return response()->json(['error' => $json,'id' => $lista->id]);
            }            
        }else{
            return response()->json(['success' => true]);
        }
    }
    
    public function listaDeleteon(Request $request)
    { 
        $lista = WhatsappCat::where('id', $request->lista_id)->first();  
        $listaR = $lista->titulo;
        
        if(!empty($lista)){
            $lista->delete();
        }

        return Redirect::route('listas.whatsapp')->with([
            'color' => 'success', 
            'message' => 'A Lista '.$listaR.' foi removida com sucesso!'
        ]);
    }

    public function numeros($categoria)
    {
        $lista = WhatsappCat::where('id', $categoria)->first();
        $numeros = Whatsapp::orderBy('created_at', 'Desc')->where('categoria', $categoria)->paginate(55);

        return view('admin.whatsapp.index',[
            'numeros' => $numeros,
            'lista' => $lista
        ]);
    }

    public function numeroCreate()
    {
        $listas = WhatsappCat::orderBy('created_at', 'DESC')->available()->get();
        return view('admin.whatsapp.create', [
            'listas' => $listas
        ]);
    }

    public function numeroStore(WhatsappRequest $request)
    {
        $numeroCreate = Whatsapp::create($request->all());
        
        return Redirect::route('lista.numero.edit', [
            'id' => $numeroCreate->id 
        ])->with([
            'color' => 'success', 
            'message' => 'O número foi cadastrado com sucesso!'
        ]);
    }

    public function numeroEdit($id)
    {
        $numero = Whatsapp::where('id', $id)->first();
        $listas = WhatsappCat::orderBy('created_at', 'DESC')->available()->get();
        
        return view('admin.whatsapp.edit',[
            'numero' => $numero,
            'listas' => $listas
        ]);
    }

    public function numeroUpdate(WhatsappRequest $request, $id)
    {
        $numeroUpdate = Whatsapp::where('id', $id)->first();
        $numeroUpdate->fill($request->all());
        $numeroUpdate->save();
        
        return Redirect::route('lista.numero.edit', [
            'id' => $numeroUpdate->id 
        ])->with([
            'color' => 'success', 
            'message' => 'O número de '.$numeroUpdate->nome.' foi alualizado com sucesso!'
        ]);
    }

    public function numeroSetStatus(Request $request)
    {        
        $numero = Whatsapp::find($request->id);
        $numero->status = $request->status;
        $numero->autorizacao = $request->status;
        $numero->save();

        return response()->json(['success' => true]);
    }

    public function numeroDelete(Request $request)
    {
        $numero = Whatsapp::where('id', $request->id)->first();
        $nome = \App\Helpers\Renato::getPrimeiroNome(auth()->user()->name);
        
        if(!empty($numero)){
            $json = "<b>$nome</b> você tem certeza que deseja excluir este Número da Lista?";
            return response()->json(['error' => $json,'id' => $numero->id]);           
        }else{
            return response()->json(['success' => true]);
        }
    }
    
    public function numeroDeleteon(Request $request)
    {         
        $numero = Whatsapp::where('id', $request->numero_id)->first();  
        $numeroR = $numero->numero;

        $lista = WhatsappCat::where('id', $numero->categoria)->first();
        
        if(!empty($numero)){
            $numero->delete();
        }        
        
        return Redirect::route('lista.numeros',[
            'categoria' => $lista->id
        ])->with([
            'color' => 'success', 
            'message' => 'O número '.$numeroR.' foi removido com sucesso da lista!'
        ]);
    }

    public function padraoMark(Request $request)
    {
        $lista = WhatsappCat::where('id', $request->id)->first();
        $allListas = WhatsappCat::where('id', '!=', $lista->id)->get();

        foreach ($allListas as $listaall) {
            $listaall->sistema = null;
            $listaall->save();
        }

        $lista->sistema = true;
        $lista->save();

        $json = [
            'success' => true,
        ];

        return response()->json($json);         
    }
}
