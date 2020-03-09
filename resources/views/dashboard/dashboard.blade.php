@extends('layout.app')
@section('section')

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
<style>
.info-box-content p{
    margin: 0px;
    font-size: 12px;
    font-style: italic;
    color: brown;
}
</style>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-graduate"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Student(Present)</span>
              <span class="info-box-number">
                {{$present_student}}
              </span>
              <p>Active Student</p>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-calendar-day"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Meal Day(s)</span>
              <span class="info-box-number">{{$meal_day}}</span>
              <p>Current Month</p>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-wave"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Meal Cost</span>
              <span class="info-box-number">{{$total_meal_cost}}</span>
              <p>Current Month</p>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        {{-- <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-wave"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Student Total Cost</span>
              <span class="info-box-number">{{$total_cost}}</span>
              <p>Current Month</p>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div> --}}
        <!-- /.col -->

        <!-- /.col -->
        {{-- <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon elevation-1" style="background-color:lightseagreen;color:#fff;"><i class="fas fa-hand-holding-usd"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Deposit Collection</span>
                    <span class="info-box-number">{{$total_deposit}}</span>
                    <p>Current Month</p>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div> --}}
        <!-- /.col -->

        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon elevation-1" style="background-color:cornflowerblue;color:#fff;"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">New Registered Student</span>
                    <span class="info-box-number">{{$new_reg}}</span>
                    <p>Last Two Month</p>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon elevation-1" style="background-color:darkgoldenrod;color:#fff;"><i class="fas fa-user-minus"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Recently Student Vacent</span>
                    <span class="info-box-number">{{$vacent_num}}</span>
                    <p>Last Two Month</p>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="biginfor" style="margin-top:40px;">
        <div class="row">
            <div class="col-sm-4">
                <div class="info-box mb-3" style="padding: 15px 15px;font-size: 150%;">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-wave"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Cost</span>
                        <span class="info-box-number">{{$total_cost}}</span>
                        <p>Current Month</p>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>

            <div class="col-sm-4">
                <div class="info-box mb-3" style="padding: 15px 15px;font-size: 150%;">
                    <span class="info-box-icon elevation-1" style="background-color:lightseagreen;color:#fff;"><i
                            class="fas fa-hand-holding-usd"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Collection</span>
                        <span class="info-box-number">{{$total_deposit}}</span>
                        <p>Current Month</p>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
        </div>
    </div>

    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->

@endsection
