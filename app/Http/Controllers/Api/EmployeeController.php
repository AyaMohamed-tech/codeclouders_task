<?php

namespace App\Http\Controllers\Api;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return EmployeeResource::collection($employees);
    }

    public function store(StoreEmployeeRequest $request)
    {

        $input = $request->all();

        $email_exists = Employee::where('email','=',$input['email'])->exists();

        if($email_exists){
            return ' خطأ الإيميل مسجل مسبقا';
             }else{
               $employee =  Employee::create([
                    'first_name'   => $request->first_name,
                    'last_name'    => $request->last_name,
                    'company_id'   => $request->company_id,
                    'email'        => $request->email,
                    'phone'        => $request->phone,
                    'linkedin_url' => $request->linkedin_url,
                ]);

                return new EmployeeResource($employee);
             }
    }

    public function update(Request $request,$id)
    {

        $this->validate($request, [

            'email' => 'required|unique:employees,email,'.$id,
        ],[

            'email.required' =>'يرجي ادخال الإيميل',
            'email.unique' =>'الإيميل مسجل مسبقا',
        ]);


        $employee = Employee::findOrFail($id);
 
        $employee->update([
        'first_name'  => $request->first_name,
        'last_name'   => $request->last_name,
        'email'       => $request->email,
        'phone'       => $request->phone,
        ]);
 
        return new EmployeeResource($employee);
    }

    public function destroy(Request $request,$id)
    {
       $id = $request->id;
       $employee =  Employee::findOrFail($id);
       $employee->delete();
       return new EmployeeResource($employee);  
    }
}
