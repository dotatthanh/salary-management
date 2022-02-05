<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|max:255', 
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($this->user),
            ],
            'gender' => 'required',
            'birthday' => 'required|date',
            'phone' => 'required|size:10',
            'address' => 'required',
            'avatar' => 'image|max:16000',
            'cv' => 'mimes:pdf|max:16000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ và tên là trường bắt buộc.', 
            'name.max' => 'Họ và tên không được dài quá :max ký tự.', 
            'gender.required' => 'Giới tính là trường bắt buộc.',
            'birthday.required' => 'Ngày sinh là trường bắt buộc.',
            'birthday.date' => 'Ngày sinh không đúng định dạng.',
            'phone.required' => 'Số điện thoại là trường bắt buộc.',
            'phone.size' => 'Số điện thoại phải là :size số.',
            'address.required' => 'Địa chỉ là trường bắt buộc.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email chưa đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'email.string' => 'Email phải là một chuỗi.',
            'email.max' => 'Email không được dài quá :max ký tự.',
            'avatar.image' => 'Ảnh đại diện không đúng định dạng (jpg, jpeg, png, bmp, gif, svg hoặc webp).',
            'avatar.max' => 'Ảnh đại diện không được lớn hơn 16MB.',
            'cv.mimes' => 'Hồ sơ làm việc không đúng định dạng pdf.',
            'cv.max' => 'Hồ sơ làm việc không được lớn hơn 16MB.',
        ];
    }
}
