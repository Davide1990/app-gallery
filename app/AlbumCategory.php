<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class AlbumCategory extends Model
{
    protected $table = 'album_categories';

    public function albums(){
        return $this->belongsToMany(Album::class, 'album_category','category_id','album_id')->withTimestamps();
        ;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    // utilizziamo il local scope, in cui laravel ci passa automaticamente il queryBuilder
    public function scopeGetCategoriesByUserId(Builder $queryBuilder, User $user){
        $queryBuilder->where('user_id',$user->id)->withCount('albums')->latest();
        return $queryBuilder;
    }

}
