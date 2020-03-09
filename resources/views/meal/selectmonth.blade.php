@extends('layout.app')
@section('section')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Select a month to manage student meal history</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Select Month(Student Meal)</li>
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
              class="alert alert-danger alert-dismissible fade in" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
              {{$error}}
          </div>
          @endforeach
      </div>
      @endif
                <div class="all_action" style="margin-bottom:20px;margin-top:20px;">
                    <form action="{{route('select.month_meal_search')}}" method="post">
                        @csrf
                        <label for="month" style="float: left;display: flex;align-items: center;height: 35px;">Select Month:</label>
                        <input type="month" class="form-control" name="month" style="width: 280px;float: left;margin:0px 10px;">
                        <input class="btn btn-success" type="submit" name="add_meal" value="View Meal">
                    </form>
                </div>
              </div>
            </div>
          </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
      @endsection
