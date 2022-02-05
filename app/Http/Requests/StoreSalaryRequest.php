<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalaryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'paid_day_off' => 'required|numeric|min:0', 
            'unpaid_day_off' => 'required|numeric|min:0', 
            // 'total_days_off' => 'required', 
            'total_working_days' => 'required|numeric|min:0',
            'salary' => 'required|numeric|min:0',
            'month' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12|numeric|min:1',
            'year' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Nhân viên là trường bắt buộc.',
            'paid_day_off.required' => 'Ngày nghỉ phép là trường bắt buộc.', 
            'paid_day_off.numeric' => 'Ngày nghỉ phép là giá trị số.', 
            'paid_day_off.min' => 'Ngày nghỉ phép nhỏ nhất là :min.', 
            'unpaid_day_off.required' => 'Ngày nghỉ không phép là trường bắt buộc.', 
            'unpaid_day_off.min' => 'Ngày nghỉ không phép nhỏ nhất là :min.', 
            'unpaid_day_off.numeric' => 'Ngày nghỉ không phép là giá trị số.', 
            // 'total_days_off.required' => 'Tổng số ngày nghỉ là trường bắt buộc.', 
            'total_working_days.required' => 'Tổng số ngày làm việc là trường bắt buộc.',
            'total_working_days.min' => 'Tổng số ngày làm việc nhỏ nhất là :min.', 
            'total_working_days.numeric' => 'Tổng số ngày làm việc là giá trị số.', 
            'salary.required' => 'Tổng tiền lương là trường bắt buộc.',
            'salary.numeric' => 'Tổng tiền lương là giá trị số.', 
            'salary.min' => 'Tổng tiền lương nhỏ nhất là :min.', 
            'month.required' => 'Tháng là trường bắt buộc.',
            'month.in' => 'Tháng là các giá trị: 01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12.',
            'month.min' => 'Tháng nhỏ nhất là :min.', 
            'month.numeric' => 'Tháng là giá trị số.',
            'year.required' => 'Năm là trường bắt buộc.',
            'year.numeric' => 'Năm là giá trị số.',
            'year.min' => 'Năm nhỏ nhất là :min.', 
        ];
    }
}
