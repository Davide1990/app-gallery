<?php


//php artisan make:model Photo -m 
// -m per creare anche la migrazione

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function getPathAttribute(){

        $url = $this->img_path;
        if (stristr($this->img_path, 'images') !== false){
            $url = 'storage/'. $this->img_path; //in base alla cartella public
        }
        return $url;

    }

    public function album(){
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }

    
}
