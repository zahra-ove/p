<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        'name'=>'required',
        'family'=>'required',
        'ncode'=>'required|numeric|digits:10',
        'mobilecode'=>'required|numeric|digits:11',
        'mobiles'=>'numeric|digits:11',
        'cardnumber'=>'required|numeric',
        'city_id'=>'required',
        'addrTitle'=>'required',
        'addr'=>'required',
        ];
    }

    public function messages()
    {
        return [

        ];
}
}
