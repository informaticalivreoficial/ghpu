<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Post;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::where('id_pai', null)->orderBy('tipo', 'ASC')
                    ->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'DESC')->paginate(25);
        return view('admin.menus.index', [
            'menus' => $menus
        ]);
    }

    public function create(Request $request)
    {   
        $paginas = Post::where('tipo', 'pagina')->postson()->get();     
        $catpai = Menu::where('id', $request->catpai)->first();
        
        return view('admin.menus.create',[
            'catpai' => $catpai,
            'paginas' => $paginas
        ]);
    }

    public function store(MenuRequest $request)
    {
        $criarLink = Menu::create($request->all());
        $criarLink->fill($request->all());
        if($request->id_pai != null){
            return redirect()->route('menus.edit', [
                'id' => $criarLink->id,
            ])->with(['color' => 'success', 'message' => 'Sub Link cadastrado com sucesso!']);
        }else{
            return redirect()->route('menus.edit', [
                'id' => $criarLink->id,
            ])->with(['color' => 'success', 'message' => 'Link cadastrado com sucesso!']);
        }
    }

    public function edit($id)
    {
        $paginas = Post::where('tipo', 'pagina')->postson()->get(); 
        $link = Menu::where('id', $id)->first();
        if($link->id_pai != null){
            $sublink = Menu::where('id', $link->id_pai)->first();
        }else{
            $sublink = null;
        }
        return view('admin.menus.edit', [
            'link' => $link,
            'sublink' => $sublink,
            'paginas' => $paginas
        ]);
    }

    public function update(MenuRequest $request, $id)
    {
        $link = Menu::where('id', $id)->first();
        $link->fill($request->all());
        $link->save();
        
        if($link->id_pai != null){
            return redirect()->route('menus.edit', [
                'id' => $link->id,
            ])->with(['color' => 'success', 'message' => 'Sub Link atualizado com sucesso!']);
        }else{
            return redirect()->route('menus.edit', [
                'id' => $link->id,
            ])->with(['color' => 'success', 'message' => 'Link atualizado com sucesso!']);
        }        
    }

    public function delete(Request $request)
    {
        $link = Menu::where('id', $request->id)->first();
        $sublink = Menu::where('id_pai', $request->id)->first();
        $nome = \App\Helpers\Renato::getPrimeiroNome(Auth::user()->name);

        
        if(!empty($link) && empty($sublink)){
            if($link->id_pai == null){
                $json = "<b>$nome</b> você tem certeza que deseja excluir este link?";
                return response()->json(['erroron' => $json,'id' => $link->id]);
            }else{
                $json = "<b>$nome</b> você tem certeza que deseja excluir este sub link?";
                return response()->json(['erroron' => $json,'id' => $link->id]);               
            }            
        }
        if(!empty($link) && !empty($sublink)){
            $json = "<b>$nome</b> este link possui sub links! É peciso excluí-los primeiro!";
            return response()->json(['error' => $json,'id' => $link->id]);
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }        
    }

    public function deleteon(Request $request)
    {
        $link = Menu::where('id', $request->link_id)->first(); 
        $linkR = $link->titulo;

        if(!empty($link)){            
            $link->delete();
        }

        if($link->id_pai != null){
            return redirect()->route('menus.index')->with([
                'color' => 'success', 
                'message' => 'O sub link '.$linkR.' foi removido com sucesso!'
            ]);
        }else{
            return redirect()->route('menus.index')->with([
                'color' => 'success', 
                'message' => 'O link '.$linkR.' foi removido com sucesso!'
            ]);
        }        
    }
}
