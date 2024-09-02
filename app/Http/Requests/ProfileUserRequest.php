<?php

namespace App\Http\Requests;

use App\Rules\VietnamPhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:4',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(auth()->user()->id), // Bỏ qua kiểm tra đối với chính bản ghi đang cập nhật
            ],
            'phone' => [
                'required',
                'string',
                new VietnamPhone,
                Rule::unique('users', 'phone')->ignore(auth()->user()->id), // Bỏ qua kiểm tra đối với chính bản ghi đang cập nhật
            ],
            'address' => 'nullable|string',
            'avatar' => 'nullable|max:2048',
            'province_id' => 'nullable',
            'district_id' => 'nullable',
            'ward_id' => 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên không được nhỏ hơn 4 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu không được nhỏ hơn 8 ký tự',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'address.required' => 'Địa chỉ không được để trống',
            'avatar.required' => 'Vui lòng chọn ảnh đại diện.',
            'avatar.max' => 'Hình ảnh đã vượt 2MB.',
            'province_id.required' => 'Tỉnh không được để trống',
            'district_id.required' => 'Huyện không được để trống',
            'ward_id.required' => 'Xã không được để trống',
        ];
    }
}