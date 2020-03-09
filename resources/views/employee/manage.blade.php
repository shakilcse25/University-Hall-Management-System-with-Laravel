@extends('layout.app')
@section('section')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Manage Employee</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('view.student')}}">Student</a></li>
            <li class="breadcrumb-item active">Employee Information</li>
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
                    <h3 class="card-title">DataTable with employee's information</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 style="font-size:20px;font-weight:bold;">Add Employee Information:</h2>
                    </div>
                    <div class="add_employee">
                        <button class="btn btn-primary ademp" data-toggle="modal" data-target="#add_employee" style="margin-bottom:15px;">Add Employee</button>
                    </div>




                    <!-- Add Employee Modal -->
                    <div id="add_employee" class="modal fade" role="dialog">
                        <div class="modal-dialog" style="width:800px;">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" style="text-align:center;font-size:20px;">Add New Employee
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    @if (count($errors) > 0 && Session::get('update') != 'yes')

                                    <script>
                                        $(document).ready(function(){
                                            $('#add_employee').modal('show');
                                        });
                                    </script>

                                    <div style="margin-bottom:20px;">
                                        @foreach ($errors->all() as $error)
                                        <div style="margin:0px auto;width:80%;padding:10px 35px 10px 10px;margin-bottom:10px;"
                                            class="alert alert-danger alert-dismissible fade-in" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                    aria-hidden="true">×</span>
                                            </button>
                                            {{$error}}
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif

                                    <form class="form-horizontal form-label-left add_emp_form" action="{{route('add.employee')}}" method="post">
                                        @csrf

                                        <div class="item form-group">
                                            <label class="control-label " for="name">Name <span class="required">*</span>
                                            </label>
                                            <div>
                                                <input id="name" value="{{ old('name') }}" class="form-control" name="name" required="required" type="text">
                                            </div>
                                        </div>



                                        <div class="item form-group">
                                            <label class="control-label" for="dept_id">Position
                                                <span class="required">*</span>
                                            </label>
                                            <div>
                                                <input id="position" value="{{ old('position') }}" class="form-control" name="position"
                                                    required="required" type="text">
                                            </div>
                                        </div>



                                        <div class="item form-group">
                                            <label class="control-label" for="email">Email</label>
                                            <div>
                                                <input type="email" id="email" value="{{ old('email') }}" name="email" class="form-control">
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="control-label" for="phone">Employee
                                                Phone No <span class="required">*</span>
                                            </label>
                                            <div>
                                                <input id="phone" value="{{ old('phone') }}" class="form-control" name="phone" type="number" required>
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="control-label" for="dept_id">Address
                                                <span class="required">*</span>
                                            </label>
                                            <div>
                                                <input id="address" value="{{ old('address') }}" class="form-control" name="address"
                                                    required="required" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="">
                                                <input type="submit" value="Add Employee" class="btn btn-success">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">

                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- End Modal --}}
<script>
$(document).ready(function(){
    $('.add_employee .ademp').click(function(){
        $('.add_emp_form input[type=text],.add_emp_form input[type=email],.add_emp_form input[type=number]').val('');
    });

});
</script>


                    <div class="x_content">
                        <table id="employee" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @if (count($employee) > 0)
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($employee as $data)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->position}}</td>
                                    <td>{{$data->email}}</td>
                                    <td>{{$data->phone}}</td>
                                    <td>{{$data->address}}</td>

                                    <td>
                                    <a href="" class="btn btn-primary" data-toggle="modal" data-target="#update_employee{{$data->id}}">Update</a>
                                    <button class="btn btn-danger" onclick="deleteData({{ $data->id }})" type="submit">Delete</button>
                                    </td>
                                </tr>


                                <!-- Update Employee Modal -->
                                <div id="update_employee{{$data->id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog" style="width:800px;">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" style="text-align:center;font-size:20px;">Update Employee's Information
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                @if (count($errors) > 0 && Session::get('id') == $data->id)
                                                <script>
                                                    $(document).ready(function(){
                                                        $('#update_employee' + {{Session::get('id')}}).modal('show');
                                                    });
                                                </script>

                                                <div style="margin-bottom:20px;">
                                                    @foreach ($errors->all() as $error)
                                                    <div style="margin:0px auto;width:80%;padding:10px 35px 10px 10px;margin-bottom:10px;"
                                                        class="alert alert-danger alert-dismissible fade-in" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                                aria-hidden="true">×</span>
                                                        </button>
                                                        {{$error}}
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif

                                                <form class="form-horizontal form-label-left" novalidate action="{{route('update.emp_infor',['id'=>$data->id])}}" method="post" enctype="multipart/form-data">
                                                    @csrf


                                                    <div class="item form-group">
                                                        <label class="control-label" for="name">Name <span class="required">*</span>
                                                        </label>
                                                        <div>
                                                            <input id="name" value="{{$data->name}}" class="form-control" name="name" required="required" type="text">
                                                        </div>
                                                    </div>



                                                    <div class="item form-group">
                                                        <label class="control-label" for="position">Position
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div>
                                                            <input id="position" value="{{$data->position}}" class="form-control" name="position" required="required" type="text">
                                                        </div>
                                                    </div>



                                                    <div class="item form-group">
                                                        <label class="control-label" for="email">Email <span
                                                                class="required">*</span>
                                                        </label>
                                                        <div>
                                                            <input type="email" id="email" value="{{$data->email}}" name="email" required="required" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label" for="phone">Employee
                                                            Phone No <span class="required">*</span>
                                                        </label>
                                                        <div>
                                                            <input id="phone" value="{{$data->phone}}" class="form-control" name="phone" pattern="[0-9-]" type="text" required>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label class="control-label" for="address">Address
                                                            <span class="required">*</span>
                                                        </label>
                                                        <div>
                                                            <input id="address" value="{{$data->address}}" class="form-control" name="address" required="required"
                                                                type="text">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="">
                                                            <button id="send" type="submit" class="btn btn-success">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {{-- End Modal --}}




                                @endforeach
                                @else
                                <p>No Student Record is available!</p>
                                @endif

                            </tbody>
                        </table>


<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function deleteData(id){
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url : "{{ url('/del_emp')}}" + '/' + id,
                    type : "GET",
                    success: function(){
                        location.reload();
                        swal("Employee's information has been deleted!", {
                        icon: "success",
                        });

                    },
                    error : function(){
                        swal({
                            title: 'Opps...',
                            text : 'something going wrong!',
                            icon : 'error',
                            timer : '1500'
                        })
                    }
                })
            } else {
            swal("Employee's record is safe!");
            }
        });
    }

</script>



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
