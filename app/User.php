<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    // di default created_at e updated_at sono istanze di carbon, perciò se crei altre colonne in formato data e vuoi 
    // cambiare formattazione devi aggiungeerla a questo array in modo che laravel sappia che sono di tipo carbon,
    // altrimenti la vedrebbe come una stringa
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userhasmany(){
        return $this->hasMany(Album::class);
    }

    public function getFullNameAttribute(){
        return $this->name;
    }

    public function albumCategories(){
        return $this->hasMany(AlbumCategory::class);
    }

    public function isAdmin(){
        return $this->role === 'admin';
    }

}
