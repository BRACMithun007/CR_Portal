<!DOCTYPE html>
<html>

<head>
    <title>Login | MF</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="expires" content="Mon, 26 Jul 1997 05:00:00 GMT"/>
    <meta http-equiv="pragma" content="no-cache" />

    <script src="{{asset('brac_login_src/bootstrap/js/jquery-3.2.1.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('brac_login_src/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('brac_login_src/css/layout.css')}}">
    <link rel="icon" type="text/css" href="{{asset('brac_login_src/images/favicon.ico')}}">

    <script src="{{asset('brac_login_src/bootstrap/js/popper.js')}}"></script>
    <script src="{{asset('brac_login_src/bootstrap/js/bootstrap.js')}}"></script>
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-md-center">
        <div class="card col-md-9 col-xs-12 mt-md-5 p-0">
            <div class="card-body px-5 pt-5 pb-3">
                <div class="card-title">
                    <h4 class="pb-3">Welcome to BRAC Microfinance
                        <img src="brac_login_src/images/brac_logo.png" style="width: 100px;" class="float-right" />
                    </h4>
                </div>
                <div class="row">
                    <div class="col-md-6" id="seperator">
                        <div class="row align-items-center h-100">
                            <div class="col-md-12">
                                @if($errors->any())
                                    <div class="alert alert-danger" style="margin-right: 20px;">
                                        <strong> Sorry ! You are not authorized. </strong>
                                    </div>
                                @endif
                                <div class="form-group lead" style="font-size: 15px;">
                                    Users with BRAC Gmail id must login from here
                                </div>
                                <div class="form-group">
                                    <label class="text-danger d-none" id="googleError"></label>
                                    <!-- <div id="glogin" class="g-signin2 d-flex justify-content-center" role="button"></div> -->
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-6">
                                            <a href="{{ route('social.oauth', 'google') }}" class="btn btn-google">
                                                <i><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 48 48" class="abcRioButtonSvg"><g><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path><path fill="none" d="M0 0h48v48H0z"></path></g></svg></i>
                                                Sign in
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group lead" style="font-size: 15px;">
                            Users without BRAC Gmail id must login from here
                        </div>
                        <form id="nonEmailForm" action="{{ route('login') }}" method="post">
                            @csrf
                            <label class="text-danger d-none" id="error"></label>
                            <div class="form-group">
                                <label for="user">Email</label>
                                <input id="email" placeholder="Email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" placeholder="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group row justify-content-end">
                                <div class="col-md-12 col-lg-5">
                                    <button class="btn btn-outline-brac btn-block" type="submit">Login</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <a href="#" class="btn btn-sm btn-link-brac col-md-6">Forget your password?</a>
                                <a href="#" class="btn btn-sm btn-link-brac col-md-6">Do not have access?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer px-5 text-center">
                <span class="text-muted small">Note: For Google Sign On access, you must have a valid BRAC Gmail id.</span>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('brac_login_src/js/site_V1.0d41d.js')}}"></script>
<script src="{{asset('brac_login_src/js/client_platform7a7d.js')}}"></script>
</body>

</html>

