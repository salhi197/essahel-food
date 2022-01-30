<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Boutique extends Authenticatable
{
    use Notifiable;

    /**
     * @var string
     */
    protected $guard = 'boutique';

    protected $fillable = [
        'name', 'email', 'password','produits','password_text','adress','telephone'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
    ];
}
