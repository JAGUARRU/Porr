<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'     => [
                'required',
                'string'
            ],
            'email'    => [
                'required',
                'unique:users',
            ],
            'password' => [
                'required'
            ],
            'roles.*'  => [
                'integer',
            ],
            'roles'    => [
                'required',
                'array',
            ],
            'inactive' => [
                'integer'
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required'    => 'โปรดระบุชื่อผู้ใช้งาน',
            'email.required'    => 'โปรดระบุที่อยู่อีเมล',
            'password.required'    => 'โปรดระบุรหัสผ่าน',
            'roles.required'    => 'โปรดระบุบทบาท',
        ];
    }

    public function authorize()
    {
        return Gate::allows('user_access');
    }
}