<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BRAC</title>

    @section('styles')
    @show

    <style>
        .nav-link.active {
            background-color: #17a2b8;
            color: #fff;
        }
        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: #009A93 !important;
        }
        .icheck-success>input:first-child:checked+input[type=hidden]+label::before, .icheck-success>input:first-child:checked+label::before {
            background-color: #009A93 !important;
        }
        .card-primary.card-outline {
            border-top: 3px solid #009A93 !important;
        }
        .card-info:not(.card-outline)>.card-header {
            background-color: #009A93 !important;
            color: white;
        }
        .nav-treeview>.nav-item>.nav-link.active, [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:focus, [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:hover {
            background-color: #009A93 !important;
            color: white !important;
        }
        .bg-info {
            background-color: #009A93 !important;
        }
        .main-sidebar {
            background-color: #476072 !important
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div> -->

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
{{--            <li class="nav-item d-none d-sm-inline-block">--}}
{{--                <a href="index3.html" class="nav-link">Home</a>--}}
{{--            </li>--}}
{{--            <li class="nav-item d-none d-sm-inline-block">--}}
{{--                <a href="#" class="nav-link">Contact</a>--}}
{{--            </li>--}}
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <div class="">
                <img src="{{url('/admin_src/img/brac_50.png')}}" style="height: 40px;" class="img" alt="User Image">
            </div>
            <!-- Navbar Search -->
            <li class="nav-item">
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Messages Dropdown Menu -->

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">{{auth()->user()->name}}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item dropdown-footer" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{url('/')}}" class="brand-link" style="background-color: #334257">
            <span class="brand-text font-weight-light">
                <img src="{{url('/admin_src/img/brac_logo.png')}}" style="height: 40px;" class="img" alt="User Image">
                <b></b>
            </span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
        {{--            <div class="user-panel mt-3 pb-3 mb-3 d-flex">--}}
        {{--                <div class="image">--}}
        {{--                    <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">--}}
        {{--                </div>--}}
        {{--                <div class="info">--}}
        {{--                    <a href="#" class="d-block">Alexander Pierce</a>--}}
        {{--                </div>--}}
        {{--            </div>--}}

        <!-- SidebarSearch Form -->
        {{--            <div class="form-inline">--}}
        {{--                <div class="input-group" data-widget="sidebar-search">--}}
        {{--                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">--}}
        {{--                    <div class="input-group-append">--}}
        {{--                        <button class="btn btn-sidebar">--}}
        {{--                            <i class="fas fa-search fa-fw"></i>--}}
        {{--                        </button>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}

        <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{url('/home')}}" class="nav-link {{ (Request::is('home') ? 'active' : '') }} {{ (Request::is('/') ? 'active' : '') }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    @if(App\Libraries\aclHandler::hasModuleAccess(['mf_cr_read','mf_cr_write']) == true)
                    <li class="nav-item">
                        <a href="{{url('item/mf-item-list')}}" class="nav-link {{ (Request::is('item/mf-item-list') ? 'active' : '') }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Items (MF)</p>
                        </a>
                    </li>
                    @endif
                    @if(App\Libraries\aclHandler::hasModuleAccess(['calculators']) == true)
                        <li class="nav-item {{ (Request::is('calculators/*') ? 'menu-is-opening menu-open' : '') }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Calculator
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('calculators/loan-repayment-schedule')}}" class="nav-link {{ (Request::is('calculators/loan-repayment-schedule') ? 'active' : '') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Loan Repay Schedule</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('calculators/loan-premium')}}" class="nav-link {{ (Request::is('calculators/loan-premium') ? 'active' : '') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Loan Premium</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(App\Libraries\aclHandler::hasModuleAccess(['circular_read','circular_write']) == true)
                        <li class="nav-item">
                            <a href="{{url('circular/mf-circular-list')}}" class="nav-link {{ (Request::is('circular/mf-circular-list') ? 'active' : '') }}">
                                <i class="nav-icon fas fa-table"></i>
                                <p>Circular</p>
                            </a>
                        </li>
                    @endif
                    @if(App\Libraries\aclHandler::hasModuleAccess(['req_cr_read','req_cr_write']) == true)
                    <li class="nav-item">
                        <a href="{{url('request/mf-request-cr')}}" class="nav-link {{ (Request::is('request/mf-request-cr') ? 'active' : '') }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Request CR</p>
                        </a>
                    </li>
                        <li class="nav-item {{ (Request::is('request/*') ? 'menu-is-opening menu-open' : '') }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Requests (BR)
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('request/business-requirement/loan')}}" class="nav-link {{ (Request::is('request/business-requirement/loan') ? 'active' : '') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Loan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('request/business-requirement/special-savings')}}" class="nav-link {{ (Request::is('request/business-requirement/special-savings') ? 'active' : '') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Special Savings</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('request/business-requirement/general-savings')}}" class="nav-link {{ (Request::is('request/business-requirement/general-savings') ? 'active' : '') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>General Savings</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('request/business-requirement/insurance')}}" class="nav-link {{ (Request::is('request/business-requirement/insurance') ? 'active' : '') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Insurance</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('request/business-requirement/report')}}" class="nav-link {{ (Request::is('request/business-requirement/report') ? 'active' : '') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Report</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('request/business-requirement/integration')}}" class="nav-link {{ (Request::is('request/business-requirement/integration') ? 'active' : '') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Integration</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('request/business-requirement/others')}}" class="nav-link {{ (Request::is('request/business-requirement/others') ? 'active' : '') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Others (BR)</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if(App\Libraries\aclHandler::hasModuleAccess(['user_read','user_write']) == true)
                        <li class="nav-item">
                            <a href="{{url('admin/user-list')}}" class="nav-link {{ (Request::is('admin/user-list') ? 'active' : '') }}">
                                <i class="nav-icon far fa-user text-info"></i>
                                <p>USER</p>
                            </a>
                        </li>
                    @endif

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    @section('content')
    @show
    <!-- Content Wrapper. Contains page content -->

    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 1972-{{date('Y')}} <a href="#" style="color: #EC008C">BRAC</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">

        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@section('scripts')
@show

</body>
</html>
