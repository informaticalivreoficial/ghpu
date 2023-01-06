<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginRg(Request $request)
    {
        if ($request->rg == '') {
            $json['message'] = $this->message->error('Ooops, informe todos os dados para efetuar o login')->render();
            return response()->json($json);
        }
        
        $user = User::where('rg', $this->clearField($request->rg))->first();

        $credentials = [
            'email' => $user->email,
            'password' => $user->password,
            //'remember_me' => $request->remember_me,
        ];        
        
        if (Auth::login($user, true)) {
            $json['message'] = $this->message->error('Ooops, usuário não existe ou dados inválidos')->render();
            return response()->json($json);
        }
                        
        $this->authenticated($request->getClientIp());
        $json = ([
            'redirect' => route('home'),
            'msg' => 'Seja Bem vindo de volta '.\App\Helpers\Renato::getPrimeiroNome(Auth::user()->name)
        ]);
        return response()->json($json);
    }

    private function authenticated(string $ip)
    {
        $user = User::where('id', Auth::user()->id);
        $user->update([
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $ip,
        ]);
    }

    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
