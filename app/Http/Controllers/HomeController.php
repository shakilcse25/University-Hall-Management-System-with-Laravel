<?php

namespace App\Http\Controllers;

use App\Meal;
use App\student;
use App\Meal_student;
use App\employee;
use App\room;
use App\Fillvacent;
use App\batch;
use App\department;
use App\monthly_calculation;
use App\createmonth_calculation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

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
        $present_student = student::where('status',1)->count();
        $date = Carbon::now();
        // $date = '2019-01-01';

        $m = date('m', strtotime($date));
        $y = date('Y', strtotime($date));
        $meal = Meal::whereMonth('meal_date', $m)->whereYear('meal_date', $y)->get();
        $meal_day = $meal->count();

        $monthid = 0;
        $allmonth = createmonth_calculation::whereMonth('month', $m)->whereYear('month', $y)->get();

        if($allmonth->count() > 0){
            $monthid = $allmonth[0]->id;
        }
        $monthlycal = monthly_calculation::where('month_id', $monthid)->get();

        $total_meal_cost = 0;

        foreach ($meal as $value) {
            $total_meal_cost = $total_meal_cost + $value->bazar_cost;
        }

        $total_deposit = 0;
        $total_cost = 0;
        if ($monthlycal->count() > 0) {
            foreach ($monthlycal as $value) {
                $total_deposit = $total_deposit + $value->deposit;
                $total_cost = $total_cost + ($value->elec_bill + $value->internet_bill + $value->seat_bill + $value->meal_cost);
            }
        }


        $new_reg = 0;
        $vacent_num = 0;
        $fillvacent = DB::table('fillvacents')->where('created_at', '>', (new \Carbon\Carbon)->submonths(2))->get();
        if ($fillvacent->count() > 0) {
            $new_reg = $fillvacent->where('status','Fill')->count();
            $vacent_num = $fillvacent->where('status','Vacent')->count();
        }

        $total_cost = round($total_cost);

        return view('dashboard.dashboard')->with('page','home')->with(compact('present_student', 'meal_day', 'total_meal_cost', 'total_deposit', 'total_cost', 'new_reg', 'vacent_num'));
    }

    public function setting() {
        $department = department::all();
        $batch = batch::all();
        return view('setting.view')->with('page','setting')->with(compact('department', 'batch'));
    }

    public function storedept(Request $request) {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $department = new department();
        $department->name = $request->name;
        $department->save();
        return redirect()->back();
    }

    public function storebatch(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $batch = new batch();
        $batch->name = $request->name;
        $batch->save();
        return redirect()->back();
    }

    public function deletedept($id) {
       $delete = department::find($id);
       $delete->delete();
       return redirect()->back();
    }

    public function deletebatch($id) {
       $delete = batch::find($id);
       $delete->delete();
       return redirect()->back();
    }


}
