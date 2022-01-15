<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'name'        =>       'required|unique:companies|max:255',
            'email'       =>       'required|email|unique:companies|max:255',
            'logo'        =>       'required|mimes:jpeg,png,jpg',
            'website_url' =>       'required|unique:companies'
        ];
    }

    public function messages()
    {
        return [
            'name.required'        =>'يرجي ادخال اسم الشركة',
            'email.required'       =>'يرجي ادخال الايميل',
            'email.email'          => 'صيغة الايميل غير صحيحة',
            'logo.required'      =>'يرجي ادخال شعار الشركة',
            'name.unique'          =>'اسم الشركة مسجل مسبقا',
            'email.unique'         =>'الايميل مستخدم مسبقا',
            'website_url.unique'   =>'اللينك مستخدم مسبقا',
            'website_url.required' =>'يرجي إدخال لينك موقع الشركة',
            'logo.mimes'           => 'صيغة المرفق يجب ان تكون  jpeg , png , jpg',
        ];
    }
}
