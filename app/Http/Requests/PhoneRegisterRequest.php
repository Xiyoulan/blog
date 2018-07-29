<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneRegisterRequest extends FormRequest
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
            'phone' => "required_without_all:name,password|regex:/^1[345678]\d{9}$/|unique:users",
            'name' =>"required_without:phone|string|max:25|unique:users",
            'password' => "required_without:phone|string|min:6|confirmed"
            
        ];
    }

}
