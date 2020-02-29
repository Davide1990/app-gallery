<?php

namespace App\Http\Requests;

use App\Album;
use Illuminate\Foundation\Http\FormRequest;

class AlbumUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $album = Album::find($this->id);
        
        /*
        if (\Gate::denies('manage-album', $album)){
            return false;
        }
        */
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
           
        
            'name' => 'required'
           
       
        ];
    }


    public function messages(){

        return [
        'name.required' => 'Il campo "Nome Album" è richiesto',
        'description.required' => 'Il campo "Descrizione Album" è richiesto',
        'album_thumb.required' => 'Il campo "Thumbnail" è richiesto',
       
        ];
    }
}
