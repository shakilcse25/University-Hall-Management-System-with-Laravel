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
            <li class="breadcrumb-item"><a href="{{route('view.monthpage')}}">Select Month</a></li>
            <li class="breadcrumb-item active">All Meal(s) of {{date('F, Y', strtotime($mn))}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

        <div class="content-header">
            <div class="container-fluid">
                <div class="all_action" style="margin-bottom:20px;margin-top:20px;">
                    <form action="{{route('store.meal')}}" method="post">
                        @csrf
                        <p style="font-size: 20px;font-weight: bold;">Add new meal at {{date('F, Y', strtotime($mn))}} : </p>
                        <label for="date">Date:</label>
                        <input type="date" class="form-control" name="meal_date" style="width: 20%;display: inline-block;margin-right:10px;" min="{{$y}}-{{$m}}-01" max="{{$y}}-{{$m}}-{{$dt}}">
                        <label for="bazar_cost">Bazar Cost:</label>
                        <input type="text" name="bazar_cost" id="bazar_cost" class="form-control" style="width: 20%;display: inline-block;" required>

                        <input class="btn btn-success" type="submit" name="add_meal" value="Add New Meal" style="vertical-align: top;margin-left: 15px;">
                    </form>
                </div>
            </div>
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
                                @php
                                    $total_meal = 0;
                                @endphp
                                @foreach ($item->student_meal as $std_meal)
                                    @php
                                        $total_meal = $total_meal + $std_meal->meal_no;
                                    @endphp
                                @endforeach

                            <tr>
                                <td>{{\Carbon\Carbon::parse($item->meal_date)->format('d/m/Y')}}</td>
                                <td>{{$item->bazar_cost}}</td>
                                <td>{{$total_meal}}</td>
                                <td>
                                    <a href="{{ route('edit.student_meal', ['id' => $item->id]) }}" class="btn btn-info">Manage Meal</a>
                                    <a href="" data-toggle="modal" data-target="#myModal{{$item->id}}" class="btn btn-primary">Edit</a>
                                    <a onclick="return confirm('Are You Sure to Delete?');" href="{{route('delete.meal',['id'=>$item->id])}}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>



                                <!-- Modal -->
                                <div id="myModal{{$item->id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Update Meal's Information</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form style="margin-bottom: 20px;padding: 15px;" class="form-horizontal form-label-left" novalidate
                                                    action="{{route('meal.update',['id' => $item->id])}}" method="post" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="form-group">
                                                        <label for="">Bazar Cost</label>
                                                        <input type="number" name="bazar_cost" class="form-control" value="{{$item->bazar_cost}}"
                                                            required>
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
                                </div>
                                {{-- End Modal --}}

                                @endforeach
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
