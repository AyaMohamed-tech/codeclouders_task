<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Http\Request;
use App\Company;
use App\Http\Resources\CompanyResource;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return CompanyResource::collection($companies);
    }

    public function store(StoreCompanyRequest $request)
    {

       $input = $request->all();
       $image = $request->file('logo');
       $logo = $image->getClientOriginalName();
        
       $b_exists = Company::where('name','=',$input['name'])->exists();

        if($b_exists){
            return 'الشركة مسجلة مسبقا';
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

          return new CompanyResource($company);
         
        }
    }

    public function update(Request $request,$id)
    {
        $id = $request->id;

        $this->validate($request, [

            'name' => 'required|max:255|unique:companies,name,'.$id,
        ],[

            'name.required' =>'يرجي ادخال اسم الشركة',
            'name.unique'  =>'اسم الشركة مسجل مسبقا',

        ]);

        $company = Company::find($id);
        $company->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'website_url' => $request->website_url,
            'logo'        => 'logo.jpg',
        ]);

        return new CompanyResource($company);
    }

    public function destroy(Request $request,$id)
    {
        $id = $request->id;
        $company = Company::findOrFail($id);
        $company->delete();
        return new CompanyResource($company);
    }

}
