@extends('layout.app')
@section('section')
<style>
.modal h3,.modal h4{
    font-size: 110% !important;
}
</style>
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
          <h1 class="m-0 text-dark">Manage And Update Student Information</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('view.student')}}">Student</a></li>
            <li class="breadcrumb-item active">Student Information</li>
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

      <div class="search_area">
                        <form id="fromen2" action="{{route('search.student')}}" method="post" style="display:flex;align-item:center;padding:8px 0px;border-bottom:2px solid #80808042;margin-bottom:10px;" enctype="multipart/form-data">
                            <div class="inner" style="margin:0px auto;display:flex;align-items:center;">
                            @csrf

                                <input style="width:30px;height:20px;" onclick="this.form.submit();" type="checkbox" @if(Route::currentRouteName() == 'view.student')
                                    checked
                                @endif class="" name="status_res" id="" value="1" @php
                                    if(in_array("res",$search)) echo 'checked';
                                @endphp > <span style="margin-right:40px;margin-left:4px;">Residential</span>

                                <input style="width:30px;height:20px;" onclick="this.form.submit();" @php
                                    if(in_array("nonres",$search)) echo 'checked';
                                @endphp type="checkbox" class="" name="status_nonres" value="2"><span style="margin-right:40px;margin-left:4px;">Non-Residential</span>

                                <select onchange="this.form.submit();" name="batch[]" style="width: 270px !important;margin-right: 40px;display:inline-block;" class="select2_multiple form-control" multiple="multiple">
                                    <option disabled value="" >Select Batch</option>
                                    <option <?php if(in_array('allbatch',$search)) echo 'selected'; ?> value="allbatch">All</option>
                                    
                                    @if (count($batch) > 0)
                                    @foreach ($batch as $item)
                                      <option <?php if(in_array($item->name,$search)) echo 'selected'; ?> value="{{$item->name}}" >{{$item->name}}</option>
                                    @endforeach
                                    @endif
                                </select>

                                <select onchange="this.form.submit();" name="dept[]" style="width: 270px !important;margin-right: 40px;display:inline-block;" class="select2_multiple form-control" multiple="multiple">
                                    <option disabled value="">Select Department</option>
                                    <option <?php if(in_array('alldept',$search)) echo 'selected'; ?> value="alldept">ALL</option>

                                    @if (count($department) > 0)
                                    @foreach ($department as $item)
                                      <option <?php if(in_array($item->name,$search)) echo 'selected'; ?> value="{{$item->name}}" >{{$item->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                        </form>
                    </div>




      <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">DataTable with Student Information</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="student" class="table table-bordered table-striped">
                <thead>
                      <tr>
                          <th>Name</th>
                          <th>Department ID</th>
                          <th>Room No</th>
                          <th>batch</th>
                          <th>Department</th>
                          <th>Phone</th>
                          <th>Balance</th>
                          <th>Blood Group</th>
                          <th>Action</th>
                      </tr>
                  </thead>


                  <tbody>
  @if (count($student) > 0)
      @foreach ($student as $data)
                      <tr>
                          <td>{{$data->name}}</td>
                          <td>{{$data->dept_id}}</td>
                          <td>{{$data->room['room_no']}}</td>
                          <td>{{$data->batch}}</td>
                          <td>{{$data->dept}}</td>
                          <td>{{$data->student_phone}}</td>
                          <td>{{$data->init_deposit}}</td>
                          <td>{{$data->blood_group}}</td>
                          <td>
                          <a href="" class="btn btn-info" data-toggle="modal" data-target="#myModal{{$data->id}}">Details</a>
                           <a href="{{route('edit.student', ['id' => $data->id])}}" class="btn btn-primary">Update</a>

                      </tr>

          <!-- Modal -->
          <div id="myModal{{$data->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content"  style="width:800px !important;">
                      <div class="modal-header">
                          <h4 class="modal-title" style="text-align:center;font-size:20px;">More About {{$data->name}}</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="profile_img" style="margin-bottom:20px;">
                              <div class="img_inner" style="width:200px;height:200px;margin:0px auto;">
                                  <img src="{{asset($data->profile_img)}}" alt="" style="border-radius:50% 50%;border:1px solid gainsboro;height:100%;width:100%;padding:10px;">
                              </div>
                          </div>
                          <div class="basic">
                              <h3 style="text-align:center;font-weight:bold;">{{$data->name}}</h3>
                              <h4 style="text-align:center;">
                                  <span style="margin-right:10px;"><i style="font-weight:bold;">ID: </i>{{$data->dept_id}}</span>
                                  <span style="margin-right:10px;"><i style="font-weight:bold;">DEPT: </i>{{$data->dept}}</span>
                                  <span style="margin-right:10px;"><i style="font-weight:bold;">Batch: </i>{{$data->batch}}</span>
                                  <span style="margin-right:10px;"><i style="font-weight:bold;">Blood Group: </i>{{$data->blood_group}}</span>
                              </h4>
                              <h4 style="text-align:center;"> <span style="font-weight:bold;">Phone: </span>{{$data->student_phone}} </h4>
                              <h4 style="text-align:center;"> <span style="font-weight:bold;">Gmail: </span>{{$data->email}}</h4>
                              <h4 style="text-align:center;"> <span style="font-weight:bold;">Balance: </span>{{$data->init_deposit}}</h4>
                          </div>
                          <hr>
                          <div class="all">
                              <h4 style="display: grid;padding: 10px 30px;grid-template-columns: auto auto;row-gap: 20px;column-gap: 20px;">
                                 <span style="margin-right:10px;"><i style="font-weight:bold;">Room No: </i>{{$data->room['room_no']}}</span>
                                 <span style="margin-right:10px;"><i style="font-weight:bold;">Session: </i>{{$data->session}}</span>
                                 <span style="margin-right:10px;"><i style="font-weight:bold;">Father Name: </i>{{$data->father_name}}</span>
                                 <span style="margin-right:10px;"><i style="font-weight:bold;">Father Phone: </i>{{$data->father_phone}}</span>
                                 <span style="margin-right:10px;"><i style="font-weight:bold;">Mother Name: </i>{{$data->mother_name}}</span>
                                 <span style="margin-right:10px;"><i style="font-weight:bold;">Mother Phone: </i>{{$data->mother_phone}}</span>
                              </h4>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <h4 style="text-align:center;width:100%;"> <span style="font-weight:bold;">Registered Time: </span>{{\Carbon\Carbon::parse($data->created_at)->format('d/m/Y')}}</h4>
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
                <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Department ID</th>
                  <th>Room No</th>
                  <th>batch</th>
                  <th>Department</th>
                  <th>Phone</th>
                  <th>Balance</th>
                  <th>Blood Group</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
@endsection
