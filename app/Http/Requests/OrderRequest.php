<?php

namespace App\Http\Requests;

use App\Rules\IsdateRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'bargasht'=>['required',IsdateRule::class],
            'raft'=>['required',IsdateRule::class],
            'user_id'=>['required'],
            'takht_id'=>['required'],
            'finallyPrice'=>['required','numeric'],
            'totalPrice'=>['required','numeric'],

        ];
    }
}
