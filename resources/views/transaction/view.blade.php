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
                    <li class="breadcrumb-item active">View transaction History</li>
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
                <button type="button" onclick="convertPDF('#transaction');" class="btn btn-info" style="margin:20px 0px;"> Create Report </button>

                <table id="transaction" class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Student id</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Old Amount</th>
                            <th>Updated Amount</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($trans) > 0)
                            @foreach ($trans as $item)
                            <tr>
                                <td>{{$item->student->dept_id}}</td>
                                <td>{{$item->amount}}</td>
                                <td>{{$item->type}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{$item->old_balance}}</td>
                                <td>{{$item->new_balance}}</td>
                                <td>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->
@endsection
