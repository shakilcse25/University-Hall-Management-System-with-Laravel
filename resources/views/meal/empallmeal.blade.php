@extends('layout.app')
@section('section')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">All Meal(s) day of {{date('F, Y', strtotime($mn))}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('view.empmonthpage')}}">Select Month(Employee)</a></li>
            <li class="breadcrumb-item active">All Meal(s) of {{date('F, Y', strtotime($mn))}}</li>
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
                    <h3 class="card-title">DataTable with all meals at this month.</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Total Meal day of {{date('F, Y', strtotime($mn))}}</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div class="infor" style="text-align: center;margin: 24px 0px;font-size: 18px;">
                        @php
                        $month = '';
                        @endphp
                        @foreach ($meal as $item)
                        @php
                        $month = $item->meal_date;
                        @endphp
                        @endforeach
                        <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                            <strong>Month: </strong>{{date('F, Y', strtotime($mn))}}
                        </span>
                        <span style="padding-right:10px;padding-left:10px;padding:5px;">
                            <strong>Total Meal Day: </strong>{{count($meal)}}
                        </span>

                    </div>
                    <table id="" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Bazar Cost</th>
                                <th>No of Meal</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @if (count($meal) > 0)
                            @foreach ($meal as $item)
                            <tr>
                                <td>{{\Carbon\Carbon::parse($item->meal_date)->format('d/m/Y')}}</td>
                                <td>{{$item->bazar_cost}}</td>
                                <td>{{$item->emp_meal->count()}}</td>
                                <td> <a href="{{ route('edit.emp_meal', ['id' => $item->id]) }}" class="btn btn-info" style="margin-right:10px;">View</a>
                                </td>
                            </tr>
                            @endforeach
                            @endif

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
