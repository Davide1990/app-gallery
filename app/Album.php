<?php


namespace App;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model {

    protected $fillable = ['album_name', 'description','user_id'];
    
    public function getPathAttribute(){

        $url = $this->album_thumb;
        if (stristr($this->album_thumb, 'images') !== false){
            $url = 'storage/'. $this->album_thumb; //della cartella public
        }
        return $url;

    }

    public function photos(){

        // in automatico laravel come secondo parametro si prende la foreign key della tabella photo e come
        // terzo parametro la chiave primaria della tabella album, se le chiavi esterne vengono chiamate
        // con il nome del model minuscolo_id e le chiavi primarie chiamate id, altrimenti bisogna
        // indicarli 
        return $this->hasMany(Photo::class, 'album_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        // withTimestamp() per popolare anche created at e updated at
        return $this->belongsToMany(AlbumCategory::class, 'album_category', 'album_id', 'category_id')->withTimestamps();
    }

    // un album appartiene a tante categorie
    // come secondo parametro diciamo qual'è la tabella della relazione many to many
    // come terzo parametro diciamo qual'è la colonna della tabella pivot a cui fa riferimento questo model
    // come quarto gli diciamo qual'è l'altra colonna con cui si relaziona
}