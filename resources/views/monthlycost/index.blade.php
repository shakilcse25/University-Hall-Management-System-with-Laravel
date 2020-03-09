@extends('layout.app')
@section('section')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Update and Manage student's monthly calculation</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">All month</li>
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
                    <h3 class="card-title">DataTable to manage availabe month's calculation </h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                <div class="x_panel">
                    <div class="x_content">
                        @if (count($errors) > 0)
                        <div style="margin-bottom:20px;">
                            @foreach ($errors->all() as $error)
                            <div style="margin:0px auto;width:700px;padding:10px 35px 10px 10px;margin-bottom:10px;"
                                class="alert alert-danger alert-dismissible fade-in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">×</span>
                                </button>
                                {{$error}}
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="monthlycost" style="padding: 24px;background-color: ghostwhite;margin-bottom: 10px;">
                            <div class="x_title">
                                <h2 style="font-size:20px;font-weight:bold;">Add New Month:</h2>
                            </div>
                            <form style="margin-bottom: 20px;margin-bottom: 20px;background-color: #7080903d;padding: 15px;" class="form-horizontal form-label-left row" novalidate action="{{route('monthly.storecost')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group col-sm-3">
                                    <label for="" style="">Month:-</label>
                                    <input type="month" class="form-control " name="month" class="" placeholder="Select Month">
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="">Electicity Bill</label>
                                    <input type="number" name="elec_bill" class="form-control">
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="">Internet Bill</label>
                                    <input type="number" name="internet_bill" class="form-control">
                                </div>

                                <p class="text-center" style="display: flex;align-items: flex-end;">
                                    <input style="width:110px;margin-top:24px;" type="submit" class="btn btn-success" value="Create">
                                </p>

                            </form>
                            <table class="table">
                                <tr>
                                    <th>Month</th>
                                    <th>Electric Bill</th>
                                    <th>Internet Bill</th>
                                    <th>Action</th>
                                </tr>
                                @if (count($allmonth) > 0)
                                    @foreach ($allmonth as $item)


                                <tr>
                                    <td> <?php echo date('F, Y', strtotime($item->month)); ?> </td>
                                    <td> {{$item->elec_bill}} </td>
                                    <td> {{$item->internet_bill}} </td>
                                    <td>
                                        <a href="{{route('monthly.coststudent',['id'=>$item->id])}}" class="btn btn-info">Manage Cost</a>
                                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#myModal{{$item->id}}">Edit</a>
                                        <a onclick="return confirm('Are You Sure to Delete?');" href="{{route('delete.month',['id'=>$item->id])}}" class="btn btn-danger">Delete</a> </td>
                                    </td>
                                </tr>


                                <!-- Modal -->
                                    <div id="myModal{{$item->id}}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Update Month's Information</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form style="margin-bottom: 20px;padding: 15px;"
                                                        class="form-horizontal form-label-left" novalidate action="{{route('monthly.updatecost',['id' => $item->id])}}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="" style="">Month- <?php echo date('F, Y', strtotime($item->month)); ?></label>
                                                            <input type="month" class="form-control " name="month" class="" placeholder="Select Month" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Electicity Bill</label>
                                                            <input type="number" name="elec_bill" class="form-control" value="{{$item->elec_bill}}" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Internet Bill</label>
                                                            <input type="number" name="internet_bill" class="form-control" value="{{$item->internet_bill}}">
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
