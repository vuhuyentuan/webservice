<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'account_name' => 'required|max:50',
            'account_number' => 'required|unique:banks,account_number|max:20',
            'bank_name' => 'required|max:50',
            'branch' => 'max:255',
        ];
    }
    public function messages()
    {
        return [
            'account_name.required' => 'Vui lòng nhập họ tên chủ tài khoản',
            'account_name.max' => 'Giới hạn 50 ký tự',
            'account_number.required' => 'Vui lòng nhập số tài khoản',
            'account_number.unique' => 'Số tài khoản đã tồn tại',
            'account_number.max' => 'Giới hạn 20 ký tự',
            'bank_name.required' => 'Vui lòng nhập tên tài khoản',
            'bank_name.max' => 'Giới hạn 50 ký tự',
            'branch.max' => 'Giới hạn 255 ký tự'
        ];
    }
}
