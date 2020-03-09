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
          <h1 class="m-0 text-dark">Pick existed student to fill this room.</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('view.room')}}">All Room</a></li>
            <li class="breadcrumb-item"><a href="{{url()->previous()}}">Add Student</a></li>
            <li class="breadcrumb-item active">Add Existed Student</li>
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
                    <h3 class="card-title">DataTable with students who aren't allocated any room yet!</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="student" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Department ID</th>
                                <th>batch</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @if (count($student) > 0)
                            @foreach ($student as $data)
                            <tr>
                                <td>{{$data->name}}</td>
                                <td>{{$data->dept}}</td>
                                <td>{{$data->dept_id}}</td>
                                <td>{{$data->batch}}</td>
                                <td>

                                    @if ($data->status == '1')
                                        Resident
                                    @else
                                        Non-Resident
                                    @endif


                                </td>
                                <td>
                                    <a href="{{route('fill.student',['id' => $data->id, 'room_id'=> $room_id])}}"
                                            class="btn btn-info">Fill</a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <p>No Student Record is available!</p>
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
