<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

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
            'positions'   => [
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
            'email.required'    => 'โปรดระบุชื่อผู้ใช้งาน',
            'name.required'    => 'โปรดระบุชื่อและนามสกุล',
            'email.required'    => 'โปรดระบุที่อยู่อีเมล',
            'password.required'    => 'โปรดระบุรหัสผ่าน',
            'roles.required'    => 'โปรดกำหนดบทบาท',
            'positions.required'    => 'โปรดกำหนดตำแหน่ง',
        ];
    }

    public function authorize()
    {
        return Gate::allows('user_access');
    }
}