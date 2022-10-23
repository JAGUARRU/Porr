<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateRetailRequest extends FormRequest
{
    public function rules()
    {
        return [
            'retail_province'          => ['required', 'string'],
            'retail_district'          => ['required', 'string'],
            'retail_sub_district'      => ['required', 'string'],
            'retail_postcode'          => ['required', 'numeric']
        ];
    }

    public function messages()
    {
        return [
            'retail_province.required'    => 'โปรดระบุจังหวัด',
            'retail_district.required'    => 'โปรดระบุอำเภอ',
            'retail_sub_district.required'    => 'โปรดระบุตำบล',
            'retail_postcode.required'    => 'โปรดระบุรหัสไปรษณี',
            'retail_postcode.numeric'    => 'รหัสไปรษณีต้องเป็นตัวเลขเท่านั้น'
        ];
    }

    public function authorize()
    {
        return Gate::allows('user_retail_edit_access');
    }
}