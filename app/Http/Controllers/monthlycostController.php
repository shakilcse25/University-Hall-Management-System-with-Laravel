<?php

namespace App\Http\Controllers;
use App\monthly_calculation;
use App\createmonth_calculation;
use App\student;
use App\Meal;
use App\Meal_student;
use App\transaction;
use Session;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Nexmo\Laravel\Facade\Nexmo;


class monthlycostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $allmonth = createmonth_calculation::all();
        if (count($allmonth) == 0){
            $allmonth = [];
        }
        foreach ($allmonth as $singlemonth) {
            $month = createmonth_calculation::find($singlemonth->id);
            $monthcost = monthly_calculation::where('month_id', $singlemonth->id)->get();
            $m = date('m', strtotime($month->month));
            $y = date('Y', strtotime($month->month));
            $thismonth = Meal::whereMonth('meal_date', $m)->whereYear('meal_date', $y)->get();
            $all_student = [];
            foreach ($thismonth as $val) {
                $meal_student = Meal_student::where('meal_id', $val->id)->get();
                foreach ($meal_student as $value) {
                    $all_student[] = $value;
                }
            }
            $ob_allstd = (object) $all_student;

            foreach ($monthcost as $cost) {
                $total_meal = 0;
                $meal_cost = 0;
                foreach ($ob_allstd as $std) {
                    if ($std->student_id == $cost->std_id) {
                        $total_meal = $total_meal + $std->meal_no;
                        $meal_cost = $meal_cost + $std->meal_cost;
                    }
                }
                $thiscost = monthly_calculation::find($cost->id);
                $thiscost->meal_no = $total_meal;
                $thiscost->meal_cost = $meal_cost;
                $thiscost->save();
            }
        }
        return view('monthlycost.index')->with('page', 'monthlycost')->with(compact('allmonth'));
    }


    public function studenttable($id, Request $request)
    {

        $month = createmonth_calculation::find($id);
        $monthcost = monthly_calculation::where('month_id', $id)->get();
        $m = date('m', strtotime($month->month));
        $y = date('Y', strtotime($month->month));
        $thismonth = Meal::whereMonth('meal_date', $m)->whereYear('meal_date',$y)->get();
        $all_student = [];
        foreach ($thismonth as $val) {
            $meal_student = Meal_student::where('meal_id', $val->id)->get();
            foreach ($meal_student as $value) {
                $all_student[] = $value;
            }
        }
        $ob_allstd = (object) $all_student;

        $stdid = array();
        foreach ($monthcost as $cost) {
            $total_meal = 0;
            $meal_cost = 0;
            foreach ($ob_allstd as $std) {
                if ($std->student_id == $cost->std_id) {
                    $total_meal = $total_meal + $std->meal_no;
                    $meal_cost = $meal_cost + $std->meal_cost;
                }
            }
            $thiscost = monthly_calculation::find($cost->id);
            $thiscost->meal_no = $total_meal;
            $thiscost->meal_cost = $meal_cost;
            $thiscost->save();
            array_push($stdid,$cost->std_id);
        }

        $existstudent = student::where('status', 1)->whereNotIn('id',$stdid)->get();
        if ($existstudent->count() == 0) {
            $existstudent = [];
        }

        if (Session::has('successdel')) {
            Alert::success('Success', $request->session()->get('successdel'));
        }
        if (Session::has('added')) {
            Alert::success('Success', $request->session()->get('added'));
        }

        return view('monthlycost.student')->with('page', 'monthlycost')->with(compact('monthcost','id','month','existstudent'));
    }



    public function studenttableApi($id, Request $request)
    {
        $month = createmonth_calculation::find($id);
        $monthcost = monthly_calculation::where('month_id', $id)->get();
        $m = date('m', strtotime($month->month));
        $y = date('Y', strtotime($month->month));
        $thismonth = Meal::whereMonth('meal_date', $m)->whereYear('meal_date', $y)->get();
        $all_student = [];
        foreach ($thismonth as $val) {
            $meal_student = Meal_student::where('meal_id', $val->id)->get();
            foreach ($meal_student as $value) {
                $all_student[] = $value;
            }
        }
        $ob_allstd = (object) $all_student;

        $ovrl_monthcost = DB::table('students')
            ->join('monthly_calculations', 'monthly_calculations.std_id', '=', 'students.id')
            ->where('monthly_calculations.month_id', '=', $id)
            ->select(DB::raw('*'), DB::raw('monthly_calculations.internet_bill + monthly_calculations.elec_bill + monthly_calculations.seat_bill + monthly_calculations.meal_cost as total'), DB::raw('monthly_calculations.deposit - (monthly_calculations.internet_bill + monthly_calculations.elec_bill + monthly_calculations.seat_bill + monthly_calculations.meal_cost) as surplus'))
            ->get();
        // $ovrl_monthcost->total = round($ovrl_monthcost->total);


        $stdid = array();
        foreach ($monthcost as $cost) {
            $total_meal = 0;
            $meal_cost = 0;
            foreach ($ob_allstd as $std) {
                if ($std->student_id == $cost->std_id) {
                    $total_meal = $total_meal + $std->meal_no;
                    $meal_cost = $meal_cost + $std->meal_cost;
                }
            }
            $thiscost = monthly_calculation::find($cost->id);
            $thiscost->meal_no = $total_meal;
            $thiscost->meal_cost = $meal_cost;
            $thiscost->save();
            array_push($stdid, $cost->std_id);
        }

        $existstudent = student::where('status', 1)->whereNotIn('id', $stdid)->get();
        if ($existstudent->count() == 0) {
            $existstudent = [];
        }

        if (Session::has('successdel')) {
            Alert::success('Success', $request->session()->get('successdel'));
        }
        if (Session::has('added')) {
            Alert::success('Success', $request->session()->get('added'));
        }
        $page = 'monthlycost';


        foreach ($ovrl_monthcost as $value) {
            $total_cost = $value->meal_cost + $value->seat_bill + $value->internet_bill + $value->elec_bill;
            $surplus = $value->deposit - $total_cost;

            $value->action = '<a href="" class="btn btn-primary" data-toggle="modal" data-target="#myModal'.$value->id. '">Update</a> <a href="/deletemonth/'. $value->id .'" class="btn btn-danger">Delete</a>';

            $value->action .= '<div id="myModal' . $value->id . '" class="modal fade" role="dialog"><div class="modal-dialog" style="min-width:45%;"><div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Monthly Calulation for '. $value->name. '</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div><div class="modal-body">
                <form style="margin-bottom: 20px;padding: 15px;margin:0px;" action="/monthly_cost_update/' . $value->id . '" method="POST" class="form-horizontal form-label-left" id="cash' . $value->id . '"><div class="form-group"><label for="">*Deposit(Cash)</label> <input type="number" name="deposit" class="form-control" value="'. $value->deposit . '" required></div><p class="text-center"><button type="button" style="width:110px;" onclick="depositsubmit('. $value->id . ');" class="btn btn-success" > Update </button></p></form>';

            $value->action .= '<form style="margin-bottom: 20px;padding: 15px;margin:0px;"  id="credit' . $value->id . '" action="/credit_month/' . $value->id . '" method="POST" class="form-horizontal form-label-left"><div class="form-group"><p> *Add deposit from his account balance(Credit): </p><label for="">Amount to deposit:</label> <input type="number" name="deposit" class="form-control" required><p>Current Account Balance: <strong>' . $value->init_deposit . '</strong></p></div><p class="text-center"><button type="button" style="width:110px;" onclick="credit(' . $value->id . ');" class="btn btn-success" > Credit </button></p></form>';

            $value->action .= '<form style="margin-bottom: 20px;padding: 15px;margin:0px;"  id="debit' . $value->id . '" action="/debit_month/' . $value->id . '" method="POST" class="form-horizontal form-label-left"><div class="form-group"><p> *Add amount to his account balance from current deposit(Debit) : </p><label for="">Amount to add to his account:</label> <input type="number" name="deposit" class="form-control" required><p>Remaining Deposit balance(Current month): <strong ';

            if ($surplus < 0) {
                $value->action .=' style="color:red;">' . $surplus . '</strong></p></div><p class="text-center"><button type="button" style="width:110px;" onclick="debit(' . $value->id . ');" class="btn btn-success" > Debit </button></p></form>';
            }else{
                $value->action .= '>' . $surplus . '</strong></p></div><p class="text-center"><button type="button" style="width:110px;" onclick="debit(' . $value->id . ');" class="btn btn-success" > Debit </button></p></form>';
            }

            $value->action .= '</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>';
        }

        return response()->json(array('page' => $page, 'ovrl_monthcost' => $ovrl_monthcost, 'monthcost' => $monthcost, 'id' => $id, 'month'=> $month, 'existstudent' => $existstudent));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'month' => $request->month.'-'.'01'
        ]);

        $this->validate($request, [
            'month' => 'required|unique:createmonth_calculations'
        ]);

        $createmonth = new createmonth_calculation();
        $createmonth->month = $request->month;
        $createmonth->elec_bill = $request->elec_bill;
        $createmonth->internet_bill = $request->internet_bill;
        $createmonth->meal_rate = $request->meal_rate;
        $create = $createmonth->save();
        if ($create) {

            $student = student::all();
            foreach ($student as $value) {
                if ($value->status == '1') {
                    $monthcost = new monthly_calculation();
                    $monthcost->month_id = $createmonth->id;
                    $monthcost->std_id = $value->id;
                    $monthcost->room_no = $value->room->room_no;
                    $monthcost->elec_bill = $createmonth->elec_bill;
                    $monthcost->internet_bill = $createmonth->internet_bill;
                    $monthcost->seat_bill = $value->room->room_charges;
                    $monthcost->meal_cost = 0;
                    $monthcost->deposit = 0;
                    $monthcost->save();
                }
            }
        }
        return redirect()->route('monthly.cost');
    }

    public function update(Request $request, $id)
    {

        $createmonth = createmonth_calculation::find($id);
        if($request->month !== null){
            $month = $request->month . '-' . '01';
            $createmonth->month = $month;
        }
        $createmonth->elec_bill = $request->elec_bill;
        $createmonth->internet_bill = $request->internet_bill;
        $createmonth->meal_rate = $request->meal_rate;
        $createmonth->save();

        DB::table('monthly_calculations')
            ->where('month_id', $id)
            ->update(['elec_bill' => $createmonth->elec_bill,
            'internet_bill' => $createmonth->internet_bill
            ]);


        return redirect()->route('monthly.cost');
    }

    public function monthlycostupdate(Request $request, $id)
    {
        $update = monthly_calculation::find($id);
        $update->deposit = $request->deposit;
        $update->save();
        // Alert::success('Success Title', 'Success Message');

        return response()->json();
    }

    public function addstdtomonth(Request $request) {
        $createmonth = createmonth_calculation::find($request->monthid);
        $student = student::find($request->stdid);
        $monthcost = new monthly_calculation();
        $monthcost->month_id = $request->monthid;
        $monthcost->std_id = $student->id;
        $monthcost->room_no = $student->room->room_no;
        $monthcost->elec_bill = $createmonth->elec_bill;
        $monthcost->internet_bill = $createmonth->internet_bill;
        $monthcost->seat_bill = $student->room->room_charges;
        $monthcost->meal_cost = 0;
        $monthcost->deposit = 0;
        $monthcost->save();
        Session::flash('added', 'Student Added Successfully!');
        return redirect()->back();
    }

    public function destroy($id) {
        $delmonth = monthly_calculation::find($id);
        $result = $delmonth->delete();
        if($result){
            Session::flash('successdel', 'Student Deleted Successfully!');
            return redirect()->back();
        }
    }

    public function delmonth($id)
    {

        DB::table('monthly_calculations')->where('month_id', $id)->delete();

        $month = createmonth_calculation::find($id);
        $month->delete();

        return redirect()->route('monthly.cost');
    }

    public function credit($id, Request $request){
        $monthly_cal = monthly_calculation::find($id);
        $month = createmonth_calculation::find($monthly_cal->month_id);
        $month = $month->month;
        $month = Carbon::createFromDate($month);
        $month = $month->format('F Y');


        if( $request->deposit <= $monthly_cal->student->init_deposit){
            $monthly_cal->deposit = $monthly_cal->deposit + $request->deposit;
            $monthly_cal->save();
            $student = student::find($monthly_cal->std_id);
            $old_balance = $student->init_deposit;
            $student->init_deposit = $student->init_deposit - $request->deposit;
            $student->save();

            $trans = new transaction();
            $trans->std_id = $student->id;
            $trans->type = 'Credit';
            $trans->amount = $request->deposit;
            $trans->old_balance = $old_balance;
            $trans->new_balance = $student->init_deposit;
            $trans->description = 'Your account balance has been credited '.$request->deposit . 'Tk to the month - '. $month.'. Your old balance was '. $trans->old_balance.'Tk and now your updated balance is '. $trans->new_balance.'Tk.';
            $trans->save();

            // Nexmo::message()->send([
            //  'to'   => '8801677153967',
            //  'from' => '16105552344',
            //  'text' => $trans->description
            // ]);

            return response()->json(array('data' => 'success'));
        }else{
            return response()->json(array('data'=> 'over'));
        }
    }

    public function debit($id, Request $request){
        $monthly_cal = monthly_calculation::find($id);
        $total_cost = $monthly_cal->meal_cost + $monthly_cal->seat_bill + $monthly_cal->internet_bill + $monthly_cal->elec_bill;
        $surplus = $monthly_cal->deposit - $total_cost;

        $month = createmonth_calculation::find($monthly_cal->month_id);
        $month = $month->month;
        $month = Carbon::createFromDate($month);
        $month = $month->format('F Y');

        if ($request->deposit <= $surplus) {
            $monthly_cal->deposit = $monthly_cal->deposit - $request->deposit;
            $monthly_cal->save();
            $student = student::find($monthly_cal->std_id);
            $old_balance = $student->init_deposit;
            $student->init_deposit = $student->init_deposit + $request->deposit;
            $student->save();

            $trans = new transaction();
            $trans->std_id = $student->id;
            $trans->type = 'Debit';
            $trans->amount = $request->deposit;
            $trans->old_balance = $old_balance;
            $trans->new_balance = $student->init_deposit;
            $trans->description = 'Your account balance has been debited ' . $request->deposit . 'Tk from the  month ' . $month . '. Your old balance was ' . $trans->old_balance . 'Tk and now your updated balance is ' . $trans->new_balance . 'Tk.';
            $trans->save();

            // Nexmo::message()->send([
            //  'to'   => '8801677153967',
            //  'from' => '16105552344',
            //  'text' => $trans->description
            // ]);

            return response()->json(array('data' => 'success'));
        } else {
            return response()->json(array('data' => 'over'));
        }
        return response()->json();
    }

    public function viewtransaction() {
        $trans = transaction::all();
        return view('transaction.view')->with('page','transaction')->with(compact('trans'));
    }

}
