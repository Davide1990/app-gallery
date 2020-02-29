<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *Rule::unique('users')->ignore($user->id),
     * @return array
     */
    public function rules()
    {
        return [
        
            // tutti i parametri che vengono passati nella request vengono mappati in $this
            // con Rule::unique laravel va a prendersi la mail vecchia salvata nel database, 
            // e verifica che quella che sta passando nel form sia univoca per tutti i record tranne quello
            // del'utente, cioè se 'l'utente la tiene uguale deve essere univoca in tutto il database tranne
            // che per lui
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users','email')->ignore($this->id,'id') 
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => [
                'required',
                Rule::in(['admin','user'])
            ]
        ];
    }
}
