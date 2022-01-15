<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        $companies = Company::all();
        return view('employees.employees',compact('employees','companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest  $request)
    {

        $input = $request->all();

        $email_exists = Employee::where('email','=',$input['email'])->exists();

        if($email_exists){
            session()->flash('Error', 'خطأ الإيميل مسجل مسبقا');
            return redirect('/employees');
             }else{
                Employee::create([
                    'first_name'   => $request->first_name,
                    'last_name'    => $request->last_name,
                    'company_id'   => $request->company_id,
                    'email'        => $request->email,
                    'phone'        => $request->phone,
                    'linkedin_url' => $request->linkedin_url,
                ]);
                session()->flash('Add', 'تم اضافة العميل بنجاح ');
                return redirect('/employees');
             }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [

            'email' => 'required|unique:employees,email,'.$id,
        ],[

            'email.required' =>'يرجي ادخال الإيميل',
            'email.unique'   =>'الإيميل مسجل مسبقا',
        ]);

        $id = Company::where('name', $request->name)->first()->id;

        $employee = Employee::findOrFail($request->id);
 
        $employee->update([
        'first_name'   => $request->first_name,
        'last_name'    => $request->last_name,
        'email'        => $request->email,
        'phone'        => $request->phone,
        'linkedin_url' => $request->linkedin_url,
        'company_id'   => $id,
        ]);
 
        session()->flash('Edit', 'تم التعديل  بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Employee::findOrFail($request->id)->delete();
        session()->flash('delete','تم حذف العميل بنجاح');
        return redirect('/employees');
    }
}
