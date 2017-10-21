<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Dpd;
use App\User;
use App\Proposal;

class Select2Controller extends Controller
{

    public function select2User(Request $request){
    	$data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = User::with('dpds', 'roles')
            		->whereHas('roles', function($query){
            			$query->where('id', '=', 4);
            		})
            		->where('name','LIKE',"%$search%")
            		->get();
        }
        else{
            $search = $request->q;
            $data = User::with('dpds', 'roles')
            		->whereHas('roles', function($query){
            			$query->where('id', '=', 4);
            		})
            		->get();
            
        }
        return response()->json($data);
    }

    public function select2Dpd(Request $request){
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Dpd::where('name','LIKE',"%$search%")
                    ->get();
        }
        else{
            $search = $request->q;
            $data = Dpd::all();
        }
        return response()->json($data);
    }
}
