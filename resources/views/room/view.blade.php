@extends('layout.app')
@section('section')
<style>
    .modal h3,
    .modal h4 {
        font-size: 110% !important;
    }
</style>
  @php
     if (!isset($search)){
          $search = array();
     }
  @endphp
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Manage Rooms</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">All Room</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">DataTable with Room Details</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="student" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Room No</th>
                                <th>Room Charge(Per Sit)</th>
                                <th>Max Sit</th>
                                <th>Student</th>
                                <th>Available Sit</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
            @if (count($room) > 0)
            @php
                $i = 0;
            @endphp
                @foreach ($room as $data)
                @php
                    $i++;
                @endphp
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$data->room_no}}</td>
                        <td>{{$data->room_charges}}</td>
                        <td>{{$data->total_seat}}</td>
                        <td>
                            @foreach ($data->activestudents as $st)
                                <a href="" data-toggle="modal" data-target="#myModal{{$st->id}}" > {{$st->name}} </a>

                                    <br>


                            <!-- Modal -->
                            <div id="myModal{{$st->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content"  style="width:800px;">
                                        <div class="modal-header">

                                            <h4 class="modal-title" style="text-align:center;font-size:20px;"><strong>Room Allocation Date:</strong>
                                                @if (isset($st->fillvacent->last()->created_at))
                                                    {{\Carbon\Carbon::parse($st->fillvacent->last()->created_at)->format('d/m/Y')}}
                                                @endif
                                            </h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="profile_img" style="margin-bottom:20px;">
                                                <div class="img_inner" style="width:200px;height:200px;margin:0px auto;">
                                                    <img src="{{asset($st->profile_img)}}" alt=""
                                                        style="border-radius:50% 50%;border:1px solid gainsboro;height:100%;width:100%;padding:10px;">
                                                </div>
                                            </div>
                                            <div class="basic">
                                                <h3 style="text-align:center;font-weight:bold;">{{$st->name}}</h3>
                                                <h4 style="text-align:center;">
                                                    <span style="margin-right:10px;"><i style="font-weight:bold;">ID: </i>{{$st->dept_id}}</span>
                                                    <span style="margin-right:10px;"><i style="font-weight:bold;">DEPT: </i>{{$st->dept}}</span>
                                                    <span style="margin-right:10px;"><i style="font-weight:bold;">Batch: </i>{{$st->batch}}</span>
                                                    <span style="margin-right:10px;"><i style="font-weight:bold;">Blood Group:
                                                        </i>{{$st->blood_group}}</span>
                                                </h4>
                                                <h4 style="text-align:center;"> <span style="font-weight:bold;">Phone:
                                                    </span>{{$st->student_phone}} </h4>
                                                <h4 style="text-align:center;"> <span style="font-weight:bold;">Gmail: </span>{{$st->email}}</h4>
                                            </div>
                                            <hr>
                                            <div class="all">
                                                <h4
                                                    style="display: grid;padding: 10px 30px;grid-template-columns: auto auto;row-gap: 20px;column-gap: 20px;">
                                                    <span style="margin-right:10px;"><i style="font-weight:bold;">Room No:
                                                        </i>{{$st->room['room_no']}}</span>
                                                    <span style="margin-right:10px;"><i style="font-weight:bold;">Session:
                                                        </i>{{$st->session}}</span>
                                                    <span style="margin-right:10px;"><i style="font-weight:bold;">Father Name:
                                                        </i>{{$st->father_name}}</span>
                                                    <span style="margin-right:10px;"><i style="font-weight:bold;">Father Phone:
                                                        </i>{{$st->father_phone}}</span>
                                                    <span style="margin-right:10px;"><i style="font-weight:bold;">Mother Name:
                                                        </i>{{$st->mother_name}}</span>
                                                    <span style="margin-right:10px;"><i style="font-weight:bold;">Mother Phone:
                                                        </i>{{$st->mother_phone}}</span>
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <h4 style="text-align:center;"> <span style="font-weight:bold;">Registered Date:
                                                </span>{{\Carbon\Carbon::parse($st->created_at)->format('d/m/Y')}}</h4>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- End Modal --}}


                            @endforeach
                        </td>
                        <td>{{$data->available}}</td>
                        <td>
                        <a href="{{route('create.student',['roomid' => $data->id])}}" @if ($data->available <= 0 )
                            style="pointer-events: none;cursor:default;background-color:transparent;color:black;" data-container="body" data-toggle="popover" data-placement="left" data-content="" data-original-title="" title="Maximum Students Already"
                        @endif class="btn btn-info">Fill</a>
                        <a href="" class="btn" data-toggle="modal" data-target="#modal{{$data->room_no}}" style="background-color:purple;color:#fff;">Vacent</a>
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modal{{$data->id.$data->room_no}}">Update</a>
                        <a href="" class="btn btn-danger">Delete</a></td>
                    </tr>

                    <!-- Modal -->
                    <div id="modal{{$data->room_no}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Student in the Room</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" style="">
                                    @foreach ($data->activestudents as $st)
                                    <ul class="list-group">
                                        <li class="list-group-item" style="padding: 6px 10px;display:flow-root;">
                                            <a style="line-height:2.4;">{{$st->name}}({{$st->dept_id}})</a>
                                            <a href="{{route('vacent.student',['id'=>$st->id])}}" class="btn" style="background-color:purple;color:#fff;float:right;padding:3px 20px;line-height:1.7;margin:0px;">Vacent</a>
                                        </li>
                                    </ul>

                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>



                    <!-- Modal -->
                    <div id="modal{{$data->id.$data->room_no}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Update Room Information</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" style="overflow:hidden;">
                                    <form class="form-horizontal form-label-left" action="{{route('update.room',['id'=> $data->id])}}" method="post" enctype="multipart/form-data">
                                        @csrf



                                        <div class=" form-group" style="display:flex;margin-bottom:5px;">
                                            <label class="col-md-6 col-sm-6 col-xs-12" for="total_seat">Total Sit<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="total_seat" class="form-control col-md-12 col-xs-12" name="total_seat" type="number" value="{{$data->total_seat}}" required="required">
                                            </div>
                                        </div>

                                        <div class="form-group" style="display:flex;margin-bottom:5px;">
                                            <label class="col-md-6 col-sm-6 col-xs-12" for="room_charges">Room Charge(Per Sit)<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="room_charges" class="form-control col-md-12 col-xs-12" name="room_charges" type="number" value="{{$data->room_charges}}" required="required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input type="submit" class="btn btn-success" style="float: right;margin: 15px 0px;" value="Update" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>

                @endforeach
            @else
                <p>No Room Record is available!</p>
            @endif
                        </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

          </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
      @endsection
