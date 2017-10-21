<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ChangePasswordRequest extends Request
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
        /*print_r($this->request->get('default_password'));
        exit();*/
        if($this->request->get('default_password') == 'on'){
            $rules = [];
        }
        else{
            $rules = [
                'password'=>'required',
                'password_conf'=>'required|same:password'
            ];    
        }
        return $rules;
        
    }
}
