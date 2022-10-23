<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateOrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'retail_id'             => 'required'
        ];
    }

    public function messages()
    {
        return [
            'retail_id.required'    => 'โปรดเลือกร้านค้าจากระบบ'
        ];
    }
    
    public function authorize()
    {
        return Gate::allows('user_order_edit_access');
    }
}