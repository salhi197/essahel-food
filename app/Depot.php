<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Depot extends Authenticatable
{
    use Notifiable;

    protected $guard = 'depot';

    protected $fillable = [
        'name', 'email', 'password','paswword_text'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
