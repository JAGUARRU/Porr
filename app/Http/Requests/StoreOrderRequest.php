<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', 'string', 'unique:orders'],
            'retail_id'             => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id.required'=> 'โปรดระบุออเดอร์',
            'retail_id.required'    => 'โปรดเลือกร้านค้าจากระบบ'
        ];
    }

    public function authorize()
    {
        return Gate::allows('employee_order_add_access');
    }
}