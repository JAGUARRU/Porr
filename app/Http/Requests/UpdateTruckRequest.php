<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateTruckRequest extends FormRequest
{
    public function rules()
    {
        return [
            'truck_province'          => ['required', 'string'],
            'truck_district'          => ['required', 'string'],
            'truck_sub_district'      => ['required', 'string'],
            'truck_postcode'          => ['required', 'numeric']
        ];
    }

    public function messages()
    {
        return [
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