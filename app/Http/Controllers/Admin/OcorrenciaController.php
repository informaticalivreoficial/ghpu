<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OcorrenciaModeloRequest;
use App\Http\Requests\Admin\OcorrenciaRequest;
use App\Models\Empresa;
use App\Models\Ocorrencia;
use App\Models\OcorrenciaTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class OcorrenciaController extends Controller
{
    public function index()
    {
        if(Auth::user()->editor == 1){
            return Redirect::route('colaborador');
        }

        $empresas = Empresa::orderBy('created_at', 'DESC')->orderBy('status', 'ASC')->paginate(15);
        return view('admin.ocorrencias.index', [
            'empresas' => $empresas,
        ]);
    }

    public function ocorrencias($empresa)
    {
        if(Auth::user()->editor == 1){
            return Redirect::route('colaborador');
        }

        $ocorrencias = Ocorrencia::orderBy('created_at', 'DESC')->orderBy('status', 'ASC')->where('empresa', $empresa)->paginate(50);
        $empresaView = Empresa::where('id', $empresa)->first();
        return view('admin.ocorrencias.ocorrencias', [
            'ocorrencias' => $ocorrencias,
            'empresa' => $empresaView
        ]);
    }
    
    public function view($ocorrencia)
    {
        if(Auth::user()->editor == 1){
            return Redirect::route('colaborador');
        }

        $ocorrenciaView = Ocorrencia::where('id', $ocorrencia)->first();
        return view('admin.ocorrencias.view', [
            'ocorrencia' => $ocorrenciaView
        ]);
    }

    public function ocorrenciaView(Request $request)
    {
        $ocorrenciaView = Ocorrencia::where('id', $request->id)->first();
        $json = [
            'content' => $ocorrenciaView->content,
            'titulo' => $ocorrenciaView->titulo
        ];
        return response()->json($json);
    }

    public function create()
    {
        $modelos = OcorrenciaTemplate::orderBy('created_at', 'DESC')->available()->get();
        $users = User::orderBy('name')->available()->get();
        return view('admin.ocorrencias.create', [
            'users' => $users,
            'modelos' => $modelos
        ]);
    }
    
    public function store(OcorrenciaRequest $request)
    {
        $data = $request->all();
        $user = User::where('id', $request->colaborador)->first();
        $data['empresa'] = $user->empresa;
        $data['status'] = 1;
        $criarOcorrencia = Ocorrencia::create($data);
        $criarOcorrencia->save();

        if(Auth::user()->editor == 1){
            return Redirect::route('colaborador', [
                'id' => $criarOcorrencia->id,
            ])->with(['color' => 'success', 'message' => 'Ocorr??ncia cadastrada com sucesso!']);
        }
        
        return Redirect::route('ocorrencias.edit', [
            'id' => $criarOcorrencia->id,
        ])->with(['color' => 'success', 'message' => 'Ocorr??ncia cadastrada com sucesso!']);
    }

    public function edit($id)
    {
        $ocorrencia = Ocorrencia::where('id', $id)->first();
        $modelos = OcorrenciaTemplate::orderBy('created_at', 'DESC')->available()->get();
        $users = User::orderBy('name')->available()->get();

        return view('admin.ocorrencias.edit', [
            'users' => $users,
            'modelos' => $modelos,
            'ocorrencia' => $ocorrencia
        ]);
    }

    public function update(OcorrenciaRequest $request, $id)
    {
        $ocorrencia = Ocorrencia::where('id', $id)->first();
        $ocorrencia->fill($request->all());
        $ocorrencia->save();

        if(Auth::user()->editor == 1){
            return Redirect::route('colaborador', [
                'id' => $ocorrencia->id,
            ])->with(['color' => 'success', 'message' => 'Ocorr??ncia atualizada com sucesso!']);
        }

        return Redirect::route('ocorrencias.edit', [
            'id' => $ocorrencia->id,
        ])->with(['color' => 'success', 'message' => 'Ocorr??ncia atualizada com sucesso!']);
    }

    public function setStatus(Request $request)
    {        
        $ocorrencia = Ocorrencia::find($request->id);
        $ocorrencia->status = $request->status;
        $ocorrencia->save();
        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $ocorrencia = Ocorrencia::where('id', $request->id)->first();
        $nome = \App\Helpers\Renato::getPrimeiroNome(Auth::user()->name);

        if(!empty($ocorrencia)){
            $json = "<b>$nome</b> voc?? tem certeza que deseja excluir esta ocorr??ncia?";                      
            return response()->json(['error' => $json,'id' => $request->id]);
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }     
    }

    public function deleteon(Request $request)
    {
        $ocorrencia = Ocorrencia::where('id', $request->ocorrencia_id)->first();
        $empresa = $ocorrencia->empresa;
        if(!empty($ocorrencia)){
            $ocorrencia->delete();
        }
        return Redirect::route('ocorrencias.view',[
            'empresa' => $empresa
        ])->with([            
            'color' => 'success', 
            'message' => 'Empresa removida com sucesso!'
        ]);
    }

    public function modelos()
    {
        $modelos = OcorrenciaTemplate::orderBy('created_at', 'DESC')->orderBy('status', 'ASC')->paginate(25);
        $users = User::orderBy('created_at', 'DESC')->available()->get();
        return view('admin.ocorrencias.modelos', [
            'modelos' => $modelos,
            'users' => $users
        ]);
    }

    public function modelosCreate()
    {
        $empresas = Empresa::orderBy('created_at', 'DESC')->available()->get();
        return view('admin.ocorrencias.modelo-create', [
            'empresas' => $empresas
        ]);
    }
    
    public function modelosStore(OcorrenciaModeloRequest $request)
    {
        $criarModelo = OcorrenciaTemplate::create($request->all());
        $criarModelo->fill($request->all());

        return Redirect::route('modelos.edit', [
            'id' => $criarModelo->id,
        ])->with(['color' => 'success', 'message' => 'Modelo de Ocorr??ncia cadastrado com sucesso!']);
    }

    public function modelosEdit($id)
    {
        $editarModelo = OcorrenciaTemplate::where('id', $id)->first();
        $empresas = Empresa::orderBy('created_at', 'DESC')->available()->get();

        return view('admin.ocorrencias.modelo-edit', [
            'modelo' => $editarModelo,
            'empresas' => $empresas
        ]);
    }
    public function modelosUpdate(OcorrenciaModeloRequest $request, $id)
    {
        $editarModelo = OcorrenciaTemplate::where('id', $id)->first();
        $editarModelo->fill($request->all());        
        $editarModelo->save();

        return Redirect::route('modelos.edit', [
            'id' => $editarModelo->id,
        ])->with(['color' => 'success', 'message' => 'Modelo de Ocorr??ncia atualizado com sucesso!']);
    }

    public function modeloSetStatus(Request $request)
    {        
        $modelo = OcorrenciaTemplate::find($request->id);
        $modelo->status = $request->status;
        $modelo->save();
        return response()->json(['success' => true]);
    }

    public function modeloDelete(Request $request)
    {
        $modelo = OcorrenciaTemplate::where('id', $request->id)->first();
        $nome = \App\Helpers\Renato::getPrimeiroNome(Auth::user()->name);

        if(!empty($modelo)){
            $json = "<b>$nome</b> voc?? tem certeza que deseja excluir este modelo de ocorr??ncia?";                      
            return response()->json(['error' => $json,'id' => $request->id]);
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }     
    }

    public function modeloDeleteon(Request $request)
    {
        $modelo = OcorrenciaTemplate::where('id', $request->modelo_id)->first();
        if(!empty($modelo)){
            $modelo->delete();
        }
        return Redirect::route('modelos.index')->with([
            'color' => 'success', 
            'message' => 'Modelo de Ocorr??ncia removido com sucesso!'
        ]);
    }

    public function modelosResponse(Request $request)
    {
        $modelo = OcorrenciaTemplate::where('id', $request->id)->first();
        if(!empty($modelo)){
            return response()->json([ 'sucess' => 'sucess', 'content' => $modelo->content]);
        }
    }
}
