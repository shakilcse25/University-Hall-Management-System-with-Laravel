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
            @if (isset($meal_infor))
          <h1 class="m-0 text-dark">Student's Meal at - {{\Carbon\Carbon::parse($meal_infor->meal_date)->format('d/m/Y')}}</h1>
            @endif
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('view.monthpage')}}">Select Month</a></li>
            <li class="breadcrumb-item active">Student's Meal</li>
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
                    <h3 class="card-title">DataTable with student's meal</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">

                <div class="x_content">
                    @if (isset($meal_infor))
                        <div class="information">
                            <p style="text-align:center;font-size:18px;">
                                <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                    <strong>Date: </strong>{{\Carbon\Carbon::parse($meal_infor->meal_date)->format('d/m/Y')}}
                                </span>

                                <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                    <strong>Bazar Cost: </strong>{{$meal_infor->bazar_cost}}
                                </span>
@if(count($student_meal) > 0)
    @php
        $meal_cost = 0;
        $meal_no = 0;
    @endphp
    @foreach ($student_meal as $item)
        @php
            $meal_cost = $meal_cost + $item->meal_cost;
            $meal_no = $meal_no + $item->meal_no;
        @endphp
    @endforeach
@endif


                                <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                    <strong>Meal No: </strong><span id="meal_no">{{$meal_no}} + {{$emp_meal_no}}</span>
                                </span>
                                <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                    <strong>Total Meal Cost: </strong><span id="total_mealcost">{{number_format($meal_cost,0)}}</span>
                                </span>
                                <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                    <strong>Meal Rate: </strong><span id="meal_rate">{{number_format($meal_rate,1)}}</span>
                                </span>
                                <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                    <strong>Avg Employee Cost: </strong><span id="avg_emp_cost">{{number_format($avg_emp_cost,1)}}</span>
                                </span>



                            </p>
                        </div>
                    @endif
<input type="hidden" id="getUrl" value="{{url('/student_meal_api/'.$id)}}">
<input type="hidden" id="searchUrl" value="{{url('/view_search_meal_student/'.$id)}}">
                    <hr>
                    <table id="mealday" class="table table-striped table-bordered" style="width:100%;">


                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>ID</th>
                                <th>Room</th>
                                <th>Batch</th>
                                <th>Department</th>
                                <th>Meal No</th>
                                <th>Meal Cost</th>
                                <th>Egg</th>
                                {{-- <th>Action</th> --}}
                            </tr>

                            <tr>
                                <th>Name</th>
                                <th>ID</th>
                                <th>Room</th>
                                <th>Batch</th>
                                <th>Department</th>
                                <th>Meal No</th>
                                <th>Meal Cost</th>
                                <th>Egg</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>


                        <tbody id="tbodydata">

                        </tbody>

                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>ID</th>
                                <th>Room</th>
                                <th>Batch</th>
                                <th>Department</th>
                                <th>Meal No</th>
                                <th>Meal Cost</th>
                                <th>Egg</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </tfoot>

                    </table>
                    {{-- <p style="text-align:center;font-size:20px;"><strong>Total Meal Cost: {{number_format($total_cost,0)}}</strong></p> --}}


                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

      </div><!--/. container-fluid -->
    </section>

    <style>
        thead tr:last-child input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
        font-size: 12px;
        }
    </style>

    <!-- /.content -->
  @endsection



{{--
  @if(count($student_meal) > 0)
@php
$total_cost = 0;
@endphp
@foreach ($student_meal as $item)
@if (isset($item->student->name))
@php
$total_cost = $total_cost + $item->meal_cost;
@endphp
<tr>
    <td>{{$item->student->name}}</td>
    <td>{{$item->student->dept_id}}</td>
    <td>{{$item->room_no}}</td>
    <td>{{$item->student->batch}}</td>
    <td>{{$item->student->dept}}</td>


    <td>
        <form id="meals" name="myform" action="{{route('update.daily_meal',['id' => $item->id])}}" method="POST">
            @csrf
            <input type="hidden" name="meal_id" value="{{$id}}">
            <select type='submit' name="meal_no" onchange="this.form.submit();" class="meal_no">
                <option value="0" @if ($item->meal_no == '0')
                    selected
                    @endif >0</option>
                <option value="1" @if ($item->meal_no == '1')
                    selected
                    @endif >1</option>
                <option value="0.5" @if ($item->meal_no == '0.5')
                    selected
                    @endif >0.5</option>
                <option value="2" @if ($item->meal_no == '2')
                    selected
                    @endif >2</option>
            </select>
        </form>
    </td>
    <td>{{number_format($item->meal_cost,1)}}</td>
    <td>
        <form action="{{route('update.egg',['id' => $item->id])}}" method="post" id="egg{{$item->id}}">
            @csrf
            <input type="hidden" name="meal_id" value="{{$id}}">
            <input onchange="this.form.submit();" type="checkbox" style="height:16px;width:24px;" name="egg" @if
                ($item->egg == 1)
            checked
            @endif>
        </form>
    </td>
    <td><a href="{{$item->id}}" class="btn btn-danger">Delete</a> </td>
</tr>
@endif
@endforeach

@endif --}}
