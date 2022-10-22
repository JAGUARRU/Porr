<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', 'string', 'unique:products'],
            'prod_price' => [
                'required',
                'numeric'
            ],
            'prod_type_name' => [
                'required',
                'string'
            ],
            'prod_name' => [
                'required',
                'string'
            ]
        ];
    }

    public function messages()
    {
        return [
            'id.required'=> 'โปรดระบุรหัสสินค้า',
            'id.unique'=> 'รหัสสินค้าซ้ำ',
            'prod_name.required'=> 'โปรดระบุชื่อสินค้า',
            'prod_type_name.required'=> 'โปรดระบุประเภทสินค้า',
            'prod_price.required'=> 'โปรดระบุราคาสินค้า',
            'prod_name.unique'=> 'รายการสินค้าซ้ำกัน (ชื่อสินค้าและประเภทสินค้านี้มีอยู่ในฐานข้อมูลแล้ว)'
        ];
    }

    public function authorize()
    {
        return Gate::allows('employee_product_add_access');
    }
}