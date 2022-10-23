<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTruckRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', 'string', 'unique:trucks'],
            'plateNumber'             => ['required', 'unique:trucks,plateNumber'],
            'truck_province'          => ['required', 'string'],
            'truck_district'          => ['required', 'string'],
            'truck_sub_district'      => ['required', 'string'],
            'truck_postcode'          => ['required', 'numeric']
        ];
    }

    public function messages()
    {
        return [
            'id.required'    => 'โปรดระบุรหัสรถ',
            'id.unique'    => 'รหัสรถได้ถูกใช้แล้ว', 
            'user_id.unique'    => 'คนขับรถนี้ได้ถูกใช้แล้ว',
            'plateNumber.required'    => 'โปรดระบุหมายเลขป้ายทะเบียน',
            'plateNumber.unique'    => 'ป้ายทะเบียนที่ระบุได้ถูกใช้แล้ว',
            'truck_province.required'    => 'โปรดระบุจังหวัด',
            'truck_district.required'    => 'โปรดระบุอำเภอ',
            'truck_sub_district.required'    => 'โปรดระบุตำบล',
            'truck_postcode.required'    => 'โปรดระบุรหัสไปรษณี',
            'truck_postcode.numeric'    => 'รหัสไปรษณีต้องเป็นตัวเลขเท่านั้น'
        ];
    }

    public function authorize()
    {
        return Gate::allows('truck_access');
    }
}