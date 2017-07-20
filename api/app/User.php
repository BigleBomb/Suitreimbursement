<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = 'users';
    
    protected $fillable = [
        'privilege', 'nama', 'username', 'email', 'password', 'token', 'limit'
    ];
    
    protected $hidden = [
        'password', 'api_token'
    ];

    public function reimburse(){

        return $this->belongsToMany('App\Reimburse', 'project_user_list', 'user_id', 'project_id');
    }
}
