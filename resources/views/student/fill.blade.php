@extends('layout.app')
@section('section')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Add New Student</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('view.room')}}">All Room</a></li>
            <li class="breadcrumb-item active">Add New Student</li>
          </ol>
          <div class="add_exist" style="overflow: hidden;width: 100%;text-align: right;margin-top: 40px;margin-right:10px;">
            <a href="{{route('fillpage.student',['room_id'=>$roomid])}}" class="btn btn-success">Add Existing Student</a>
          </div>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

<div class="card">
  <div class="card-body">


@if (count($errors) > 0)
<div style="margin-bottom:20px;">
    @foreach ($errors->all() as $error)
        <div style="margin:0px auto;width:700px;padding:10px 35px 10px 10px;margin-bottom:10px;" class="alert alert-danger alert-dismissible fade-in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            {{$error}}
        </div>
    @endforeach
</div>
@endif

                            <form class="form-horizontal form-label-left" novalidate action="{{route('store.student')}}" method="post" enctype="multipart/form-data">
                                <div class="inner_form" style="display: grid;grid-template-columns: auto auto;grid-column-gap: 35px;">
                                    @csrf
                                    @if (isset($roomid))
                                        <input type="hidden" name="roomid" value="{{$roomid}}">
                                    @endif

                                    <div class="item form-group">
                                        <label class="control-label" for="profile_img">Upload Student Image <span class="required">*</span>
                                        </label>
                                        <div >
                                        <input id="profile_img" name="profile_img" type="file" style="border: 1px solid #80808047;width: 100%;background-color: aliceblue;border-radius: 3px;margin-bottom: 15px;">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label" for="name">Name <span
                                                class="required">*</span>
                                        </label>
                                        <div>
                                            <input id="name" value="{{ old('name') }}" class="form-control" name="name" type="text" required>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label" for="dept">Department<span class="required">*</span></label>
                                        <div>
                                            <select class="form-control" value="{{ old('dept') }}" name="dept" required="required">
                                                <option value="" disabled selected>Choose option</option>
                                                @if (count($department) > 0)
                                                @foreach ($department as $item)
                                                  <option value="{{$item->name}}">{{$item->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label" for="dept_id">Department ID <span class="required">*</span>
                                        </label>
                                        <div>
                                            <input id="dept_id" value="{{ old('dept_id') }}" class="form-control" name="dept_id" required="required" type="number">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label" for="batch">Batch<span class="required">*</span></label>
                                        <div>
                                            <select class="form-control" value="{{ old('batch') }}" name="batch" required>
                                                <option value="" disabled selected>Choose option</option>
                                                @if (count($batch) > 0)
                                                @foreach ($batch as $item)
                                                  <option value="{{$item->name}}">{{$item->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label">Session<span class="required">*</span></label>
                                        <div>
                                            <input type="text" value="{{ old('session') }}" name="session" class="form-control" data-inputmask='"mask": "99-9999"' data-mask required="required">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label" for="dept">Blood Group<span class="required">*</span></label>
                                        <div >
                                            <select class="form-control" value="{{ old('blood_group') }}" name="blood_group" required="required">
                                                <option value="" disabled selected>Choose option</option>
                                                <option value="A+">A+</option>
                                                <option value="B+">A-</option>
                                                <option value="O+">O+</option>
                                                <option value="A-">A+</option>
                                                <option value="B-">A-</option>
                                                <option value="O-">O-</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="item form-group">
                                        <label class="control-label" for="father_name">Father Name <span class="required">*</span>
                                        </label>
                                        <div>
                                            <input id="father_name" value="{{ old('father_name') }}" class="form-control" name="father_name"
                                                required="required" type="text">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label" for="father_phone">Father Phone No </label>
                                        <div>
                                            <input id="father_phone" value="{{ old('father_phone') }}" class="form-control" name="father_phone" type="number">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label" for="mother_name">Mother Name <span
                                                class="required">*</span>
                                        </label>
                                        <div>
                                            <input id="mother_name" value="{{ old('mother_name') }}" class="form-control " name="mother_name" required="required"
                                                type="text">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label" for="mother_phone">Mother Phone No</label>
                                        <div>
                                            <input id="mother_phone" value="{{ old('mother_phone') }}" class="form-control" name="mother_phone" type="number">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label" for="parent_phone">Parent Phone No <span
                                                class="required">*</span>
                                        </label>
                                        <div>
                                            <input id="parent_phone" value="{{ old('parent_phone') }}" class="form-control" name="parent_phone" pattern="[0-9-]" type="text" required="required">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label " for="email">Email <span
                                                class="required">*</span>
                                        </label>
                                        <div>
                                            <input type="email" id="email" value="{{ old('email') }}" name="email" required="required"
                                                class="form-control ">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label" for="student_phone">Student Phone No <span
                                                class="required">*</span>
                                        </label>
                                        <div>
                                            <input id="student_phone" value="{{ old('student_phone') }}" class="form-control" name="student_phone" pattern="[0-9-]" type="text" required>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label" for="init_deposit">Account Balance <span
                                                class="required">*</span>
                                        </label>
                                        <div>
                                            <input id="init_deposit" value="{{ old('init_deposit') }}" class="form-control" name="init_deposit" type="number" required>
                                        </div>
                                    </div>


                                </div>
                                <div class="form-group">
                                    <div class="">
                                        <button id="send" type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                          </div>
                        </div>
                      </div><!--/. container-fluid -->
                    </section>
                    <!-- /.content -->
                  @endsection
