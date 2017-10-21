<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\User;
use App\Role;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','id_card', 'passport', 'telephone', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function roles(){

        return $this->belongsToMany('App\Role');
    }

    //----Authorization blocks--
    public function hasRole($role)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        if (is_string($role)) {
            return $this->role->contains('name', $role);
        }
        return !! $this->roles->intersect($role)->count();
    }

    public function isSuperAdmin()
    {
       if ($this->roles->contains('name', 'Super Admin')) {
            return true;
        }
        return false;
    }
    //----ENDAuthorization blocks---


    public function dpds()
    {
        return $this->belongsToMany('App\Dpd', 'dpd_user');
    }

    public function proposals()
    {
        return $this->hasMany('App\Proposal', 'user_id');
    }
}
