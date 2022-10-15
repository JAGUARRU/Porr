<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreProductCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'     => [
                'required',
                'string',
                'min:2',
                'unique:product_categories,name'
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.min'    => 'โปรดระบุชื่อประเภทสินค้าอย่างน้อย 2 ตัวอักษร',
            'name.string'    => 'โปรดระบุชื่อประเภทสินค้า',
            'name.required'    => 'โปรดระบุชื่อประเภทสินค้า',
            'name.unique'    => 'ชื่อประเภทสินค้านี้ได้ถูกใช้แล้ว'
        ];
    }

    public function authorize()
    {
        return Gate::allows('product_access');
    }
}