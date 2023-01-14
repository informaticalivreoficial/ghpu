<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\User as UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cidades;
use App\Models\Empresa;
use App\Models\Estados;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        if(Auth::user()->editor == 1){
            return Redirect::route('colaborador');
        }

        $users = User::orderBy('created_at', 'DESC')
                ->orderBy('status', 'ASC')
                ->where('client', '1')
                ->orWhere('editor', '1')                
                ->paginate(25);

        return view('admin.users.index',[
            'users' => $users
        ]);
    }

    public function show($id)
    {
        if(Auth::user()->editor == 1){
            return Redirect::route('colaborador');
        }

        $user = User::where('id', $id)->first();
        return view('admin.users.view',[
            'user' => $user
        ]);
    }

    public function team()
    {
        if(Auth::user()->editor == 1){
            return Redirect::route('colaborador');
        }

        $users = User::where('admin', '=', '1')->paginate(12);
        return view('admin.users.team', [
            'users' => $users    
        ]);
    }

    public function userSetStatus(Request $request)
    {        
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success' => true]);
    }

    public function fetchCity(Request $request)
    {
        $data['cidades'] = Cidades::where("estado_id",$request->estado_id)->get(["cidade_nome", "cidade_id"]);
        return response()->json($data);
    } 
    
    public function create()
    {
        if(Auth::user()->editor == 1){
            return Redirect::route('colaborador');
        }

        $estados = Estados::orderBy('estado_nome', 'ASC')->get();
        $cidades = Cidades::orderBy('cidade_nome', 'ASC')->get(); 
        $empresas = Empresa::orderBy('alias_name', 'ASC')->available()->get();    
        
        $roles = Role::all();

        foreach($roles as $role) {
            $role->can = false;
        }

        return view('admin.users.create',[
            'estados' => $estados,
            'cidades' => $cidades,
            'empresas' => $empresas,
            'roles' => $roles
        ]);
    }
    
    public function store(UserRequest $request)
    {
        $data = $request->all();
        if($request->client == '' && $request->admin == '' && $request->editor == '' && $request->superadmin == ''){
            $data['editor'] = 'on';
        }        

        if($request->password == ''){
            $data['password'] = bcrypt($request->email);
        }        

        $userCreate = User::create($data);
        if(!empty($request->file('avatar'))){
            $userCreate->avatar = $request->file('avatar')->storeAs(env('AWS_PASTA') . 'user', Str::slug($request->name)  . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('avatar')->extension());
            $userCreate->save();
        }

        $rolesRequest = $request->all();
        $roles = null;
        foreach($rolesRequest as $key => $value) {
            if(Str::is('acl_*', $key) == true){
                $roles[] = Role::where('id', ltrim($key, 'acl_'))->first();
            }
        }

        if(!empty($roles)){
            $userCreate->syncRoles($roles);
        } else {
            $userCreate->syncRoles(null);
        }

        return redirect()->route('users.edit', $userCreate->id)->with(['color' => 'success', 'message' => 'Cadastro realizado com sucesso!']);        
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();   
        $empresas = Empresa::orderBy('alias_name', 'ASC')->available()->get(); 
        $estados = Estados::orderBy('estado_nome', 'ASC')->get();
        $cidades = Cidades::orderBy('cidade_nome', 'ASC')->get(); 

        $roles = Role::all();

        foreach($roles as $role) {
            if ($user->hasRole($role->name)){
                $role->can = true;
            } else {
                $role->can = false;
            }
        }
        
        return view('admin.users.edit', [
            'user' => $user,
            'estados' => $estados,
            'cidades' => $cidades,
            'empresas' => $empresas,
            'roles' => $roles
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::where('id', $id)->first();       
        
        $user->setAdminAttribute($request->admin);
        $user->setEditorAttribute($request->editor);
        $user->setClientAttribute($request->client);
        $user->setSuperAdminAttribute($request->superadmin);

        $nasc = Carbon::createFromFormat('d/m/Y', $request->nasc)->format('d-m-Y');        
        
        if(Carbon::parse($nasc)->age < 18){
            return redirect()->back()->with(['color' => 'danger', 'message' => 'Data de nascimento inválida!']);
        }

        if(!empty($request->file('avatar'))){
            Storage::delete($user->avatar);
            $user->avatar = '';
        }

        $user->fill($request->all());

        if(!empty($request->file('avatar'))){
            $user->avatar = $request->file('avatar')->storeAs(env('AWS_PASTA') . 'user', Str::slug($request->name)  . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('avatar')->extension());
        }

        if(!$user->save()){
            return redirect()->back()->withInput()->withErrors('erro');
        }

        $rolesRequest = $request->all();
        $roles = null;
        foreach($rolesRequest as $key => $value) {
            if(Str::is('acl_*', $key) == true){
                $roles[] = Role::where('id', ltrim($key, 'acl_'))->first();
            }
        }

        if(!empty($roles)){
            $user->syncRoles($roles);
        } else {
            $user->syncRoles(null);
        }

        return redirect()->route('users.edit', $user->id)->with([
            'color' => 'success', 
            'message' => 'Usuário atualizado com sucesso!'
        ]);
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $users = User::where(function($query) use ($request){
            if($request->filter){
                $query->orWhere('name', 'LIKE', "%{$request->filter}%");
                $query->orWhere('email', $request->filter);
            }
        })->where('client', '1')->paginate(25);

        return view('admin.users.index',[
            'users' => $users,
            'filters' => $filters
        ]);
    }

    public function delete(Request $request)
    {
        if(Auth::user()->editor == 1){
            return Redirect::route('colaborador');
        }
        
        $user = User::where('id', $request->id)->first();
        $nome = \App\Helpers\Renato::getPrimeiroNome(Auth::user()->name);
        if(!empty($user)){
            if($user->id == Auth::user()->id){
                $json = "<b>$nome</b> você não pode excluir sua própria conta!";
                return response()->json(['error' => $json,'id' => $user->id]);
            }elseif($user->superadmin == 1){
                $json = "<b>$nome</b> você não pode excluir um Super Administrador!";
                return response()->json(['error' => $json,'id' => $user->id]);
            }elseif($user->admin == 1 && $user->client == 1){
                $json = "<b>$nome</b> você tem certeza que deseja excluir este Administrador? Ele também é um Cliente";
                return response()->json(['error' => $json,'id' => $user->id]);
            }elseif($user->admin == 1){
                $json = "<b>$nome</b> você tem certeza que deseja excluir um Administrador?";
                return response()->json(['error' => $json,'id' => $user->id]);
            }elseif($user->admin == 0 && $user->client == 1){
                $json = "<b>$nome</b> você tem certeza que deseja excluir este Cliente?";
                return response()->json(['error' => $json,'id' => $user->id]);
            }else{
                return response()->json(['success' => true]);
            }
        }
    }

    public function deleteon(Request $request)
    {
        if(Auth::user()->editor == 1){
            return Redirect::route('colaborador');
        }

        $user = User::where('id', $request->user_id)->first();        
        if(!empty($user)){
            $perfil = ($user->admin == '1' && $user->client == '1' ? 'Administrador e Cliente' :
                      ($user->admin == '1' && $user->client == '0' ? 'Administrador' :
                      ($user->admin == '0' && $user->client == '1' ? 'Cliente' : 'Cliente')));
            Storage::delete($user->avatar);
            //Cropper::flush($user->avatar);
            $user->delete();
        }
        if($user->admin == '1' || $user->Editor == '1'){
            $page = 'team';
        }else{
            $page = 'index';
        }
        
        return redirect()->route('users.'.$page)->with(['color' => 'success', 'message' => $perfil.' removido com sucesso!']);
    }

    public function showColaborador($id)
    {
        $user = User::where('id', $id)->first();

        if(Auth::user()->id == $user->id){
            return Redirect::route('users.edit', Auth::user()->id);
        }

        return view('admin.users.colaborador-view',[
            'user' => $user
        ]);
    }
}
