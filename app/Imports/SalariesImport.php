<?php

namespace App\Imports;

use App\Models\Salary;
use App\Models\User;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use DateTime;

class SalariesImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::where('code', $row['code'])->first();
        if ($user) {
            $month = str_pad($row['month'], 2, '0', STR_PAD_LEFT);
            $check = Salary::where('user_id', $user->id)->Where('month', $month)->Where('year', $row['year'])->exists();
            if (!$check) {
                Salary::create([
                    'user_id' => $user->id,
                    'month' => $month,
                    'paid_day_off' => $row['paid_day_off'],
                    'year' => $row['year'],
                    'unpaid_day_off' => $row['unpaid_day_off'],
                    'total_working_days' => $row['total_working_days'],
                    'salary' => $row['salary'],
                    'total_days_off' => $row['paid_day_off'] + $row['unpaid_day_off'],
                ]);
            }
            else {
            }

        }
    }

    public function rules(): array
    {
        return [
            '*.paid_day_off' => 'required|numeric|min:0', 
            '*.unpaid_day_off' => 'required|numeric|min:0', 
            '*.total_working_days' => 'required|numeric|min:0',
            '*.salary' => 'required|numeric|min:0',
            '*.month' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12',
            '*.year' => 'required|numeric|min:1',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'paid_day_off.required' => 'Ngày nghỉ phép là trường bắt buộc.', 
            'paid_day_off.numeric' => 'Ngày nghỉ phép là giá trị số.', 
            'paid_day_off.min' => 'Ngày nghỉ phép nhỏ nhất là :min.', 
            'unpaid_day_off.required' => 'Ngày nghỉ không phép là trường bắt buộc.', 
            'unpaid_day_off.min' => 'Ngày nghỉ không phép nhỏ nhất là :min.', 
            'unpaid_day_off.numeric' => 'Ngày nghỉ không phép là giá trị số.', 
            'total_working_days.required' => 'Tổng số ngày làm việc là trường bắt buộc.',
            'total_working_days.min' => 'Tổng số ngày làm việc nhỏ nhất là :min.', 
            'total_working_days.numeric' => 'Tổng số ngày làm việc là giá trị số.', 
            'salary.required' => 'Tổng tiền lương là trường bắt buộc.',
            'salary.numeric' => 'Tổng tiền lương là giá trị số.', 
            'salary.min' => 'Tổng tiền lương nhỏ nhất là :min.', 
            'month.required' => 'Tháng là trường bắt buộc.',
            'month.in' => 'Tháng là các giá trị: 01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12.',
            'year.required' => 'Năm là trường bắt buộc.',
            'year.numeric' => 'Năm là giá trị số.',
            'year.min' => 'Năm nhỏ nhất là :min.', 
        ];
    }
}
