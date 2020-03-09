<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\student;
use App\room;
use App\Fillvacent;
use Session;
use App\batch;
use App\department;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class StudentController extends Controller
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
    public function index()
    {
        $student = student::all()->where('status', 1);
        $department = department::all();
        $batch = batch::all();
        return view('student.view')->with('page', 'viewstudent')->with('student',$student)->with(compact('department','batch'));;
    }

    public function find(Request $request)
    {
        $search = array();
        $student = student::all();
        if ($request->status_res && $request->status_nonres) {
            $student = student::all();
            array_push($search,'res');
            array_push($search,'nonres');
        }
        else if($request->status_res){
            array_push($search, 'res');
            $student = $student->where('status', 1);
        }
        else if($request->status_nonres){
            array_push($search, 'nonres');
            $student = $student->where('status', 0);
        }
        else{
            $student = [];
        }

        if ($request->batch) {
            $arr=array();
            foreach ($request->batch as $value) {
                array_push($search, $value);
                array_push($arr,$value);
            }
            if (!in_array('allbatch',$search)) {
                $student = $student->whereIn('batch', $arr);
            }

        }

        if ($request->dept) {
            $arr = array();
            foreach ($request->dept as $value) {
                array_push($search, $value);
                array_push($arr, $value);
            }
            if (!in_array('alldept', $search)) {
                $student = $student->whereIn('dept', $arr);
            }

        }
        $department = department::all();
        $batch = batch::all();

        return view('student.view')->with('page', 'viewstudent')->with(compact('student','search','department','batch'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($roomid)
    {
        $department = department::all();
        $batch = batch::all();
        return view('student.fill')->with('page', 'viewroom')->with('roomid', $roomid)->with(compact('department','batch'));
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
            'profile_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'required',
            'dept' => 'required',
            'dept_id' => 'required|integer|unique:students',
            'batch' => 'required',
            'session' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'parent_phone' => 'required',
            'email' => 'required|email|unique:students',
            'student_phone' => 'required',
            'roomid' => 'required',
            'blood_group' => 'required',
            'init_deposit' => 'required'
        ]);
        $profile_img = $request->profile_img;
        $profile_img_new = time().$profile_img->getClientOriginalName();
        $profile_img->move('uploads/student_profile', $profile_img_new);

        $student = new student();
        $student->profile_img = 'uploads/student_profile/'.$profile_img_new;
        $student->name = $request->name;
        $student->dept = $request->dept;
        $student->dept_id = $request->dept_id;
        $student->batch = $request->batch;
        $student->session = $request->session;
        $student->father_name = $request->father_name;
        $student->father_phone = $request->father_phone;
        $student->mother_name = $request->mother_name;
        $student->mother_phone = $request->mother_phone;
        $student->parent_phone = $request->parent_phone;
        $student->email = $request->email;
        $student->student_phone = $request->student_phone;
        $student->blood_group = $request->blood_group;
        $student->init_deposit = $request->init_deposit;
        $room = room::where('id',$request->roomid)->get();
        if ($room == null) {
            $roomcount = 0;
        }
        else{
            $roomcount =  $room->count();
            $room = $room->first();

        }

        if ($roomcount > 0) {
            $total_fill = $room->activestudents->count();
            if ($total_fill < $room->total_seat ) {
                $student->room_id = $request->roomid;
                $student->status = 1;
                $insert = $student->save();
                if($insert){
                    $fillvacent = new Fillvacent;
                    $fillvacent->student_id = $student->id;
                    $fillvacent->room_id = $room->id;
                    $fillvacent->status = 'fill';
                    $fillvacent->save();
                    $request->session()->flash('success','New Student Data Added Successfully!');
                }
                else{
                    $request->session()->flash('inserterror', 'New Student Data Not Added!');
                }
            }
            else{
                $request->session()->flash('maxfill', 'Room is Full!');
            }
        }
        else {
            $request->session()->flash('invalidroom', 'Room number is invalid in Database!');
        }

        return redirect()->route('view.room');
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
        $student = student::find($id);
        return view('student.update')->with('page', 'viewstudent')->with(compact('id','student'));
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
        $this->validate($request, [
            'name' => 'required',
            'dept' => 'required',
            'dept_id' => 'required|integer|unique:students,dept_id,'.$id,
            'batch' => 'required',
            'session' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'parent_phone' => 'required',
            'email' => 'required|email|unique:students,email,' . $id,
            'student_phone' => 'required',
            'blood_group' => 'required',
            'init_deposit' => 'required'
        ]);
        $student = student::find($id);

        $profile_img = $request->profile_img;
        if ($profile_img !== null) {
            $profile_img_new = time() . $profile_img->getClientOriginalName();
            $profile_img->move('uploads/student_profile', $profile_img_new);
            $student->profile_img = 'uploads/student_profile/' . $profile_img_new;
        }


        $student->name = $request->name;
        $student->dept = $request->dept;
        $student->dept_id = $request->dept_id;
        $student->batch = $request->batch;
        $student->session = $request->session;
        $student->father_name = $request->father_name;
        $student->father_phone = $request->father_phone;
        $student->mother_name = $request->mother_name;
        $student->mother_phone = $request->mother_phone;
        $student->parent_phone = $request->parent_phone;
        $student->email = $request->email;
        $student->student_phone = $request->student_phone;
        $student->blood_group = $request->blood_group;
        $student->init_deposit = $request->init_deposit;
        $update = $student->save();
        if($update){
            Alert::success('Success', 'Information Updated Successfully!');
        }

        return redirect()->route('edit.student',['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = student::find($id);
        if ($student != null) {
            $student->delete();
            Session::flash('successdel', 'Student Deleted Successfully!');
            Alert::success('Success', 'Student Deleted Successfully!');
        }


        return redirect()->route('view.student');
    }

    public function vacent($id) {
        $student = student::find($id);

        $fillvacent = new Fillvacent;
        $fillvacent->student_id = $student->id;
        $fillvacent->room_id = $student->room->room_no;
        $fillvacent->status = 'Vacent';
        $fillvacent->save();


        $student->status = '0';
        $student->room_id = null;
        $vacent = $student->save();
        if($vacent){
            Alert::success('Success', $student->name.' Vacent Successfully!');
        }
        return redirect()->route('view.room');
    }
    public function fillpage($room_id){
        $student = student::where('status',0)->get();
        return view('student.fillexist')->with('page', 'viewroom')->with(compact('student', 'room_id'));
    }

    public function fill($id,$room_id)
    {
        $student = student::find($id);
        $student->room_id = $room_id;
        $student->status = '1';
        $student->save();
        $fillvacent = new Fillvacent;

        $fillvacent->student_id = $student->id;
        $fillvacent->room_id = $student->room->room_no;
        $fillvacent->status = 'Fill';
        $succ = $fillvacent->save();
        if($succ){
            Alert::success('Success', 'Student Filled Successfully!');
        }

        return redirect()->route('view.room');
    }

}
