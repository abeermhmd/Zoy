@extends('layout.websiteLayout')
@section('title'){{__('website.signUp')}}
@endsection
@section('content')
    <div class="cont-b">
        <div class="breadcrumb-bar wow fadeInUp">
            <strong>@lang('website.Create New Account')</strong>
            <ol class="breadcrumb">
                <li class="breadcrumb--item"><a href="{{ route('home') }}">@lang('website.Home')</a></li>
                <li class="breadcrumb--item">@lang('website.Create New Account')</li>
            </ol>
        </div>
    </div>

    <section class="section_sign_page">
        <div class="container">
            <div class="cont-sign wow fadeInUp">
                <div class="head-sign">
                    <h5>@lang('website.Create New Account')</h5>
                </div>
                <div id="errorContainer" style="display: none;">
                    <ul class="alert alert-danger"></ul>
                </div>

                <form class="form-group" id="registerForm" novalidate>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                               placeholder="@lang('website.Full name') *" required />
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                               placeholder="@lang('website.Email') *" required />
                    </div>
                    <div class="form-group d-flex">
                        <select class="form-control form-select" id="introduction" name="introduction" required>
                            <option value="965" {{ old('introduction')=='965' ? 'selected' : '' }}>+965</option>
                            <option value="966" {{ old('introduction')=='966' ? 'selected' : '' }}>+966</option>
                            <option value="968" {{ old('introduction')=='968' ? 'selected' : '' }}>+968</option>
                            <option value="971" {{ old('introduction')=='971' ? 'selected' : '' }}>+971</option>
                            <option value="973" {{ old('introduction')=='973' ? 'selected' : '' }}>+973</option>
                            <option value="974" {{ old('introduction')=='974' ? 'selected' : '' }}>+974</option>
                        </select>
                        <input type="number" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}"
                               placeholder="@lang('website.Mobile Number') *" required
                               onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" />
                    </div>
                    <div class="form-group form-calender">
                        <input type="text" id="dateInput" name="date_of_birth" value="{{ old('date_of_birth') }}"
                               class="form-control" placeholder="@lang('website.Date of birth') *" required />
                        <i class="icon-calender"></i>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="@lang('website.Password')*"
                               required />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                               placeholder="@lang('website.Confirm Password')*" required />
                    </div>
                    <div class="form-group">
                        <p class="approval">@lang('website.By creating an account, you agree to our Term & Conditions and privacy policies of Zoy') !</p>
                    </div>
                    <!-- Hidden field for reCAPTCHA token -->
                    <input type="hidden" id="recaptchaToken" name="recaptcha_token">
                    <div class="form-group">
                        <button type="submit" class="btn-site register"><span>@lang('website.signup')</span></button>
                    </div>
                </form>
                <div class="oth-sign">
                    <div class="cont-have-acc">
                        <p>@lang('website.Already have an account')</p>
                        <a href="{{ route('signIn') }}" class="btn-site"><span>@lang('website.login')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalSuccessReg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-succes-sign">
                        <h3>@lang('website.Success') </h3>
                        <p>@lang('website.Account Created Successfully') !</p>
                        <a href="{{ route('home') }}" class="btn-site" data-bs-dismiss="modal"
                           aria-label="Close"><span>@lang('website.OK')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $(document).on('click', 'input, select, textarea, .select2', function () {
                $(this).attr('style', "").next('span.errorSpan').remove();
            });

            var preventSubmit = false;
            $('#registerForm').on('submit', function (e) {
                e.preventDefault();

                preventSubmit = false;

                // Check required fields
                $(this).find('select, textarea, input').each(function () {
                    if ($(this).prop('required') && !$(this).val() && !$(this).is(":hidden")) {
                        $(this)
                            .css({
                                "background": "rgb(189 22 22 / 10%)",
                                "margin-bottom": "30px"
                            })
                            .next('span.errorSpan').remove();
                        $(this).after('<span style="color:#bd1616" class="errorSpan">{{ __("website.requiredField") }}</span>');
                        preventSubmit = true;
                    } else {
                        $(this)
                            .css({
                                "background": "",
                                "margin-bottom": ""
                            });
                        $(this).next('span.errorSpan').remove();
                    }
                });

                if (preventSubmit) {
                    preventSubmit = false;
                    return false;
                }

                // Execute reCAPTCHA verification before form submission
                grecaptcha.ready(function () {
                    grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY', "6LeqtR0rAAAAAKMziyF9l1Vc8wHwO7q_9ikGVdvU") }}', { action: 'register' }).then(function (token) {
                        // Set the token in the hidden field
                        $('#recaptchaToken').val(token);

                        // Continue with form submission
                        submitRegistrationForm();
                    });
                });

                function submitRegistrationForm() {
                    $.ajax({
                        url: '{{ route("register") }}',
                        type: "post",
                        data: $('#registerForm').serialize(),
                        success: function (response) {
                            if (response.code === 200) {
                                $('#registerForm')[0].reset();
                                $('#modalSuccessReg').modal('show');
                            } else if (response.error) {
                                // Error message from server (like registerStoped)
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __("website.Error") }}',
                                    text: response.error,
                                    confirmButtonText: '{{ __("website.OK") }}'
                                });
                            } else if (response.code === 201) {
                                // Error message from server (like registerStoped)
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __("website.Error") }}',
                                    text: response.message,
                                    confirmButtonText: '{{ __("website.OK") }}'
                                });
                            } else {
                                // Any other error
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __("website.Error") }}',
                                    text: response.message || '{{ __("website.Error occurred. Please try again.") }}',
                                    confirmButtonText: '{{ __("website.OK") }}'
                                });
                            }
                        },
                        error: function (xhr) {
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                var errorMessages = [];

                                // Collect all validation error messages
                                $.each(errors, function (key, value) {
                                    errorMessages.push(value[0]);
                                });

                                // Show validation errors in SweetAlert
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __("website.Error") }}',
                                    html: errorMessages.join('<br>'),
                                    confirmButtonText: '{{ __("website.OK") }}'
                                });
                            } else {
                                // Handle other error types
                                var errorMsg = xhr.statusText || '{{ __("website.Error occurred. Please try again.") }}';
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __("website.Error") }}',
                                    text: xhr.status + ': ' + errorMsg,
                                    confirmButtonText: '{{ __("website.OK") }}'
                                });
                            }
                        }
                    });
                }
            });

            // Redirect to home page when clicking OK on the modal
            $('#modalSuccessReg').on('click', '.btn-site', function () {
                window.location.href = "{{ route('home') }}";
            });
        });
    </script>
@endsection
