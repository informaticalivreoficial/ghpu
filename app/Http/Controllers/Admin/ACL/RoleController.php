<?php

namespace App\Http\Controllers\Admin\ACL;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::where('name', $request->name)->get();

        if($role->count() > 0){
            return redirect()->back()->withInput()->with(['color' => 'danger', 'message' => 'Este nome de perfil já existe!']);
        }

        if($request->name == ''){
            return redirect()->back()->withInput()->with(['color' => 'danger', 'message' => 'Preencha o nome do perfil!']);
        }

        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return redirect()->route('admin.role.index')->with(['color' => 'success', 'message' => 'Perfil cadastrado com sucesso!']);
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
        $role = Role::where('id', $id)->first();

        return view('admin.roles.edit', [
            'role' => $role
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
        $role = Role::where('name', $request->name)->where('id', '!=', $id)->get();

        if($role->count() > 0){
            return redirect()->back()->withInput()->with(['color' => 'danger', 'message' => 'Este nome de perfil já existe!']);
        }

        if($request->name == ''){
            return redirect()->back()->withInput()->with(['color' => 'danger', 'message' => 'Preencha o nome do perfil!']);
        }

        $role = Role::where('id', $id)->first();
        
        $role->name = $request->name; 
        $role->save();

        return redirect()->route('admin.role.edit', [
            'role' => $role
        ])->with(['color' => 'success', 'message' => 'Perfil atualizado com sucesso!']);
    }

    public function delete(Request $request)
    {
        $role = Role::where('id', $request->id)->first();
        $nome = getPrimeiroNome(Auth::user()->name);

        if(!empty($role)){
            $json = "<b>$nome</b> você tem certeza que deseja excluir este perfil?<br> 
            <span class='text-warning'>Atenção isso pode comprometer sua aplicação, na dúvida contacte o administrador do sistema!</span>";                      
            return response()->json(['error' => $json,'id' => $request->id]);
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }     
    }

    public function deleteon(Request $request)
    {
        $role = Role::where('id', $request->role_id)->first();
        if(!empty($role)){
            $role->delete();
        }
        return redirect()->route('admin.role.index')->with(['color' => 'success', 'message' => 'Perfil removido com sucesso!']);
    }

    public function permissions($role)
    {
        $role = Role::where('id', $role)->first();
        $permissions = Permission::all();

        foreach($permissions as $permission){
            if($role->hasPermissionTo($permission->name)){
                $permission->can = true;
            }else{
                $permission->can = false;
            }
        }

        return view('admin.roles.permissions', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function permissionsSync(Request $request, $role)
    {
        $permissionsRequest = $request->except(['_token', '_method']);

        foreach($permissionsRequest as $key => $value){
            $permissions[] = Permission::where('id', $key)->first();
        }

        $role = Role::where('id', $role)->first();
        if(!empty($permissions)){
            $role->syncPermissions($permissions);
        }else{
            $role->syncPermissions(null);
        }

        return redirect()->route('admin.role.permissions', ['role' => $role->id]);
    }
}
