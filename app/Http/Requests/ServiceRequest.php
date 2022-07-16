<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'name' => 'required|unique:services,name',
            // 'email' => 'required',
            'category_id' => 'required'
            // 'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng không để trống',
            'name.unique' => 'Tên dịch vụ đã tồn tại',
            // 'email.required' => 'Vui lòng nhập email',
            'category_id.required' => 'Vui lòng chọn danh mục'
            // 'password.required' => 'Vui lòng nhập mật khẩu'
        ];
    }
}
