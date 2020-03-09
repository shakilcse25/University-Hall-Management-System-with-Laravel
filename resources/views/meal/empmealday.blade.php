@extends('layout.app')
@section('section')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Employee's Meal at - {{\Carbon\Carbon::parse($meal_infor->meal_date)->format('d/m/Y')}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('view.empmonthpage')}}">Select Month</a></li>
            <li class="breadcrumb-item active">Employee's Meal</li>
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
                    <h3 class="card-title">DataTable with employee's meal</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Employee Meal in this month</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    @if (isset($meal_infor))
                    <div class="information">
                        <p style="text-align:center;font-size:18px;">
                            <span
                                style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                <strong>Date:
                                </strong>{{\Carbon\Carbon::parse($meal_infor->meal_date)->format('d/m/Y')}}
                            </span>

                            <span
                                style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                <strong>Bazar Cost: </strong>{{$meal_infor->bazar_cost}}
                            </span>
                            @if(count($employee) > 0)
                            @php
                            $meal_cost = 0;
                            $meal_no = 0;
                            @endphp
                            @foreach ($employee as $item)
                            @php
                            $meal_cost = $meal_cost + $item->meal_cost;
                            $meal_no = $meal_no + $item->meal_no;
                            @endphp
                            @endforeach
                            @endif


                            <span
                                style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                <strong>Meal No: </strong>{{$meal_no}}
                            </span>
                            <span
                                style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                <strong>Total Meal Cost: </strong>{{number_format($meal_cost,0)}}
                            </span>
                            <span
                                style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                <strong>Meal Rate: </strong>{{number_format($meal_rate,2)}}
                            </span>
                            <span
                                style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                <strong>Avg Employee Cost: </strong>{{number_format($avg_emp_cost,2)}}
                            </span>



                        </p>
                    </div>
                    @endif

                    <hr>
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Job Position</th>
                                <th>Phone</th>
                                <th>Meal no</th>
                                <th>Mela Cost</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>


                        <tbody>
                            @if(count($employee) > 0)
                            @php
                            $total_cost = 0;
                            @endphp
                            @foreach ($employee as $item)
                            @php
                            $total_cost = $total_cost + $item->meal_cost;
                            @endphp
                            <tr>
                                <td>{{$item->emp->name}}</td>
                                <td>{{$item->emp->position}}</td>
                                <td>{{$item->emp->phone}}</td>
                                <td>
                                    <form id="meals" name="myform" action="{{route('update.empdaily_meal',['id' => $item->id])}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="meal_id" value="{{$id}}">
                                        <select type='submit' name="meal_no" onchange="this.form.submit();"
                                            class="meal_no">
                                            <option value="0" @if ($item->meal_no == '0')
                                                selected
                                                @endif >0</option>
                                            <option value="1" @if ($item->meal_no == '1')
                                                selected
                                                @endif >1</option>
                                        </select>
                                    </form>
                                </td>
                                <td>{{number_format($item->meal_cost,1)}}</td>

                                {{-- <td><a href="{{$item->id}}" class="btn btn-danger">Delete</a> </td> --}}
                            </tr>
                            @endforeach

                            @endif

                        </tbody>
                    </table>
                    <p style="text-align:center;font-size:20px;"><strong>Total Meal Cost:
                            {{number_format($total_cost,0)}}</strong></p>

                    {{--  <script>
   function submitThisForm(id){
        url= '{{route('update.daily_meal',[":id"])}}';
                    url= url.replace(':id', id);

                    $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });

                    $.ajax( {
                    url: url,
                    type: 'POST',
                    data: $('#meals').serialize(),
                    success: function(result){
                    console.log(result);
                    }
                    });
                    }
                    </script> --}}


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
