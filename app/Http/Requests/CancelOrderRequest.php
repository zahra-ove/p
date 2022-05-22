<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelOrderRequest extends FormRequest
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
            'orderId'=>['required', 'numeric'],
            'jarime'=>['numeric', 'max:999999999'],
            'returnVajhToCustomer'=>['numeric','numeric', 'max:999999999'],
            'paid_amount'=>['numeric','numeric', 'max:999999999'],
            'jarime_pay_way'=>['required','numeric', 'max:7'],
            'returningfish'=>['file', 'max:7'],
            'jarimefish'=>['file', '|max:5120'],       // max file size: 5 MB
        ];
    }
}
