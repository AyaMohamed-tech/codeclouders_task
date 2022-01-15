<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|unique:employees,phone',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'يرجي إدخال الاسم الاول',
            'last_name.required' => 'يرجي إدخال الاسم الثاني',
            'email.email' => 'صيغة الايميل غير صحيحة',
            'email.required' => 'يرجي إدخال الإيميل',
            'email.unique' => 'الإيميل مستخدم مسبقا',
            'phone.required' => 'يرجي إدخال رقم الموبيل',
            'phone.unique' => 'رقم الموبيل مستخدم مسبقا',
        ];
    }
}
