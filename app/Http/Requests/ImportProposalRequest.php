<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ImportProposalRequest extends Request
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
            'dpd_id'=>'required|integer|exists:dpds,id',
            'type'=>'required',
            'file'=>'required'
        ];
    }
}
