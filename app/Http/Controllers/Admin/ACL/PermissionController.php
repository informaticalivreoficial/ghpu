<?php

namespace App\Http\Controllers\Admin\ACL;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('admin.permissions.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = Permission::where('name', $request->name)->get();

        if($permission->count() > 0){
            return redirect()->back()->withInput()->with(['color' => 'danger', 'message' => 'Este nome de permissão já existe!']);
        }

        if($request->name == ''){
            return redirect()->back()->withInput()->with(['color' => 'danger', 'message' => 'Preencha o nome da permissão!']);
        }

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('admin.permission.index')->with(['color' => 'success', 'message' => 'Permissão cadastrada com sucesso!']);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::where('id', $id)->first();

        return view('admin.permissions.edit', [
            'permission' => $permission
        ]);
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
        $permission = Permission::where('name', $request->name)->where('id', '!=', $id)->get();

        if($permission->count() > 0){
            return redirect()->back()->withInput()->with(['color' => 'danger', 'message' => 'Este nome de permissão já existe!']);
        }

        if($request->name == ''){
            return redirect()->back()->withInput()->with(['color' => 'danger', 'message' => 'Preencha o nome da permissão!']);
        }

        $permission = Permission::where('id', $id)->first();
        
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('admin.permission.edit', [
            'permission' => $permission
        ])->with(['color' => 'success', 'message' => 'Permissão atualizada com sucesso!']);
    }

    public function delete(Request $request)
    {
        $permission = Permission::where('id', $request->id)->first();
        $nome = getPrimeiroNome(Auth::user()->name);

        if(!empty($permission)){
            $json = "<b>$nome</b> você tem certeza que deseja excluir esta permissão?<br> 
            <span class='text-warning'>Atenção isso pode comprometer sua aplicação, na dúvida contacte o administrador do sistema!</span>";                      
            return response()->json(['error' => $json,'id' => $request->id]);
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }     
    }

    public function deleteon(Request $request)
    {
        $permission = Permission::where('id', $request->permission_id)->first();
        if(!empty($permission)){
            $permission->delete();
        }
        return redirect()->route('admin.permission.index')->with(['color' => 'success', 'message' => 'Permissão removida com sucesso!']);
    }
    
}
