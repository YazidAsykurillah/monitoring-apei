<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $role_id = $this->request->get('role_id');

        if($role_id && $role_id == 4){      //rules for member
            $rules =  [
                'dpd_id'=>'required',
                'name'=>'required',
                'email'=>'required|email|unique:users,email',
                'id_card'=>'required',
                'telephone'=> 'required'
            ];    
        }elseif($role_id && $role_id == 3 ){    //rules for Admin DPD
            $rules =  [
                'dpd_id'=>'required',
                'name'=>'required',
                'email'=>'required|email|unique:users,email',
            ];
        }elseif($role_id && $role_id == 2){     //rules for Admin DPP 
            $rules =  [
                'name'=>'required',
                'email'=>'required|email|unique:users,email',
            ];    
        }
        else{
            exit("Missing role");
        }
        return $rules;
        
    }
}
