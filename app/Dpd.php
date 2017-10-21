<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dpd extends Model
{
    protected $table = 'dpds';

    protected $fillable = ['code', 'name'];


    public function users()
    {
    	return $this->belongsToMany('App\User', 'dpd_user');
    }
}
