<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MsgUserRequest;
use App\Models\MsgUser;
use Illuminate\Http\Request;

class MsgUserController extends Controller
{
    public function sendUserMsg(MsgUserRequest $request)
    {
        //$criaMsg = MsgUser::create($request->all());
        response()->json($request->all());
    }
}
