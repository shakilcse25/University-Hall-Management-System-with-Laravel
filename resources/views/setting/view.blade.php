@extends('layout.app')
@section('section')
<style>
    .modal h3,
    .modal h4 {
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
                <h1 class="m-0 text-dark">Manage Rooms</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">All Room</li>
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
                <h3 class="card-title">Manage Department</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="department">
                    <div class="form_dept">
                        <form action="{{ route('store.dept') }}" method="POST">
                            @csrf
                            <div class="form-group" style="display: inline-block;margin-right: 10px;">
                                <input type="text" name="name" id="name" class="form-control small" style="width:200px !important" required>
                            </div>
                            <input type="submit" value="Add Department" class="btn btn-success" style="vertical-align: baseline;">
                        </form>
                    </div>
                    <div class="dept_list">
                        <div class="d-flex flex-wrap bg-light">
                            @if (count($department) > 0)
                            @foreach ($department as $item)

                            <div class="p-2 border">{{$item->name}} <a style="margin-left:20px;" href="{{route('delete.dept',['id'=>$item->id])}}" onclick="return confirm('Are you sure to delete these department name?')"> <i class="fas fa-trash-alt"></i> </a> </div>

                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->



        <!-- /.card Batch -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manage All Batches</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="batch">
                    <div class="form_dept">
                        <form action="{{ route('store.batch') }}" method="POST">
                            @csrf
                            <div class="form-group" style="display: inline-block;margin-right: 10px;">
                                <input type="text" name="name" id="name" class="form-control small"
                                    style="width:200px !important" required>
                            </div>
                            <input type="submit" value="Add Batch" class="btn btn-success"
                                style="vertical-align: baseline;">
                        </form>
                    </div>
                    <div class="dept_list">
                        <div class="d-flex flex-wrap bg-light">
                            @if (count($batch) > 0)
                            @foreach ($batch as $item)

                            <div class="p-2 border">{{$item->name}} <a style="margin-left:20px;" href="{{route('delete.batch',['id'=>$item->id])}}"  onclick="return confirm('Are you sure to delete these batch?')"> <i class="fas fa-trash-alt"></i> </a> </div>

                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->
@endsection
