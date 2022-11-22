<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class MenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(Request::input('tipo') == 'pagina'){ 
            $rules = [     
                'titulo' => 'required|min:3|max:191',
                'tipo' => 'required', 
                'post' => 'required',
            ]; 
        }else{
            $rules = [ 
                'titulo' => 'required|min:3|max:191',
                'tipo' => 'required', 
            ];
        }
        return $rules;
    }
}
