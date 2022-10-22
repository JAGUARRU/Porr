<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateProductCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'     => [
                'required',
                'string',
                'unique:product_categories,name'
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.string'    => 'โปรดระบุชื่อประเภทสินค้า',
            'name.required'    => 'โปรดระบุชื่อประเภทสินค้า',
            'name.unique'    => 'ชื่อประเภทสินค้านี้ได้ถูกใช้แล้ว'
        ];
    }

    public function authorize()
    {
        return Gate::allows('employee_product_category_edit_access');
    }
}