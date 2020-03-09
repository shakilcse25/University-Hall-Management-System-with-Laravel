<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\employee;
use App\employee_meal;
use App\meal;
use App\Meal_student;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Validator;
use Carbon\Carbon;

class employeeController extends Controller
{
    public function index(Request $request) {
        if (Session::has('success')) {
            Alert::info('success', $request->session()->get('success'));
        }
        else if(Session::has('inserterror')) {
            Alert::info('inserterror', $request->session()->get('inserterror'));
        }

        if (Session::has('usuccess')) {
            Alert::info('success', $request->session()->get('usuccess'));
        } else if (Session::has('uerror')) {
            Alert::info('error', $request->session()->get('uerror'));
        }

        $employee =  employee::all();
        return view('employee.manage')->with('page','employee')->with(compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|unique:employees',
            'name' => 'required',
            'position' => 'required',
            'address' => 'required'
        ]);

        $employee = new employee();
        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $insert = $employee->save();
        if ($insert) {
            $request->session()->flash('success', 'New Employee Added Successfully!');
        } else {
            $request->session()->flash('inserterror', 'Employee Information Not Added!');
        }
        return redirect()->route('manage.employee');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function empupdateInformation(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:employees,phone,'. $id,
            'name' => 'required',
            'position' => 'required',
            'address' => 'required'
        ]);



        if ($validator->fails()) {
            Session::flash('id', $id);
            Session::flash('update', 'yes');
            return redirect()->route('manage.employee')->withErrors($validator)->withInput();
        }
        else{
            $employee = employee::find($id);
            $employee->name = $request->name;
            $employee->position = $request->position;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $insert = $employee->save();
            if ($insert) {
                $request->session()->flash('usuccess', 'Information Updated Successfully!');
            } else {
                $request->session()->flash('uerror', 'Information Not Updated!');
            }
            return redirect()->route('manage.employee');
        }
    }

    public function selectmonth() {
        return view('meal.emp_selectmonth')->with('page', 'empallmeal');
    }
    public function empselectmonthmeal(Request $request) {
        if (isset($request->month)) {
            $m = date('m', strtotime($request->month));
            $y = date('Y', strtotime($request->month));
            $meal = meal::whereMonth('meal_date', $m)->whereYear('meal_date', $y)->orderBy('meal_date', 'DESC')->get();
            if ($meal->count() > 0) {
                $request->session()->flash('month', $request->month);
                toast('Data Found!', 'success');
            } else {
                $meal = [];
                toast('No Record Found!', 'error');
            }
            $mn = Carbon::parse($request->month);
            $dt = $mn->daysInMonth;
        } else if ($request->session()->get('month') != null) {
            $m = date('m', strtotime($request->session()->get('month')));
            $y = date('Y', strtotime($request->session()->get('month')));
            $meal = Meal::whereMonth('meal_date', $m)->whereYear('meal_date', $y)->orderBy('meal_date', 'DESC')->get();
            if ($meal->count() > 0) {
                toast('Data Found!', 'success');
                $request->session()->flash('month', $request->session()->get('month'));
            } else {
                $meal = [];
                toast('No Record Found!', 'error');
            }
            $mn = Carbon::parse($request->session()->get('month'));
            $dt = $mn->daysInMonth;
        } else {
            $request->session()->flash('info', 'Please select a month to access this page!!');
            return redirect()->route('view.monthpage')->with('page', 'allmeal');
        }



        if (Session::has('success')) {
            Alert::success('Success', 'New Meal day Added Successfully!');
        }
        if (Session::has('unique')) {
            Alert::error('ERROR', $request->session()->get('unique'));
        }

        return view('meal.empallmeal')->with('page', 'empallmeal')->with(compact('meal', 'dt', 'm', 'y', 'mn'));
    }

    public function edit($id)
    {
        $meal_infor = Meal::find($id);
        $student_meal = Meal_student::where('meal_id', $id)->get();
        $employee = employee_meal::where('meal_id', $id)->get();
        $total_meal = 0;
        $total_cost = 0;
        $emp_cost = 0;
        $egg_cost = 0;
        foreach ($student_meal as $value) {
            $total_meal = $total_meal + $value->meal_no;
            $total_cost = $total_cost + $value->meal_cost;
            if ($value->egg == 1 && $value->meal_no != 0) {
                $egg_cost = $egg_cost + (ceil($value->meal_no) * 20);
            }
        }
        foreach ($employee as $value) {
            $total_meal = $total_meal + $value->meal_no;
            $emp_cost = $emp_cost + $value->meal_cost;
        }
        $egg_cost = $egg_cost / $total_meal;
        $avg_emp_cost = $emp_cost / $student_meal->count();
        $meal_rate = ($total_cost / $total_meal) + $egg_cost;
        return view('meal.empmealday')->with('page', 'empallmeal')->with(compact('employee', 'id', 'meal_infor', 'meal_rate', 'avg_emp_cost'));
    }

    public function update(Request $request, $id)
    {
        $meal = Meal::find($request->meal_id);
        $bazar_cost = $meal->bazar_cost;
        $student = Meal_student::where('meal_id', $request->meal_id)->get();
        $employee = employee_meal::where('meal_id', $request->meal_id)->get();
        $total_meal = 0;
        foreach ($student as $value) {
            $total_meal = $total_meal + $value->meal_no;
        }
        foreach ($employee as $value) {
            $total_meal = $total_meal + $value->meal_no;
        }

        $meal_student = employee_meal::find($id);

        $total_meal = $total_meal - $meal_student->meal_no;
        $total_meal = $total_meal + $request->meal_no;
        $meal_student->meal_no = $request->meal_no;
        $meal_student->save();
        $meal_rate = $bazar_cost / $total_meal;
        $total_emp_cost = 0;



        $egg_cost = 0;
        $student = Meal_student::where('meal_id', $request->meal_id)->get();

        foreach ($student as $value) {
            if ($value->egg == 1 && $value->meal_no != 0) {
                $egg_cost = $egg_cost + (ceil($value->meal_no) * 20);
            }
        }
        $egg_cost = $egg_cost / $total_meal;

        $employee = employee_meal::where('meal_id', $request->meal_id)->get();
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
        $meal_rate = $meal_rate + $egg_cost;

        return redirect()->back()->with('page', 'empallmeal')->with(compact('meal_rate','avg_emp_cost'));
    }

    public function destroy($id) {
        $employee = employee::find($id);
        $employee->delete();
        return redirect()->route('manage.employee');
    }
}
