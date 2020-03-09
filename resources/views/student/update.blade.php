@extends('layout.app')
@section('section')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update Student Information</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('view.student')}}">Student</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid padbtm">

        <div class="card" style="margin-bottom:20px;">
            <div class="card-body">
                <div class="x_panel">
                    <div class="x_content">
                        @if (count($errors) > 0)
                        <div style="margin-bottom:20px;">
                            @foreach ($errors->all() as $error)
                            <div style="margin:0px auto;width:700px;padding:10px 35px 10px 10px;margin-bottom:10px;" class="alert alert-danger alert-dismissible  fade-in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">×</span>
                                </button>
                                {{$error}}
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <form class="form-horizontal form-label-left" novalidate action="{{route('update.student',['id' => $id])}}"
                            method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="inner_form" style="display: grid;grid-template-columns: auto auto;grid-column-gap: 35px;">

                                <div class="item form-group" style="grid-column: 1/ span 2;margin:0px auto;width:50%;">
                                    <div class="profile_img" style="width:140px;height:140px;margin:0px auto;">
                                        <img src="{{asset($student->profile_img)}}" alt="" style="border-radius:50% 50%;border:1px solid gainsboro;height:100%;width:100%;padding:10px;">
                                    </div>
                                    <label class="control-label" for="profile_img">Update
                                        Student Image <span class="required">*</span>
                                    </label>
                                    <div>
                                        <input id="profile_img" value="{{ $student->profile_img }}"
                                            class="" name="profile_img" type="file" style="border: 1px solid #80808047;width: 100%;background-color: aliceblue;border-radius: 3px;
                                            margin-bottom: 15px;">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label" for="name">Name <span
                                            class="required">*</span>
                                    </label>
                                    <div class="">
                                        <input id="name" value="{{ $student->name }}" class="form-control"
                                            name="name" required="required" type="text">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label" for="dept">Department<span
                                            class="required">*</span></label>
                                    <div class="">
                                        <select class="form-control" value="{{ old('dept') }}" name="dept"
                                            required="required">
                                            <option value="" disabled>Choose option</option>
                                            <option <?php if($student->dept == 'CSE'){echo 'selected';} ?> value="CSE">CSE</option>
                                            <option <?php if($student->dept == 'EEE'){echo 'selected';} ?> value="EEE">EEE</option>
                                            <option <?php if($student->dept == 'CE'){echo 'selected';} ?> value="CE">CE</option>
                                            <option <?php if($student->dept == 'ICE'){echo 'selected';} ?> value="ICE">ICE</option>
                                            <option <?php if($student->dept == 'BBA'){echo 'selected';} ?> value="BBA">BBA</option>
                                            <option <?php if($student->dept == 'ENGLISH'){echo 'selected';} ?> value="ENGLISH">ENGLISH</option>
                                            <option <?php if($student->dept == 'LAW'){echo 'selected';} ?> value="LAW">LAW</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label" for="dept_id">Department ID
                                        <span class="required">*</span>
                                    </label>
                                    <div class="">
                                        <input id="dept_id" value="{{ $student->dept_id }}"
                                            class="form-control" name="dept_id" required="required"
                                            type="number">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label" for="batch">Batch<span
                                            class="required">*</span></label>
                                    <div class="">
                                        <select class="form-control" value="{{ old('batch') }}" name="batch" required>
                                            <option value="" disabled>Choose option</option>
                                            <option value="1st" {{ ( $student['batch'] == '1st' ) ? ' selected' : '' }} >1st</option>
                                            <option value="2nd" {{ ( $student['batch'] == '2nd' ) ? ' selected' : '' }} >2nd</option>
                                            <option value="3rd" {{ ( $student['batch'] == '3rd' ) ? ' selected' : '' }} >3rd</option>
                                            <option value="4th" {{ ( $student['batch'] == '4th' ) ? ' selected' : '' }} >4th</option>
                                            <option value="5th" {{ ( $student['batch'] == '5th' ) ? ' selected' : '' }} >5th</option>
                                            <option value="6th" {{ ( $student['batch'] == '6th' ) ? ' selected' : '' }} >6th</option>
                                            <option value="7th" {{ ( $student['batch'] == '7th' ) ? ' selected' : '' }} >7th</option>
                                            <option value="8th" {{ ( $student['batch'] == '8th' ) ? ' selected' : '' }} >8th</option>
                                            <option value="9th" {{ ( $student['batch'] == '9th' ) ? ' selected' : '' }} >9th</option>
                                            <option value="10th" {{ ( $student['batch'] == '10th' ) ? ' selected' : '' }} >10th</option>
                                            <option value="11th" {{ ( $student['batch'] == '11th' ) ? ' selected' : '' }} >11th</option>
                                            <option value="12th" {{ ( $student['batch'] == '12th' ) ? ' selected' : '' }} >12th</option>
                                            <option value="13th" {{ ( $student['batch'] == '13th' ) ? ' selected' : '' }} >13th</option>
                                            <option value="14th" {{ ( $student['batch'] == '14th' ) ? ' selected' : '' }} >14th</option>
                                            <option value="15th" {{ ( $student['batch'] == '15th' ) ? ' selected' : '' }} >15th</option>
                                            <option value="16th" {{ ( $student['batch'] == '16th' ) ? ' selected' : '' }} >16th</option>
                                            <option value="17th" {{ ( $student['batch'] == '17th' ) ? ' selected' : '' }} >17th</option>
                                            <option value="18th" {{ ( $student['batch'] == '18th' ) ? ' selected' : '' }} >18th</option>
                                            <option value="19th" {{ ( $student['batch'] == '19th' ) ? ' selected' : '' }} >19th</option>
                                            <option value="20th" {{ ( $student['batch'] == '20th' ) ? ' selected' : '' }} >20th</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label">Session<span
                                            class="required">*</span></label>
                                    <div class="">
                                        <input type="text" value="{{ $student->session }}" name="session" class="form-control" data-inputmask='"mask": "99-9999"' data-mask required="required">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label" for="dept">Blood Group<span
                                            class="required">*</span></label>
                                    <div class="">
                                        <select class="form-control" value="{{ $student->blood_group }}" name="blood_group"
                                            required="required">
                                            <option value="" disabled {{ ( $student['blood_group'] == '' ) ? ' selected' : '' }}>Choose option</option>
                                            <option value="A+" {{ ( $student['blood_group'] == 'A+' ) ? ' selected' : '' }}>A+</option>
                                            <option value="B+" {{ ( $student['blood_group'] == 'B+' ) ? ' selected' : '' }}>B+</option>
                                            <option value="O+" {{ ( $student['blood_group'] == 'O+' ) ? ' selected' : '' }}>O+</option>
                                            <option value="A-" {{ ( $student['blood_group'] == 'A-' ) ? ' selected' : '' }}>A-</option>
                                            <option value="B-" {{ ( $student['blood_group'] == 'B-' ) ? ' selected' : '' }}>B-</option>
                                            <option value="O-" {{ ( $student['blood_group'] == 'O-' ) ? ' selected' : '' }}>O-</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="item form-group">
                                    <label class="control-label" for="father_name">Father Name
                                        <span class="required">*</span>
                                    </label>
                                    <div class="">
                                        <input id="father_name" value="{{ $student->father_name }}"
                                            class="form-control" name="father_name" required="required"
                                            type="text">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label" for="father_phone">Father Phone
                                        No </label>
                                    <div class="">
                                        <input id="father_phone" value="{{ $student->father_phone }}"
                                            class="form-control" name="father_phone" type="number">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label" for="mother_name">Mother Name
                                        <span class="required">*</span>
                                    </label>
                                    <div class="">
                                        <input id="mother_name" value="{{ $student->mother_name }}"
                                            class="form-control" name="mother_name" required="required"
                                            type="text">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label" for="mother_phone">Mother Phone
                                        No</label>
                                    <div class="">
                                        <input id="mother_phone" value="{{ $student->mother_phone }}"
                                            class="form-control" name="mother_phone" type="number">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label" for="parent_phone">Parent Phone
                                        No <span class="required">*</span>
                                    </label>
                                    <div class="">
                                        <input id="parent_phone" value="{{ $student->parent_phone }}"
                                            class="form-control" name="parent_phone" pattern="[0-9-]"
                                            type="text" required="required">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label" for="email">Email <span
                                            class="required">*</span>
                                    </label>
                                    <div class="">
                                        <input type="email" id="email" value="{{ $student->email }}" name="email"
                                            required="required" class="form-control">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label" for="student_phone">Student
                                        Phone No <span class="required">*</span>
                                    </label>
                                    <div class="">
                                        <input id="student_phone" value="{{ $student->student_phone }}"
                                            class="form-control" name="student_phone" pattern="[0-9-]"
                                            type="text" required>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label" for="init_deposit">Account Balance<span class="required">*</span>
                                    </label>
                                    <div class="">
                                        <input id="init_deposit" value="{{ $student->init_deposit }}"
                                            class="form-control" name="init_deposit" type="number" required>
                                    </div>
                                </div>

                            </div>


                            <div class="form-group">
                                <div class="" style="text-align: right;margin-top: 18px;">
                                    <button id="send" type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!--/. container-fluid -->
</section>
<!-- /.content -->
@endsection
