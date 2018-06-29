<?php

namespace TiffinService\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardValidator extends FormRequest
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

          'card_number' => 'required|numeric|digits:16',
            'expiration_month' => 'required|numeric|min:1|max:12',
            'expiration_year' => 'required|numeric|min:1|max:9999',
            'cvc' => 'required|numeric|digits:3',
        ];
    }
}
