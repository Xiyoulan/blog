<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{

    protected $redirect;

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
        $this->redirect = route('users.show',[\Auth::id(),'tab'=>'edit']);
        return [
        'oldPassword' => 'required',
        'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'oldPassword.required' => '旧密码不能为空.',
        ];
    }

}
