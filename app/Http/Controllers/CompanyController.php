<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailTrap;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return view('companies.companies',compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {

        $input = $request->all();

        $image = $request->file('logo');
        $logo = $image->getClientOriginalName();
        
        $b_exists = Company::where('name','=',$input['name'])->exists();

        if($b_exists){
            session()->flash('Error', 'خطأ الشركة مسجله مسبقا');
            return redirect('/companies');
        }else{

            $company =  new Company();
            $company->logo = $logo;
            $company->name = $request->name;
            $company->email = $request->email;
            $company->website_url = $request->website_url;
            $company->save();

          //move pic
          $imageName = $request->logo->getClientOriginalName();
          $request->logo->move(public_path('Logos/'. $request->name), $imageName);
          
          //sending mail
          Mail::to($request->user())->send(new MailTrap($company));


         session()->flash('Add', 'تم إضافة الشركة بنجاح');
         return redirect('/companies');
         
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
             $id = $request->id;

             $image = $request->file('logo');
             $logo = $image->getClientOriginalName();

        $this->validate($request, [

            'name' => 'required|max:255|unique:companies,name,'.$id,
        ],[

            'name.required' =>'يرجي ادخال اسم الشركة',
            'name.unique' =>'اسم الشركة مسجل مسبقا',

        ]);

        $company = Company::find($id);
        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'website_url' => $request->website_url,
            'logo' => $logo,
        ]);

        //move pic
        $imageName = $request->logo->getClientOriginalName();
        $request->logo->move(public_path('Logos/'. $request->name), $imageName);

        session()->flash('edit','تم تعديل الشركة بنجاج');
        return redirect('/companies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Companies  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $company = Company::find($id);
        $company->delete();
        session()->flash('delete','تم حذف الشركة بنجاح');
        return redirect('/companies');
    }

}
