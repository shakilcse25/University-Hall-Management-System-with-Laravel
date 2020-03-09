<?php

namespace App\Http\Controllers;
use App\Meal_student;
use App\Meal;
use App\employee_meal;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator, Redirect, Response;
use Yajra\DataTables\DataTables;

class stuentmealController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getmealApi(Request $request , $id){
        $meal_infor = Meal::find($id);
        $student_meal = Meal_student::where('meal_id', $id)->get();

        $ovrl_stdmeal = DB::table('students')
            ->join('meal_students', 'meal_students.student_id', '=', 'students.id')
            ->where('meal_students.meal_id','=',$id)
            ->get();

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

            $value->mealform = '<form name="myform" id="'.'mealform'. $value->id.'" action="/upadate_daily_meal/' . $value->id . '" method="POST"><select name="meal_no" class="mealselect" onchange="mealformsubmit('. $value->id .',mealform'. $value->id .');">' . $option . '</select><input type="hidden" name="meal_id" value="'. $value->meal_id .'"></form>';


            $checkbox = '<input onchange="eggformsubmit(' . $value->id . ',eggform' . $value->id . ');" type="checkbox" style="height:16px;width:24px;" name="egg" ';
            if($value->egg == 1){
                $checkbox .= 'checked >';
            }else{
                $checkbox .= ' >';
            }


            $value->eggform = '<form name="myform" id="' . 'eggform' . $value->id . '" action="/egg/' . $value->id . '" method="POST">'.$checkbox.'<input type="hidden" name="meal_id" value="' . $value->meal_id . '"></form>';



        }

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



        return response()->json(array('ovrl_stdmeal' => $ovrl_stdmeal,'student_meal' => $student_meal, 'id' => $id, 'meal_infor' => $meal_infor, 'meal_rate' => $meal_rate, 'avg_emp_cost' => $avg_emp_cost));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $emp_meal_no = 0;
        foreach ($employee as $value) {
            $total_meal = $total_meal + $value->meal_no;
            $emp_cost = $emp_cost + $value->meal_cost;
            $emp_meal_no = $emp_meal_no + $value->meal_no;
        }
        $egg_cost = $egg_cost / $total_meal;
        $avg_emp_cost = $emp_cost / $student_meal->count();
        $meal_rate = ($total_cost/ $total_meal) + $egg_cost;
        return view('meal.mealday')->with('page', 'allmeal')->with(compact('student_meal','id', 'meal_infor','meal_rate', 'avg_emp_cost', 'emp_meal_no'));
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
        $meal = Meal::find($request->meal_id);
        $bazar_cost = $meal->bazar_cost;
        $student = Meal_student::where('meal_id',$request->meal_id)->get();
        $employee = employee_meal::where('meal_id',$request->meal_id)->get();
        $total_meal = 0;
        $employee_meal =0 ;
        foreach ($student as $value) {
            $total_meal = $total_meal + $value->meal_no;
        }
        foreach ($employee as $value) {
            $total_meal = $total_meal + $value->meal_no;
            $employee_meal = $employee_meal + $value->meal_no;
        }



        $meal_student = Meal_student::find($id);

        $total_meal = $total_meal - $meal_student->meal_no;
        $total_meal = $total_meal + $request->meal_no;
        $meal_student->meal_no = $request->meal_no;
        $meal_student->save();
        $meal_rate = $bazar_cost / $total_meal;
        $total_emp_cost = 0;



        $egg_cost = 0;
        $student = Meal_student::where('meal_id', $request->meal_id)->get();

        foreach ($student as $value) {
            if($value->egg == 1 && $value->meal_no != 0){
                $egg_cost = $egg_cost + (ceil($value->meal_no) * 20);
            }
        }
        $egg_cost = $egg_cost/$total_meal;

        foreach ($employee as $value) {
            $emp = employee_meal::find($value->id);
            $emp->meal_cost = ($meal_rate * $value->meal_no) + (($value->meal_no) * $egg_cost);
            $emp->save();
            $total_emp_cost = $total_emp_cost + $emp->meal_cost;
        }

        $avg_emp_cost = $total_emp_cost / $student->count();
        $total_meal_cost = 0;
        foreach ($student as $data) {
            $m_student = Meal_student::find($data->id);
            if ($m_student->egg == 1 && $m_student->meal_no != 0) {
                $m_student->meal_cost = ($meal_rate * $m_student->meal_no) - (ceil($m_student->meal_no) * 20) + (($m_student->meal_no) * $egg_cost) + $avg_emp_cost;
                $m_student->save();
            }
            else if($m_student->egg == 0 && $m_student->meal_no != 0){
                $m_student->meal_cost = ($meal_rate * $m_student->meal_no) + (($m_student->meal_no) * $egg_cost) + $avg_emp_cost;
                $m_student->save();
            }
            else if($m_student->meal_no == 0){
                $m_student->meal_cost = $avg_emp_cost;
                $m_student->save();
            }
            $total_meal_cost = $total_meal_cost + $m_student->meal_cost;
        }
        $meal_rate = $meal_rate + $egg_cost;


        // return redirect()->back()->with('meal_rate', $meal_rate)->with(compact('avg_emp_cost'));
        return Response()->json(array('meal_rate' => $meal_rate, 'avg_emp_cost' => $avg_emp_cost,'std_meal_no' => $total_meal - $employee_meal,'emp_meal_no' => $employee_meal,'total_meal_cost' => $total_meal_cost));
    }

    public function egg(Request $request, $id)
    {
        $meal = Meal::find($request->meal_id);
        $bazar_cost = $meal->bazar_cost;
        $student = Meal_student::where('meal_id', $request->meal_id)->get();
        $employee = employee_meal::where('meal_id', $request->meal_id)->get();
        $total_meal = 0;
        $e_cost = 0;

        foreach ($student as $value) {
            $total_meal = $total_meal + $value->meal_no;
        }
        $employee_meal = 0;
        foreach ($employee as $value) {
            $total_meal = $total_meal + $value->meal_no;
            $e_cost = $e_cost + $value->meal_cost;
            $employee_meal = $employee_meal + $value->meal_no;
        }
        $avg_cost = $bazar_cost / $total_meal ;
        $avg_emp_cost = $e_cost / $student->count();
        $egg_cost = 0;

        $meal_student = Meal_student::find($id);
        $total_meal_cost = 0;
        if ($request->egg == 'on') {
            $egg = 1;
            $meal_student->egg = $egg;
            $meal_student->save();

            $student = Meal_student::where('meal_id', $request->meal_id)->get();


            foreach ($student as $std) {
                if ($std->egg == 1 && $std->meal_no != 0) {
                    $egg_cost = $egg_cost + (ceil($std->meal_no) * 20);
                }
            }
            $egg_cost = $egg_cost / $total_meal;

            $emp_cost = 0;
            foreach ($employee as $value) {
                $m_employee = employee_meal::find($value->id);
                $m_employee->meal_cost= ($avg_cost * $value->meal_no) + (($value->meal_no) * $egg_cost);
                $m_employee->save();
                $emp_cost = $emp_cost + $m_employee->meal_cost;
            }
            $avg_emp_cost = $emp_cost / $student->count();


            foreach ($student as $data) {
                $m_student = Meal_student::find($data->id);
                if ($m_student->egg == 1 && $m_student->meal_no != 0) {
                    $m_student->meal_cost = ($avg_cost * $m_student->meal_no) - (ceil($m_student->meal_no) * 20) + (($m_student->meal_no) * $egg_cost) + $avg_emp_cost;
                    $m_student->save();
                } else if ($m_student->egg == 0  && $m_student->meal_no != 0) {
                    $m_student->meal_cost = ($avg_cost * $m_student->meal_no) + (($m_student->meal_no) * $egg_cost) + $avg_emp_cost;
                    $m_student->save();
                } else if($m_student->meal_no == 0){
                    $m_student->meal_cost = $avg_emp_cost;
                    $m_student->save();
                }
                $total_meal_cost = $total_meal_cost + $m_student->meal_cost;
            }

        }
        else if($request->egg == null){
            $egg = 0;
            $meal_student->egg = $egg;
            $meal_student->save();

            $student = Meal_student::where('meal_id', $request->meal_id)->get();

            $egg_cost = 0;

            foreach ($student as $std) {
                if ($std->egg == 1 && $std->meal_no != 0) {
                    $egg_cost = $egg_cost + (ceil($std->meal_no) * 20);
                }
            }
            $egg_cost = $egg_cost / $total_meal;

            $emp_cost = 0;
            foreach ($employee as $value) {
                $m_employee = employee_meal::find($value->id);
                $m_employee->meal_cost = ($avg_cost * $value->meal_no) + (($value->meal_no) * $egg_cost);
                $m_employee->save();
                $emp_cost = $emp_cost + $m_employee->meal_cost;
            }
            $avg_emp_cost = $emp_cost / $student->count();


            foreach ($student as $data) {
                $m_student = Meal_student::find($data->id);
                if($m_student->egg == 1 && $m_student->meal_no != 0) {
                    $m_student->meal_cost = ($avg_cost * $m_student->meal_no) - (ceil($m_student->meal_no) * 20) + (($m_student->meal_no) * $egg_cost) + $avg_emp_cost;
                    $m_student->save();
                }else if($m_student->egg == 0  && $m_student->meal_no != 0) {
                    $m_student->meal_cost = ($avg_cost * $m_student->meal_no) + (($m_student->meal_no) * $egg_cost) + $avg_emp_cost;
                    $m_student->save();
                } else if($m_student->meal_no == 0) {
                    $m_student->meal_cost = $avg_emp_cost;
                    $m_student->save();
                }
                $total_meal_cost = $total_meal_cost + $m_student->meal_cost;
            }
        }
        $meal_rate = $avg_cost + $egg_cost;



        // return redirect()->back()->with(compact('avg_emp_cost', 'meal_rate'));;
        return Response()->json(array('meal_rate' => $meal_rate, 'avg_emp_cost' => $avg_emp_cost, 'std_meal_no' => $total_meal - $employee_meal, 'emp_meal_no' => $employee_meal, 'total_meal_cost' => $total_meal_cost));
    }
}
















//  public function egg(Request $request, $id)
//     {
//         $meal = Meal::find($request->meal_id);
//         $bazar_cost = $meal->bazar_cost;
//         $student = Meal_student::where('meal_id', $request->meal_id)->get();
//         $employee = employee_meal::where('meal_id', $request->meal_id)->get();
//         $total_meal = 0;
//         foreach ($student as $value) {
//             $total_meal = $total_meal + $value->meal_no;
//         }
//         foreach ($employee as $value) {
//             $total_meal = $total_meal + $value->meal_no;
//         }
//         $avg_cost = $bazar_cost / $total_meal ;

//         $meal_student = Meal_student::find($id);
//         // $egg = 10;
//         if ($request->egg == 'on') {
//             $egg = 1;
//             $meal_student->egg = $egg;
//             $meal_student->save();

//             $student = Meal_student::where('meal_id', $request->meal_id)->get();
//             $egg_cost = 0;

//             foreach ($student as $std) {
//                 if ($std->egg == 1 && $std->meal_no != 0) {
//                     $egg_cost = $egg_cost + (ceil($std->meal_no) * 20);
//                 }
//             }
//             $egg_cost = $egg_cost / $total_meal;


//             foreach ($student as $data) {
//                 $m_student = Meal_student::find($data->id);
//                 if ($m_student->egg == 1 && $m_student->meal_no != 0) {
//                     $m_student->meal_cost = ($avg_cost * $m_student->meal_no) - (ceil($m_student->meal_no) * 20) + (($m_student->meal_no) * $egg_cost);
//                     $m_student->save();
//                 } else if ($m_student->egg == 0  && $m_student->meal_no != 0) {
//                     $m_student->meal_cost = ($avg_cost * $m_student->meal_no) + (($m_student->meal_no) * $egg_cost);
//                     $m_student->save();
//                 }
//             }
//             foreach ($employee as $value) {
//                 $m_employee = Meal_student::find($value->id);
//                 $m_employee->meal_cost =($avg_cost * $m_employee->meal_no) + (($m_employee->meal_no) * $egg_cost);
//                 $m_employee->save();
//             }
//         }
//         else if($request->egg == null){
//             $egg = 0;
//             $meal_student->egg = $egg;
//             $meal_student->save();

//             $student = Meal_student::where('meal_id', $request->meal_id)->get();

//             $egg_cost = 0;

//             foreach ($student as $std) {
//                 if ($std->egg == 1 && $std->meal_no != 0) {
//                     $egg_cost = $egg_cost + (ceil($std->meal_no) * 20);
//                 }
//             }
//             $egg_cost = $egg_cost / $total_meal;

//             foreach ($student as $data) {
//                 $m_student = Meal_student::find($data->id);
//                 if($m_student->egg == 1 && $m_student->meal_no != 0) {
//                     $m_student->meal_cost = ($avg_cost * $m_student->meal_no) - (ceil($m_student->meal_no) * 20) + (($m_student->meal_no) * $egg_cost);
//                     $m_student->save();
//                 }else if($m_student->egg == 0  && $m_student->meal_no != 0) {
//                     $m_student->meal_cost = ($avg_cost * $m_student->meal_no) + (($m_student->meal_no) * $egg_cost);
//                     $m_student->save();
//                 }
//             }
//         }



//         return redirect()->back();
//     }
//Develop by shakil Ahmed cse 3rd batch Id:16104025
