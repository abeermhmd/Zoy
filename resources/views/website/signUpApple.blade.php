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
    </style>
    <div class="cont-b">
        <div class="breadcrumb-bar wow fadeInUp">
            <strong>@lang('website.continue_with_apple')</strong>
            <ol class="breadcrumb">
                <li class="breadcrumb--item"><a href="{{ route('home') }}">@lang('website.Home')</a></li>
                <li class="breadcrumb--item">@lang('website.continue_with_apple')</li>
            </ol>
        </div>
    </div>

    <section class="section_sign_page">
        <div class="container">
            <div class="cont-sign wow fadeInUp">
                <div class="head-sign">
                    <h5>@lang('website.continue_with_apple')</h5>
                </div>
                <form class="form-group" id="apple-signin-form">
                    @csrf
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

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
                    @error('full_mobile')
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
                        <p class="approval">@lang('website.continue_with_apple_agreement') !</p>
                    </div>
                    <!-- Add reCAPTCHA hidden input -->
                    <input type="hidden" id="recaptchaToken" name="recaptcha_token">
                    @if ($errors->has('recaptcha_token'))
                        <ul class="alert alert-danger">
                            <li>{{ $errors->first('recaptcha_token') }}</li>
                        </ul>
                    @endif
                    <div class="form-group">
                        <button type="submit" class="btn-site" id="apple-signin-button"><span>@lang('website.Continue')</span></button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('apple-signin-form');
            const appleButton = document.getElementById('apple-signin-button');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
            });

            appleButton.addEventListener('click', function(e) {
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
                    grecaptcha.ready(function() {
                        grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY', "6LeqtR0rAAAAAKMziyF9l1Vc8wHwO7q_9ikGVdvU") }}', { action: 'apple_signin' }).then(function(token) {
                            // Set reCAPTCHA token in the hidden input
                            document.getElementById('recaptchaToken').value = token;

                            // Proceed with Apple Sign-In
                            if (window.AppleID) {
                                setupAppleSignIn();
                            } else {
                                const script = document.createElement('script');
                                script.src = 'https://appleid.cdn-apple.com/appleauth/static/jsapi/appleid/1/en_US/appleid.auth.js';
                                script.async = true;
                                script.defer = true;
                                script.onload = setupAppleSignIn;
                                document.head.appendChild(script);
                            }
                        }).catch(function(error) {
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
                errorMessages.forEach(function(error) {
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

            // Add input event to clear error messages on input
            const inputs = document.querySelectorAll('input, select');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    clearError(input);
                });
            });

            function setupAppleSignIn() {
                AppleID.auth.init({
                    clientId: 'com.zoykw',
                    scope: 'name email',
                    redirectURI: window.location.origin + '/login/apple/callback',
                    state: 'state',
                    usePopup: true
                });

                AppleID.auth.signIn().then(function(response) {
                    handleAppleResponse(response);
                }).catch(function(error) {
                    console.error('Apple Sign In failed:', error);
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("website.Error") }}',
                        text: '{{ __("website.Apple Sign In Error") }}',
                        confirmButtonText: "{{__('website.OK')}}"
                    });
                });
            }

            // Handle Apple response
            function handleAppleResponse(response) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/login/apple/callback';
                form.style.display = 'none';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfInput);

                const idTokenInput = document.createElement('input');
                idTokenInput.type = 'hidden';
                idTokenInput.name = 'id_token';
                idTokenInput.value = response.authorization.id_token;
                form.appendChild(idTokenInput);

                const introductionInput = document.createElement('input');
                introductionInput.type = 'hidden';
                introductionInput.name = 'introduction';
                introductionInput.value = document.getElementById('introduction').value;
                form.appendChild(introductionInput);

                const mobileInput = document.createElement('input');
                mobileInput.type = 'hidden';
                mobileInput.name = 'mobile';
                mobileInput.value = document.getElementById('mobile').value;
                form.appendChild(mobileInput);

                const dobInput = document.createElement('input');
                dobInput.type = 'hidden';
                dobInput.name = 'date_of_birth';
                dobInput.value = document.getElementById('dateInput').value;
                form.appendChild(dobInput);

                const recaptchaInput = document.createElement('input');
                recaptchaInput.type = 'hidden';
                recaptchaInput.name = 'recaptcha_token';
                recaptchaInput.value = document.getElementById('recaptchaToken').value;
                form.appendChild(recaptchaInput);

                if (response.user) {
                    if (response.user.name) {
                        const nameInput = document.createElement('input');
                        nameInput.type = 'hidden';
                        nameInput.name = 'name';
                        nameInput.value = response.user.name.firstName + ' ' + response.user.name.lastName;
                        form.appendChild(nameInput);
                    }
                    if (response.user.email) {
                        const emailInput = document.createElement('input');
                        emailInput.type = 'hidden';
                        emailInput.name = 'email';
                        emailInput.value = response.user.email;
                        form.appendChild(emailInput);
                    }
                }

                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>
@endsection
