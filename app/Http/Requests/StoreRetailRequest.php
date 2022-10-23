<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRetailRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', 'string', 'unique:retails'],
            'retail_province'          => ['required', 'string'],
            'retail_district'          => ['required', 'string'],
            'retail_sub_district'      => ['required', 'string'],
            'retail_postcode'          => ['required', 'numeric']
        ];
    }

    public function messages()
    {
        return [
            'id.required'=> 'โปรดระบุรหัสร้านค้า',
            'id.unique'=> 'รหัสร้านค้าซ้ำ',
            'retail_province.required'    => 'โปรดระบุจังหวัด',
            'retail_district.required'    => 'โปรดระบุอำเภอ',
            'retail_sub_district.required'    => 'โปรดระบุตำบล',
            'retail_postcode.required'    => 'โปรดระบุรหัสไปรษณี',
            'retail_postcode.numeric'    => 'รหัสไปรษณีต้องเป็นตัวเลขเท่านั้น'
        ];
    }

    public function authorize()
    {
        return Gate::allows('employee_retail_add_access');
    }
}