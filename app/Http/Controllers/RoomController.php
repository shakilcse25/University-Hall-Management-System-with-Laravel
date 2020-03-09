<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\room;
use App\student;
use App\Fillvacent;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RoomController extends Controller
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
        $room = room::all();
        foreach ($room as $value) {
            $total_fill = $value->activestudents;
            $fillcount = $total_fill->count();
            $available = $value->total_seat - $fillcount;
            $roomtable = DB::table('rooms')
                            ->where('room_no', $value->room_no)
                            ->update(['available' => $available]);
        }
        $room = room::all();

        return view('room.view')->with('page', 'viewroom')->with('room',$room);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('room.create')->with('page', 'createroom');;
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
            'room_no' => 'required|unique:rooms',
            'total_seat' => 'required',
            'room_charges' => 'required'
        ]);
        $room = new room();
        $room->room_no = $request->room_no;
        $room->total_seat = $request->total_seat;
        $room->room_charges = $request->room_charges;
        $insert = $room->save();
        if ($insert) {
            $request->session()->flash('success', 'New Room Data Added Successfully!');
        } else {
            $request->session()->flash('inserterror', 'New Room Data Not Added!');
        }
        return redirect()->route('create.room');
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
        $this->validate($request, [
            'total_seat' => 'required',
            'room_charges' => 'required'
        ]);
        $room = room::find($id);
        $room->total_seat = $request->total_seat;
        $room->room_charges = $request->room_charges;
        $insert = $room->save();
        if ($insert) {
            Alert::success('Success', 'Room Information Updated Successfully!');
        } else {
            Alert::error('Opps', 'Something Going Wrong!');
        }
        return redirect()->route('view.room');
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


    function showfillVacent() {
        $fillvacent = Fillvacent::orderBy('id', 'DESC')->get();
        return view('room.fillvacent')->with('page','fillvacent')->with(compact('fillvacent'));
    }
}
