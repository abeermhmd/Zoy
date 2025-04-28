@extends('layout.websiteLayout')
@section('title'){{__('website.signUp')}}
@endsection
@section('content')
    <style>
        .error {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 5px;
            display: block;
        }
        .general-error {
            color: #dc3545;
            font-size: 1rem;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
    <div class="cont-b">
        <div class="breadcrumb-bar wow fadeInUp">
            <strong>@lang('website.continue_with_google')</strong>
            <ol class="breadcrumb">
                <li class="breadcrumb--item"><a href="{{ route('home') }}">@lang('website.Home')</a></li>
                <li class="breadcrumb--item">@lang('website.continue_with_google')</li>
            </ol>
        </div>
    </div>

    <section class="section_sign_page">
        <div class="container">
            <div class="cont-sign wow fadeInUp">
                <div class="head-sign">
                    <h5>@lang('website.continue_with_google')</h5>
                </div>
                <form class="form-group" id="google-signin-form">
                    @csrf
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="form-group d-flex">
                        <select class="form-control form-select" id="introduction" name="introduction" required>
                            <option value="965" {{ old('introduction', session('google_signup_data.introduction', '965')) == '965' ? 'selected' : '' }}>+965</option>
                            <option value="966" {{ old('introduction', session('google_signup_data.introduction', '966')) == '966' ? 'selected' : '' }}>+966</option>
                            <option value="968" {{ old('introduction', session('google_signup_data.introduction', '968')) == '968' ? 'selected' : '' }}>+968</option>
                            <option value="971" {{ old('introduction', session('google_signup_data.introduction', '971')) == '971' ? 'selected' : '' }}>+971</option>
                            <option value="973" {{ old('introduction', session('google_signup_data.introduction', '973')) == '973' ? 'selected' : '' }}>+973</option>
                            <option value="974" {{ old('introduction', session('google_signup_data.introduction', '974')) == '974' ? 'selected' : '' }}>+974</option>
                        </select>
                        <input type="number" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}"
                               placeholder="@lang('website.Mobile Number') *" required
                               onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" />
                    </div>
                    @error('mobile')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    <div class="form-group form-calender">
                        <input type="text" id="dateInput" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}"
                               placeholder="@lang('website.Date of birth') *" required />
                        <i class="icon-calender"></i>
                    </div>
                    @error('date_of_birth')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    <div class="form-group">
                        <p class="approval">@lang('website.continue_with_google_agreement') !</p>
                    </div>
                    <!-- Add reCAPTCHA hidden input -->
                    <input type="hidden" id="recaptchaToken" name="recaptcha_token">
                    @if ($errors->has('recaptcha_token'))
                        <ul class="alert alert-danger">
                            <li>{{ $errors->first('recaptcha_token') }}</li>
                        </ul>
                    @endif
                    <div class="form-group">
                        <button type="submit" class="btn-site" id="google-signin-button"><span>@lang('website.Continue')</span></button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const googleButton = document.getElementById('google-signin-button');
            const form = document.getElementById('google-signin-form');

            form.addEventListener('submit', function (e) {
                e.preventDefault();
            });

            googleButton.addEventListener('click', function (e) {
                e.preventDefault();
                clearAllErrors();

                let isValid = true;

                const introduction = document.getElementById('introduction');
                const mobile = document.getElementById('mobile');
                const dateOfBirth = document.getElementById('dateInput');

                if (!introduction.value) {
                    showError(introduction, "{{ __('validation.required', ['attribute' => __('validation.attributes.introduction')]) }}");
                    isValid = false;
                }

                if (!mobile.value) {
                    showError(mobile, "{{ __('validation.required', ['attribute' => __('validation.attributes.mobile')]) }}");
                    isValid = false;
                } else if (mobile.value.length < 8) {
                    showError(mobile, "{{ __('validation.min.string', ['attribute' => __('validation.attributes.mobile'), 'min' => 8]) }}");
                    isValid = false;
                }

                if (!dateOfBirth.value) {
                    showError(dateOfBirth, "{{ __('validation.required', ['attribute' => __('validation.attributes.date_of_birth')]) }}");
                    isValid = false;
                }

                if (isValid) {
                    // Execute reCAPTCHA
                    grecaptcha.ready(function () {
                        grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY', "6LeqtR0rAAAAAKMziyF9l1Vc8wHwO7q_9ikGVdvU") }}', { action: 'google_signin' }).then(function (token) {
                            // Set reCAPTCHA token in the hidden input
                            document.getElementById('recaptchaToken').value = token;

                            // Send form data via AJAX to the Controller
                            const formData = {
                                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                introduction: introduction.value,
                                mobile: mobile.value,
                                date_of_birth: dateOfBirth.value,
                                recaptcha_token: token
                            };

                            fetch('{{ route("login.social", "google") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify(formData)
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        window.location.href = data.redirect;
                                    } else {
                                        // Display errors from the backend
                                        showErrorMessages(data.errors);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{ __("website.Error") }}',
                                        text: '{{ __("website.Request Failed") }}',
                                        confirmButtonText: "{{__('website.OK')}}"
                                    });
                                });
                        }).catch(function (error) {
                            console.error('reCAPTCHA failed:', error);
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __("website.Error") }}',
                                text: '{{ __("website.reCAPTCHA Error") }}',
                                confirmButtonText: "{{__('website.OK')}}"
                            });
                        });
                    });
                }
            });

            // Clear all error messages
            function clearAllErrors() {
                const errorMessages = document.querySelectorAll('.error');
                errorMessages.forEach(function (error) {
                    error.remove();
                });
            }

            // Show error message below the field
            function showError(element, message) {
                const existingError = element.parentNode.querySelector('.error');
                if (existingError) {
                    existingError.remove();
                }

                const error = document.createElement('span');
                error.classList.add('error');
                error.textContent = message;

                element.parentNode.appendChild(error);

                element.style.background = 'rgb(189 22 22 / 10%)';
                element.style.marginBottom = '30px';
            }

            // Clear error message from the field
            function clearError(element) {
                const existingError = element.parentNode.querySelector('.error');
                if (existingError) {
                    existingError.remove();
                }
                element.style.background = '';
                element.style.marginBottom = '';
            }
            // Display error messages from backend
            function showErrorMessages(errors) {
                for (let field in errors) {
                    const element = document.querySelector(`[name="${field}"]`);
                    if (element) {
                        showError(element, errors[field][0]);
                    }
                }
            }

            // Add input event to clear error messages on input
            const inputs = document.querySelectorAll('input, select');
            inputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    clearError(input);
                });
            });
        });
    </script>
@endsection
