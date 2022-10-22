<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Phattarachai\ThaiIdCardValidation\ThaiIdCardRule;

class StoreUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'empId' => [
                'required', 
                'string', 
                'unique:users,empId'
            ],
            'username'    => [
                'required',
                'string'
            ],
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
            ],
            'IDCardNumber' => new ThaiIdCardRule
        ];
    }

    public function messages()
    {
        return [
            'empId.required'=> 'โปรดระบุรหัสพนักงาน',
            'empId.unique'=> 'รหัสพนักงานซ้ำ',
            'email.required'    => 'โปรดระบุชื่อผู้ใช้งาน',
            'username.required'    => 'โปรดระบุชื่อผู้ใช้',
            'name.required'    => 'โปรดระบุชื่อและนามสกุล',
            'email.required'    => 'โปรดระบุที่อยู่อีเมล',
            'password.required'    => 'โปรดระบุรหัสผ่าน',
            'roles.required'    => 'โปรดระบุสิทธิ์',
        ];
    }

    public function authorize()
    {
        return Gate::allows('user_access');
    }
}