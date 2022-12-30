<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class User extends FormRequest
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

    public function all($keys = null)
    {
        return $this->validateFields(parent::all());
    }

    public function validateFields(array $inputs)
    {
        $inputs['rg'] = str_replace(['.', '-'], '', $this->request->all()['rg']);
        return $inputs;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'Type' => 'required|array',
            'name' => 'required|min:3|max:191',
            'nasc' => 'required|date_format:d/m/Y',
            'genero' => 'required|in:masculino,feminino',
            //'estado_civil' => 'required|in:casado,separado,solteiro,divorciado,viuvo',
            'rg' => (!empty($this->request->all()['id']) ? 'required|min:9|max:12|unique:users,rg,' . $this->request->all()['id'] : 'required|min:9|max:12|unique:users,rg'),
            //'rg' => 'required_if:client,on|min:8|max:12',
            //'rg' => 'required|min:8|max:12',
            //'rg_expedicao' => 'required',
            //'naturalidade' => 'required_if:client,on',
            //'avatar' => 'image',
            
            
            
            // Access
            'email' => (!empty($this->request->all()['id']) ? 'required|email|unique:users,email,' . $this->request->all()['id'] : 'required|email|unique:users,email'),
            //'password' => (empty($this->request->all()['id']) ? 'required' : ''),
            
            // Contact
            'celular' => 'required',                        
           
        ];
    }
}
