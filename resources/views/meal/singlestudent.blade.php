@extends('layout.app')
@section('section')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Search Single Student Meal</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Single Student Meal</li>
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
                    <h3 class="card-title">DataTable with all meal history of this student</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="x_title">
                        <h2>Search Student Meal of a specific month</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        @if (count($errors) > 0)
                        <div style="margin-bottom:20px;">
                            @foreach ($errors->all() as $error)
                            <div style="margin:0px auto;width:700px;padding:10px 35px 10px 10px;margin-bottom:10px;"
                                class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">×</span>
                                </button>
                                {{$error}}
                            </div>
                            @endforeach
                        </div>
                        @endif

                        @if (!empty($searchid))


                        <div class="btn_area" style="overflow: hidden;margin: 30px 0px;padding-right:30px;">
                            <button onclick="pdfbtnfun('{{$searchid->dept_id.'_'.date('F, Y', strtotime($month))}}');" style="float:right;overflow:hidden;" class="btn btn-success" id="pdfbtn"> Export Pdf</button>
                        </div>

                        @endif

                        <div class="monthlycost"
                            style="padding: 24px;background-color: ghostwhite;margin-bottom: 10px;">
                            <form style="margin-bottom: 20px;margin-bottom: 20px;background-color: #7080903d;padding: 15px;" class="form-horizontal form-label-left row" novalidate
                                action="{{route('search.single_student_meal')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group col-sm-3">
                                    <label for="">Student ID:</label>
                                    <input type="number" name="dept_id" value="{{ old('dept_id') }}" class="form-control" required>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="" style="">Select Month:-</label>
                                    <input type="month" class="form-control " name="month" class=""
                                        placeholder="Select Month" value="{{ old('month') }}"  required>
                                </div>

                                <p class="text-center" style="display:inline-block;margin-top:7px;">
                                    <input style="width:110px;margin-top:24px;" type="submit" class="btn btn-success" value="Search">
                                </p>

                            </form>
                            <div class="x_content" id="pdfview">
                                <div class="infor" style="margin-top:80px;" id="singleinfo">
                                    @if (!empty($searchid))
                                        <p style="text-align:center;font-size:18px;">
                                            <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                                <strong>Month: </strong><?php echo date('F, Y', strtotime($month)); ?>
                                            </span>
                                            <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                                <strong>Name: </strong>{{$searchid->name}}
                                            </span>
                                            <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                                <strong>ID: </strong>{{$searchid->dept_id}}
                                            </span>
                                            <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                                <strong>Batch: </strong>{{$searchid->batch}}
                                            </span>
                                            <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                                <strong>Department: </strong>{{$searchid->dept}}
                                            </span>
                                        </p>
                                    @endif
                                    <p style="text-align:center;font-size:18px;">


                                            @if (count($ob_allstd) > 0)
                                            @php
                                                $meal_no = 0;
                                                $meal_cost = 0;
                                            @endphp
                                                @foreach ($ob_allstd as $item)
                                                    @php
                                                        $meal_cost = $meal_cost + $item->meal_cost;
                                                        $meal_no = $meal_no + $item->meal_no;
                                                    @endphp
                                                @endforeach
                                                <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                                    <strong>Total Meal No: </strong>{{$meal_no}}
                                                </span>
                                                <span style="padding-right:10px;padding-left:10px;padding:5px;border-right:1px dotted gray;">
                                                    <strong>Total Meal Cost: </strong>{{$meal_cost}}
                                                </span>


                                            @endif




                                    </p>
                                </div>
                                <table class="table" id="singlemeal">
                                    <tr>
                                        <th>Date</th>
                                        <th>Meal No</th>
                                        <th>Meal Cost</th>
                                        <th>Egg</th>
                                    </tr>
                                    @if (count($ob_allstd) > 0)
                                    @foreach ($ob_allstd as $item)
                                    <tr>
                                        <td>{{\Carbon\Carbon::parse($item->meal->meal_date)->format('d/m/Y')}}</td>
                                        <td>{{$item->meal_no}}</td>
                                        <td>{{$item->meal_cost}}</td>
                                        <td>{{$item->egg}}</td>

                                    </tr>

                                    @endforeach
                                    @else
                                    <p><strong>No Data Found!</strong></p>
                                    @endif
                                </table>
                            </div>
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
