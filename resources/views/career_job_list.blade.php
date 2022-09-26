
@extends('layouts.website_layout')

@section('styles')
    @include('layouts.website_common_css')
@endsection


@section('content')


    <!-- inner header wrapper start -->
    <div class="page_title_section float_left">
        <div class="page_header">
            <div class="container">
                <div class="row">
                    <!-- section_heading start -->
                    <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                        <h1>Career</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- inner header wrapper end -->
    <!--blog wrapper start-->
    <div class="blog_wrapper">
        <div class="container">
            <div class="row">
                @if($careerData->isEmpty())
                    <h3 style="margin-top: 15px;text-align: center;">No Jobs Available</h3>
                @else
                    @foreach($careerData as $career)
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="edu_slide_tab_box float_left">
                                <div class="edu_slide_tabs_img_box edu_slide_tabs_img_box_event float_left">
                                    <img src="{{asset('website_src/images/pc1.jpg')}}" alt="img">
                                    {{--                                    <div class="edu_tabs_label edu_tabs_label_event_wrapper">--}}
                                    {{--                                        <p class="edu_tabs_label_event">OCT</p>--}}
                                    {{--                                        <div class="edu_tabs_label_inner">--}}
                                    {{--                                            <p>31</p>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                </div>
                                <div class="edu_slide_tabs_img_cont_box edu_slide_tabs_img_cont_box_event float_left">
                                    <h4>Deadline : <span>{{$career->deadline}}</span> &nbsp;&nbsp;&nbsp; Vacancy : <span>{{$career->vacancy}}</span></h4>
                                    <h3><a href="#">{{$career->job_title}}</a></h3>
                                    <p>{{$career->job_description}}</p>
                                    <h5>
                                        <a href="{{url('career/apply-now').'/'.$career->id}}" target="_blank" class="apply_button">Apply Now</a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!--blog wrapper end-->


@endsection


@section('scripts')
    @include('layouts.website_common_js')
@endsection
