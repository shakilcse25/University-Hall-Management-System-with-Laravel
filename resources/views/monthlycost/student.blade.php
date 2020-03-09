@extends('layout.app')
@section('section')
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
          <h1 class="m-0 text-dark">Student's monthly calculation(<?php echo date('F, Y', strtotime($month->month)); ?>)</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('monthly.cost')}}">select month</a></li>
            <li class="breadcrumb-item active">Monthly Calculation</li>
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
                    <h3 class="card-title">DataTable with student monthly calculation</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
            <div class="x_panel">
                <div class="all_action"
                    style="margin-bottom:20px;margin-top:20px;border-bottom: 2px solid #80808042display:flow-root;">
                    <div style="text-align:center;">
                        <p>
                            <span style="font-weight:bold;margin:0px 10px;"><?php echo date('F, Y', strtotime($month->month)); ?></span>|
                            <span style="font-weight:bold;margin:0px 10px;"> Electric Bill: {{$month->elec_bill}} </span>|
                            <span style="font-weight:bold;margin:0px 10px;"> Internet Bill: {{$month->internet_bill}} </span>
                        </p>
                    </div>
                    <hr>
                </div>
                <div class="add_btn">
                    <button class="btn btn-success" data-toggle="modal" data-target="#addexist" style="margin-bottom:10px;">Add Student</button>


                    <!-- Modal -->
                    <div id="addexist" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Student to this month</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <tr>
                                            <th>Name</th>
                                            <th>ID</th>
                                            <th>Batch</th>
                                            <th>Dept</th>
                                            <th>Room No</th>
                                            <th>Action</th>
                                        </tr>
                                        @if (count($existstudent) > 0)

                                            @foreach ($existstudent as $item)
                                            @if (isset($item->id))
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->dept_id}}</td>
                                                <td>{{$item->batch}}</td>
                                                <td>{{$item->dept}}</td>
                                                <td>{{$item->room->room_no}}</td>
                                                <td>
                                                    <form action="{{route('addstd.month')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" value="{{$item->id}}" name="stdid">
                                                        <input type="hidden" value="{{$id}}" name="monthid">
                                                        <input type="submit" class="btn btn-success" value="Add">
                                                    </form>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach

                                        @endif
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- End Modal --}}
                </div>
                <div class="x_content">
                    <input type="hidden" name="monthurl" id="monthlyurl" value="{{ route('monthly.coststudentApi',['id' => $id]) }}">
                    <table id="monthcal" class="table table-striped table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                                {{-- <th>Name</th> --}}
                                <th>ID</th>
                                <th>Room</th>
                                <th>Electric Bill</th>
                                <th>Internet Bill</th>
                                <th>Seat Charge</th>
                                <th>Total Meal</th>
                                <th>Meal Charge</th>
                                <th>Total Cost</th>
                                <th>Total Deposit</th>
                                <th>Surplus</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

  </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
  @endsection




{{--
  @if (isset($monthcost))
@foreach ($monthcost as $item)
@if (isset($item->student->id))
@php
$total_cost = ($item->elec_bill + $item->internet_bill + $item->seat_bill + $item->meal_cost);

$surplus = $item->deposit - $total_cost;
@endphp

<tr>
    {{-- <td>{{$item->student->name}}</td> --}}
    {{-- <td>{{$item->student->dept_id}}</td>
    <td>{{$item->room_no}}</td>
    <td>{{$item->elec_bill}}</td>
    <td>{{$item->internet_bill}}</td>
    <td>{{$item->seat_bill}}</td>
    <td>{{$item->meal_no}}</td>
    <td>{{$item->meal_cost}}</td>
    <td>{{ $total_cost }}</td>
    <td>{{$item->deposit}}</td>
    <td @if ($surplus> 0)
        style="background-color:#228b22b5;color:#000;"
        @endif
        @if ($surplus < 0) style="background-color:#ff00008a;color:#000;" @endif>{{ $surplus }}</td>

    <td> <a href="" class="btn btn-primary" data-toggle="modal" data-target="#myModal{{$item->id}}">Update</a> <a
            href="{{route('delete.monthstudent',['id' => $item->id])}}" class="btn btn-danger">Delete</a> </td>
</tr> --}}


<!-- Modal -->
{{-- <div id="myModal{{$item->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog"> --}}

        <!-- Modal content-->
        {{-- <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Monthly Calulation for {{$item->student->name}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form style="margin-bottom: 20px;padding: 15px;" class="form-horizontal form-label-left" novalidate
                    action="{{route('monthly.costupdate',['id' => $item->id])}}" method="post"
                    enctype="multipart/form-data">
                    @csrf


                    <div class="form-group">
                        <label for="">Deposit(This Month)</label>
                        <input type="number" name="deposit" class="form-control" value="{{$item->deposit}}" required>
                    </div>

                    <p class="text-center">
                        <input style="width:110px;" type="submit" class="btn btn-success" value="Update">
                    </p>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div> --}}
{{-- End Modal --}}
{{-- @endif
@endforeach
@endif --}}
