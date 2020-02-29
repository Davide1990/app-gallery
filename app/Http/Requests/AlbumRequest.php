<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          
            'name' => 'required|unique:albums,album_name',
            
            'album_thumb' => 'required|image'
        ];
    }

    public function messages(){

        return [
        'name.required' => 'Il campo "Nome Album" è richiesto',
        'description.required' => 'Il campo "Descrizione Album" è richiesto',
        'album_thumb.required' => 'Il campo "Thumbnail" è richiesto',
        'name.unique' => 'Nome Album già esistente',
        ];
    }

    
}
