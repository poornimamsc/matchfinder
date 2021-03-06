<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
    {   //otp_mobile|
        return [
            'captcha'      => 'required|captcha',
            'username'      => 'required',
            'email' => 'required|unique:users,email',
            'mobile_number'      => 'required|unique:users,mobile_number',
            'password'      => 'required'

        ];
    }
}
