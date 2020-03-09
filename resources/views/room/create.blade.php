@extends('layout.app')
@section('section')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Create New Room</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Create Room</li>
          </ol>
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
    <div style="margin:0px auto;width:700px;padding:10px 35px 10px 10px;margin-bottom:10px;"
        class="alert alert-danger alert-dismissible fade-in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        {{$error}}
    </div>
    @endforeach
</div>
@endif

                        <form class="form-horizontal form-label-left" novalidate action="{{route('store.room')}}"
                            method="post" enctype="multipart/form-data" style="margin: 0px auto;width: 70%;">
                            @csrf


                            <div class="item form-group">
                                <label class="control-label" for="room_no">Room No<span class="required">*</span></label>
                                <div class="">
                                    <input id="room_no" class="form-control " name="room_no"
                                        type="number" required="required">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label" for="total_seat">Total Sit<span
                                        required="required">*</span></label>
                                <div class="">
                                    <input id="total_seat" class="form-control" name="total_seat" type="number" required="required">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label " for="room_charges">Room Charge(Per Sit)<span
                                        required="required">*</span></label>
                                <div class="">
                                    <input id="room_charges" class="form-control" name="room_charges" type="number" required="required">
                                </div>
                            </div>

                            {{--  <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mother_name">Mother Name<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="mother_name" class="form-control col-md-7 col-xs-12" name="mother_name"
                                        required="required" type="text">
                                </div>
                            </div>  --}}


                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="" style="text-align:right;">
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
