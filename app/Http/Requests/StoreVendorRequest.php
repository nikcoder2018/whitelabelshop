<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorRequest extends FormRequest
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
            'shop_name' => 'required|max:64',
            'email' => 'required|email|unique:vendors,email,'.$this->id,
            'vat' => 'required|max:9',
            'vat_sec' => 'required|max:9',
            'country' => 'required',
            'city' => 'required',
            'firstname' => 'required|max:64',
            'lastname' => 'required|max:64',
            'password' => 'confirmed'
        ];
    }
}
