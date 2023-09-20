<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ClientUser extends Model
{
    use Notifiable;

     protected $guarded =[];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   
}
