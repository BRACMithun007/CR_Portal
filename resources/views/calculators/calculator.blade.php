
@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Calculators</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Calculators</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <a href="{{url('calculators/loan-repayment-schedule')}}" class="small-box-footer">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>Loan</h3>
                                    <p>Repayment Schedule</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <a href="{{url('calculators/loan-premium')}}" class="small-box-footer">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>Loan</h3>
                                    <p>Premium Calculation</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection


@section('scripts')
    @include('layouts.admin_common_js')
@endsection
