@extends('layout.websiteLayout')
@section('title'){{__('website.login')}}
@endsection
@section('content')
<div class="cont-b">
    <div class="breadcrumb-bar wow fadeInUp">
        <strong>@lang('website.login')</strong>
        <ol class="breadcrumb">
            <li class="breadcrumb--item"><a href="{{ route('home') }}">@lang('website.Home')</a></li>
            <li class="breadcrumb--item">@lang('website.login')</li>
        </ol>
    </div>
</div>
<section class="section_sign_page">
    <div class="container">

        <div class="cont-sign wow fadeInUp">
            <div class="head-sign">
                <h5>@lang('website.Login into your Account')</h5>
            </div>
            @if (count($errors) > 0)
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if (session('msg'))
                <ul class="alert alert-success mb-5">
                    <li>{{ session('msg') }}</li>
                </ul>
            @endif
            @if (session('error'))
                <ul class="alert alert-danger">
                    <li>{{ session('error') }}</li>
                </ul>
            @endif
            <form class="form-group" method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                @csrf
                <div class="form-group">
                    <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="@lang('website.Email Address')*" required />
                    <span class="error-message" style="color: red; display: none;">@lang('website.requiredField')</span>

                </div>
                <div class="form-group">
                    <input type="password" name="password" value="{{old('password')}}" class="form-control" placeholder="@lang('website.Password')*" required />
                    <span class="error-message" style="color: red; display: none;">@lang('website.requiredField')</span>

                </div>
                <div class="form-group">
                    <a href="{{ route('forgotPassword') }}" class="forgot-password">@lang('website.Forgot Password')</a>
                </div>
                <input type="hidden" id="recaptchaToken" name="recaptcha_token">

                <div class="form-group">
                    <button type="submit" class="btn-site"><span>@lang('website.login')</span></button>
                </div>
            </form>
            <div class="oth-sign">
                <div class="cont-social">
                    <p>@lang('website.Login with social media')</p>
                    <ul>
{{--                        <li><a href="{{ route('login.social', 'facebook') }}"><i class="icon icon-facebook"></i></a></li>--}}
                        <li><a href="{{ route('signUpGoogle') }}"><i class="icon icon-google"></i></a></li>
                        <li><a href="{{ route('signUpApple') }}"><i class="icon icon-apple"></i></a></li>
                    </ul>
                </div>
                <div class="cont-have-acc">
                    <p>@lang('website.Don’t have an account')</p>
                    <a href="{{ route('signUp') }}" class="btn-site"><span>@lang('website.signup')</span></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--section_home-->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                var isValid = true;

                // Clear previous error styles
                $('.form-group input').css({
                    'background': '',
                    'margin-bottom': ''
                });
                $('.error-message').hide();

                // Check required fields
                $(this).find('input[required]').each(function() {
                    if ($(this).val() === '') {
                        $(this).css({
                            'background': 'rgb(189 22 22 / 10%)',
                            'margin-bottom': '30px',

                        });
                        $(this).next('.error-message').show(); // Show error message
                        isValid = false;
                    }
                });

                // If form is invalid, prevent submission
                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Remove red background and error message on input change
            $('input').on('input', function() {
                if ($(this).val() !== '') {
                    $(this).css({
                        'background': '',
                        'margin-bottom': '',
                    });
                    $(this).next('.error-message').hide();
                }
            });
        });


        grecaptcha.ready(function() {
            function refreshToken() {
                grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {action: 'login'}).then(function(token) {
                    document.getElementById('recaptchaToken').value = token;
                });
            }
            refreshToken();
            setInterval(refreshToken, 120000); // update every 120 seconds
        });
    </script>
@endsection
