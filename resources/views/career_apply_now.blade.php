
@extends('layouts.website_layout')

@section('styles')
    @include('layouts.website_common_css')
    <style>
        .login_btn {
            color: #fff;
            width: 100%;
            height: 50px;
            border: 0;
            padding: 6px 25px;
            line-height: 36px;
            margin-bottom: 20px;
            text-align: center;
            border-radius: 50px;
            text-transform: capitalize;
            letter-spacing: 1px;
            background: rgba(116,66,93,1);
            background: -moz-linear-gradient(left, rgba(116,66,93,1) 0%, rgba(62,46,46,1) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(116,66,93,1)), color-stop(100%, rgba(62,46,46,1)));
            background: -webkit-linear-gradient(left, rgba(116,66,93,1) 0%, rgba(62,46,46,1) 100%);
            background: -o-linear-gradient(left, rgba(116,66,93,1) 0%, rgba(62,46,46,1) 100%);
            background: -ms-linear-gradient(left, rgba(116,66,93,1) 0%, rgba(62,46,46,1) 100%);
            background: linear-gradient(to right, rgba(116,66,93,1) 0%, rgba(62,46,46,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#74425d', endColorstr='#3e2e2e', GradientType=1 );
            font-size: 16px;
        }
    </style>
@endsection


@section('content')
    <!-- inner header wrapper end -->
    <!--blog wrapper start-->
    <div class="blog_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <!-- login_wrapper -->
                    <div class="login_wrapper">
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
                                <h4>{{$careerData->job_title}}</h4>
                            </div>
                        </div>
                        {!! Session::has('success') ? '<div class="alert alert-success alert-dismissible"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'. Session::get("success") .'</div>' : '' !!}
                        {!! Session::has('error') ? '<div class="alert alert-danger alert-dismissible"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'. Session::get("error") .'</div>' : '' !!}

                        <form action="{{url('/career/submit-application')}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="job_tracking_id" value="{{$careerData->id}}">
                            <div class="formsix-pos">
                                <div class="form-group">
                                    <input type="text" name="first_name" class="form-control" required="" placeholder="First name">
                                </div>
                            </div>
                            <div class="formsix-po">
                                <div class="form-group">
                                    <input type="text" name="last_name" class="form-control" required="" placeholder="Last name">
                                </div>
                            </div>
                            <div class="formsix-e">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" required="" placeholder="Email">
                                </div>
                            </div>
                            <div class="formsix-e">
                                <div class="form-group">
                                    <label for="img">Upload your CV in pdf format</label>
                                    <input type="file" name="cv_attachment" class="form-control" required="" placeholder="CV in pdf">
                                </div>
                            </div>
                            <button type="submit" class="login_btn"> Apply Now </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('scripts')
    @include('layouts.website_common_js')
@endsection
