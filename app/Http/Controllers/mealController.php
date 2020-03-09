<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meal;
use App\student;
use App\Meal_student;
use App\employee;
use App\employee_meal;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Validator;
use Carbon\Carbon;
use DB;

class mealController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Session::has('info')) {
            Alert::info('Info', $request->session()->get('info'));
        }
        return view('meal.selectmonth')->with('page', 'allmeal');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meal_date' => 'required|unique:meals',
            'bazar_cost' => 'required'
        ]);
        if ($validator->fails()) {
            $request->session()->flash('unique', 'This Date is already Taken!');
            return redirect()->route('select.month_meal_search')->with('month', $request->meal_date);
        }


        $student = student::where('status',1)->get();
        $employee = employee::all();
        $total_meal = $student->count() + $employee->count();

        $meal = new Meal();
        $meal->bazar_cost = $request->bazar_cost;
        $meal->meal_date = $request->meal_date;
        $meal->save();

        foreach ($employee as $data) {
            $meal_employee = new employee_meal();
            $meal_employee->meal_id = $meal->id;
            $meal_employee->employee_id = $data->id;
            $meal_employee->meal_cost = $meal->bazar_cost / $total_meal;
            $meal_employee->meal_no = 1;
            $meal_employee->save();
        }
        $total_emp_cost = ($meal->bazar_cost / $total_meal) * $employee->count();
        $avg_emp_cost = $total_emp_cost/ $student->count();

        foreach ($student as $value) {
            $mealstudent = new Meal_student();
            $mealstudent->meal_id = $meal->id;
            $mealstudent->student_id = $value->id;
            $mealstudent->room_no = $value->room->room_no;
            $mealstudent->meal_no = 1;
            $mealstudent->meal_cost = ($meal->bazar_cost / $total_meal) + $avg_emp_cost;
            $mealstudent->save();
        }



        $m = date('m', strtotime($request->meal_date));
        $y = date('Y', strtotime($request->meal_date));
        $meal = Meal::whereMonth('meal_date', $m)->whereYear('meal_date', $y)->get();
        if ($meal->count() > 0) {
            toast('Data Found!', 'success');
        } else {
            $meal = [];
            toast('No Record Found!', 'error');
        }

        $request->session()->flash('success', 'Student Meal Added Successfully!');
        return redirect()->route('select.month_meal_search')->with('month', $request->meal_date);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function findmealstudent(Request $request,$id)
    {
        $meal_infor = Meal::find($id);
        $search = array();
        $ovrl_stdmeal = DB::table('students')
            ->join('meal_students', 'meal_students.student_id', '=', 'students.id')
            ->where('meal_students.meal_id', '=', $id)
            ->get();


        if ($request->floor) {
            $arr = array();
            foreach ($request->floor as $value) {
                array_push($search, $value);
                array_push($arr, $value);
            }

            if (!in_array('allroom', $search)) {
                $rmid = array();
                foreach ($ovrl_stdmeal as $value) {
                    $room_no = strval($value->room_no);
                    if (in_array($room_no[0],$arr)) {
                        array_push($rmid, $value->room_no);
                    }
                }
                $ovrl_stdmeal = $ovrl_stdmeal->whereIn('room_no', $rmid);
            }
        }

        if ($request->batch) {
            $arr = array();
            foreach ($request->batch as $value) {
                array_push($search, $value);
                array_push($arr, $value);
            }
            if (!in_array('allbatch', $search)) {
                $ovrl_stdmeal = $ovrl_stdmeal->whereIn('batch', $arr);
            }
        }

        if ($request->dept) {
            $arr = array();
            foreach ($request->dept as $value) {
                array_push($search, $value);
                array_push($arr, $value);
            }
            if (!in_array('alldept', $search)) {
                $ovrl_stdmeal = $ovrl_stdmeal->whereIn('dept', $arr);
            }
        }

        $employee = employee_meal::where('meal_id', $id)->get();

        $total_meal = 0;
        $emp_cost = 0;
        $emp_meal_no= 0;
        $total_cost = 0;
        $egg_cost = 0;

        foreach ($ovrl_stdmeal as $value) {
            $option = '<option value="0" ';
            if ($value->meal_no == 0) {
                $option .= 'selected >' . 0 . '</option>';
            } else {
                $option .= ' >' . 0 . '</option>';
            }
            $option .= '<option value="0.5" ';
            if ($value->meal_no == 0.5) {
                $option .= 'selected >' . 0.5 . '</option>';
            } else {
                $option .= ' >' . 0.5 . '</option>';
            }
            $option .= '<option value="1" ';
            if ($value->meal_no == 1) {
                $option .= 'selected >' . 1 . '</option>';
            } else {
                $option .= ' >' . 1 . '</option>';
            }
            $option .= '<option value="2" ';
            if ($value->meal_no == 2) {
                $option .= 'selected >' . 2 . '</option>';
            } else {
                $option .= ' >' . 2 . '</option>';
            }

            $value->mealform = '<form name="myform" id="' . 'mealform' . $value->id . '" action="/upadate_daily_meal/' . $value->id . '" method="POST"><select name="meal_no" class="mealselect" onchange="mealformsubmit(' . $value->id . ',mealform' . $value->id . ');">' . $option . '</select><input type="hidden" name="meal_id" value="' . $value->meal_id . '"></form>';


            $checkbox = '<input onchange="eggformsubmit(' . $value->id . ',eggform' . $value->id . ');" type="checkbox" style="height:16px;width:24px;" name="egg" ';
            if ($value->egg == 1) {
                $checkbox .= 'checked >';
            } else {
                $checkbox .= ' >';
            }


            $value->eggform = '<form name="myform" id="' . 'eggform' . $value->id . '" action="/egg/' . $value->id . '" method="POST">' . $checkbox . '<input type="hidden" name="meal_id" value="' . $value->meal_id . '"></form>';

            $total_meal = $total_meal + $value->meal_no;
            $total_cost = $total_cost + $value->meal_cost;
            if ($value->egg == 1 && $value->meal_no != 0) {
                $egg_cost = $egg_cost + (ceil($value->meal_no) * 20);
            }
        }


        foreach ($employee as $value) {
            $total_meal = $total_meal + $value->meal_no;
            $emp_cost = $emp_cost + $value->meal_cost;
            $emp_meal_no = $emp_meal_no + $value->meal_no;
        }
        $egg_cost = $egg_cost / $total_meal;
        $avg_emp_cost = $emp_cost / $ovrl_stdmeal->count();
        $meal_rate = ($total_cost / $total_meal) + $egg_cost;


        // return view('meal.mealday')->with('page', 'allmeal')->with(compact('student_meal', 'id', 'meal_infor', 'meal_rate', 'avg_emp_cost', 'emp_meal_no'));
        return response()->json(array('ovrl_stdmeal' => $ovrl_stdmeal, 'id' => $id, 'meal_infor' => $meal_infor, 'meal_rate' => $meal_rate, 'avg_emp_cost' => $avg_emp_cost));
    }

    public function findmealsinglestudent(Request $request)
    {
        if(isset($request->month)  && isset($request->dept_id) ){
            $m = date('m', strtotime($request->month));
            $y = date('Y', strtotime($request->month));
            $dept_id = $request->dept_id;
            $searchid = student::where('dept_id',$dept_id)->get();
            if($searchid->count() > 0){
                $searchid = $searchid[0];
                $st_id = $searchid->id;

                $thismonth = Meal::whereMonth('meal_date', $m)->whereYear('meal_date', $y)->get();
                $all_student = [];
                foreach ($thismonth as $val) {
                    $meal_student = Meal_student::where('meal_id', $val->id)->where('student_id', $st_id)->get();
                    foreach ($meal_student as $value) {
                        $all_student[] = $value;
                    }
                }
                toast('Data Found!', 'success');
                $ob_allstd = $all_student;
            }else{
                $searchid = [];
                toast('No Record Found!', 'error');
                $ob_allstd = [];
            }


        }
        else{
            $searchid = [];
            toast('No Record Found!', 'error');
            $ob_allstd = [];
        }

        return view('meal.singlestudent')->with('page', 'singlemeal')->with(compact('ob_allstd','searchid'))->with('month',$request->month)->with('student_id',$request->dept_id);
    }

    public function selectmonthmeal(Request $request){

        if (isset($request->month)) {
            $m = date('m', strtotime($request->month));
            $y = date('Y', strtotime($request->month));
            $meal = Meal::whereMonth('meal_date', $m)->whereYear('meal_date', $y)->orderBy('meal_date', 'DESC')->get();
            if ($meal->count() > 0) {
                $request->session()->flash('month', $request->month);
                toast('Data Found!', 'success');
            }else{
                $meal = [];
                toast('No Record Found!', 'error');
            }
            $mn = Carbon::parse($request->month);
            $dt = $mn->daysInMonth;
        }
        else if($request->session()->get('month') != null){
            $m = date('m', strtotime($request->session()->get('month')));
            $y = date('Y', strtotime($request->session()->get('month')));
            $meal = Meal::whereMonth('meal_date', $m)->whereYear('meal_date', $y)->orderBy('meal_date','DESC')->get();
            if ($meal->count() > 0) {
                toast('Data Found!', 'success');
                $request->session()->flash('month', $request->session()->get('month'));
            } else {
                $meal = [];
                toast('No Record Found!', 'error');
            }
            $mn = Carbon::parse($request->session()->get('month'));
            $dt = $mn->daysInMonth;
        }
        else{
            $request->session()->flash('info', 'Please select a month to access this page!!');
            return redirect()->route('view.monthpage')->with('page', 'allmeal');
        }



        if (Session::has('success')) {
            Alert::success('Success', 'New Meal day Added Successfully!');
        }
        if (Session::has('unique')) {
            Alert::error('ERROR', $request->session()->get('unique'));
        }

        return view('meal.allmeal')->with('page', 'allmeal')->with(compact('meal','dt','m','y','mn'));
    }

    public function delmeal(Request $request, $id) {
        DB::table('meal_students')->where('meal_id', $id)->delete();
        DB::table('employee_meals')->where('meal_id', $id)->delete();

        $meal = Meal::find($id);
        $month = $meal->meal_date;
        $meal->delete();

        return redirect()->route('select.month_meal_search')->with('month', $month);
    }

    public function mealUpdate($id, Request $request) {
        $meal = meal::find($id);
        $meal->bazar_cost = $request->bazar_cost;
        $meal->save();

        $bazar_cost = $request->bazar_cost;
        $student = Meal_student::where('meal_id', $meal->id)->get();
        $employee = employee_meal::where('meal_id', $meal->id)->get();
        $total_meal = 0;
        foreach ($student as $value) {
            $total_meal = $total_meal + $value->meal_no;
        }
        foreach ($employee as $value) {
            $total_meal = $total_meal + $value->meal_no;
        }


        $meal_rate = $bazar_cost / $total_meal;
        $total_emp_cost = 0;

        $egg_cost = 0;
        $student = Meal_student::where('meal_id', $meal->id)->get();

        foreach ($student as $value) {
            if ($value->egg == 1 && $value->meal_no != 0) {
                $egg_cost = $egg_cost + (ceil($value->meal_no) * 20);
            }
        }
        $egg_cost = $egg_cost / $total_meal;

        $employee = employee_meal::where('meal_id', $meal->id)->get();
        foreach ($employee as $value) {
            $emp = employee_meal::find($value->id);
            $emp->meal_cost = ($meal_rate * $value->meal_no) + (($value->meal_no) * $egg_cost);
            $emp->save();
            $total_emp_cost = $total_emp_cost + $emp->meal_cost;
        }

        $avg_emp_cost = $total_emp_cost / $student->count();

        foreach ($student as $data) {
            $m_student = Meal_student::find($data->id);
            if ($m_student->egg == 1 && $m_student->meal_no != 0) {
                $m_student->meal_cost = ($meal_rate * $m_student->meal_no) - (ceil($m_student->meal_no) * 20) + (($m_student->meal_no) * $egg_cost) + $avg_emp_cost;
                $m_student->save();
            } else if ($m_student->egg == 0 && $m_student->meal_no != 0) {
                $m_student->meal_cost = ($meal_rate * $m_student->meal_no) + (($m_student->meal_no) * $egg_cost) + $avg_emp_cost;
                $m_student->save();
            } else if ($m_student->meal_no == 0) {
                $m_student->meal_cost = $avg_emp_cost;
                $m_student->save();
            }
        }

        return redirect()->route('select.month_meal_search')->with('month', $meal->meal_date);
    }


}
