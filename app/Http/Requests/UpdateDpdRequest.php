<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateDpdRequest extends Request
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
            'code'=>'required|unique:dpds,code,'.$this->segment(2).'',
            'name'=>'required|unique:dpds,name,'.$this->segment(2).'',
        ];
    }
}
