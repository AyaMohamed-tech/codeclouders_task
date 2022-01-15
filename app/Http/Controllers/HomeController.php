<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use Illuminate\Http\Request;
use App\Invoice;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      //=============== نسبة الاحصائيات ====================



      $count_company =Company::count();
      $count_employee = Employee::count();
      $count_user = User::count();

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الشركات', 'العملاء','المستخدمين'])
            ->datasets([
                [
                    "label" => "الشركات",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$count_company]
                ],
                [
                    "label" => "العملاء",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$count_employee]
                ],
                [
                    "label" => "المستخدمين",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$count_user]
                ],


            ])
            ->options([]);


        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الشركات', 'العملاء','المستخدمين'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$count_company, $count_employee,$count_user]
                ]
            ])
            ->options([]);

        return view('home', compact('chartjs','chartjs_2'));
    }
}
