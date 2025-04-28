@extends('layout.websiteLayout')
@section('title'){{ __('website.ForgotPassword') }}
@endsection
@section('css')
    <style>
        input.is-invalid {
            background: rgb(189 22 22 / 10%);

        }

    </style>
@endsection
@section('content')

    <div class="cont-b">
        <div class="breadcrumb-bar wow fadeInUp">
            <strong>@lang('website.ForgotPassword')</strong>
            <ol class="breadcrumb">
                <li class="breadcrumb--item"><a href="{{ route('home') }}">@lang('website.Home')</a></li>
                <li class="breadcrumb--item">@lang('website.ForgotPassword')</li>
            </ol>
        </div>
    </div>

    <section class="section_sign_page">
        <div class="container">
            <div class="cont-sign wow fadeInUp">
                <div class="head-sign">
                    <h5>@lang('website.ForgotPassword')</h5>
                    <p>@lang('website.Please submit your email address to receive instructions for resetting your forgotten password').</p>
                </div>

                {{-- رسائل النجاح --}}
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- رسائل الخطأ --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-group" method="POST" action="{{ route('password.email') }}" id="forgot-password-form">
                    @csrf
                    <div class="form-group">
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            id="email"
                            placeholder="@lang('website.Email') *"

                            value="{{ old('email') }}"
                        />
                        <div class="invalid-feedback d-none" id="email-error">
                            @lang('validation.required', ['attribute' => __('website.Email')])
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-site">
                            <span>@lang('website.Submit')</span>
                        </button>
                    </div>
                </form>


                <div class="oth-sign">
                    <div class="back-login">
                        <a href="{{ route('signIn') }}">@lang('website.Back to Login')</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
    <script>
        document.getElementById('forgot-password-form').addEventListener('submit', function(e) {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('email-error');

            // احذف أي خطأ قديم
            emailInput.classList.remove('is-invalid');
            emailError.classList.add('d-none');

            if (emailInput.value.trim() === '') {
                e.preventDefault(); // امنع الإرسال
                emailInput.classList.add('is-invalid');
                emailError.classList.remove('d-none');
            }
        });

        const inputs = document.querySelectorAll('input, select');

        inputs.forEach(function (input) {
            input.addEventListener('input', function () {
                input.classList.remove('is-invalid');
                const nextError = input.nextElementSibling;
                if (nextError && nextError.classList.contains('invalid-feedback')) {
                    nextError.classList.add('d-none');
                }
            });
        });

    </script>
@endsection
