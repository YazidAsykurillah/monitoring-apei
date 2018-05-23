<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ChangeProfilePasswordRequest extends Request
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
        return [
            'new_password'=>'required|min:6',
            'password_conf'=>'required|same:new_password'
        ];
    }
}
