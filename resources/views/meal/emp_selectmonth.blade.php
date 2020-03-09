@extends('layout.app')
@section('section')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Select a month to manage employee meal history</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Select Month(Employee Meal)</li>
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
                  <!-- /.card-header -->
                  <div class="card-body">
                <div class="all_action" style="margin-bottom:20px;margin-top:20px;">
                    <form action="{{route('select.empmonth_meal_search')}}" method="post">
                        @csrf
                        <label for="month" style="float: left;display: flex;align-items: center;height: 35px;">Select
                            Month:</label>
                        <input type="month" class="form-control" name="month"
                            style="width: 280px;float: left;margin:0px 10px;">
                        <input class="btn btn-success" type="submit" name="add_meal" value="View Meal">
                    </form>
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  @endsection
