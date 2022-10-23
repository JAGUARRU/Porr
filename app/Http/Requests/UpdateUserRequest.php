<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Phattarachai\ThaiIdCardValidation\ThaiIdCardRule;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username'    => [
                'required',
                'string'
            ],
            'name'    => [
                'required',
                'string'
            ],
            'email'   => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
            'password'    => [
                'sometimes'
            ],
            'roles.*' => [
                'integer',
            ],
            'roles'   => [
                'required',
                'array',
            ],
            'inactive' => [
                'integer'
            ],
            'phoneNumber' => [
                'string'
            ],
            'address' => [
                'string'
            ],
            'positions' => [
                'string'
            ],
            'IDCardNumber' => new ThaiIdCardRule
        ];
    }

    public function messages()
    {
        return [
            'email.required'    => 'โปรดระบุชื่อผู้ใช้งาน',
            'username.required'    => 'โปรดระบุชื่อผู้ใช้',
            'name.required'    => 'โปรดระบุชื่อและนามสกุล',
            'email.required'    => 'โปรดระบุที่อยู่อีเมล',
            'roles.required'    => 'โปรดกำหนดสิทธิ์'
        ];
    }

    public function authorize()
    {
        return Gate::allows('user_access');
    }
}