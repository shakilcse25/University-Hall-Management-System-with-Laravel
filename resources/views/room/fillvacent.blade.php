@extends('layout.app')
@section('section')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Fill and Vacent Tracking History</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Fill and Vacent</li>
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
                    <h3 class="card-title">DataTable with fill and vacent history</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="student" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Student Id</th>
                                <th>Department</th>
                                <th>Room No</th>
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($fillvacent as $item)
                                <tr>
                                    <td>
                                        @if (isset($item->student->name))
                                            {{$item->student->name}}
                                        @else
                                            Deleted!
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($item->student->dept_id))
                                            {{$item->student->dept_id}}
                                        @else
                                            Deleted!
                                        @endif

                                    </td>
                                    <td>
                                        @if (isset($item->student->dept))
                                            {{$item->student->dept}}
                                        @else
                                            Deleted!
                                        @endif
                                    </td>
                                    <td>{{$item->room_id}}</td>
                                    <td>{{$item->status}} <img style="margin-left:20px;" src="
                                        @if($item->status == 'fill' || $item->status == 'Fill')
                                        {{asset('assets/img/in.png')}}
                                        @else
                                        {{asset('assets/img/out.png')}}
                                        @endif
                                        " alt="" height="30px;" width="30px;"></td>
                                    <td>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</td>
                                </tr>
                            @endforeach

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
