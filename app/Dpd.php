<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Dpd extends Model
{
    protected $table = 'dpds';

    protected $fillable = ['code', 'name'];

    protected $appends = ['count_asesis'];


    public function users()
    {
    	return $this->belongsToMany('App\User', 'dpd_user');
    }


    public function getCountAsesisAttribute()
    {
    	//return $this->users->count();
        $data = User::with('dpds', 'roles')
                    ->whereHas('roles', function($query){
                        $query->where('id', '=', 4);
                    })
                    ->whereHas('dpds', function($query){
                        $query->where('id', '=', $this->id);
                    })
                    ->get();
        return count($data);

    }

}
