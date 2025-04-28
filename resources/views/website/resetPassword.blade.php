@extends('layout.websiteLayout')
@section('title')@lang('website.Reset Password')@endsection

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
            <strong>@lang('website.Reset Password')</strong>
            <ol class="breadcrumb">
                <li class="breadcrumb--item"><a href="{{ route('home') }}">@lang('website.Home')</a></li>
                <li class="breadcrumb--item">@lang('website.Reset Password')</li>
            </ol>
        </div>
    </div>

    <section class="section_sign_page">
        <div class="container">
            <div class="cont-sign wow fadeInUp">
                <div class="head-sign">
                    <h5>@lang('website.Reset Password')</h5>
                </div>

                <form class="form-group" id="reset-password-form" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="@lang('website.New Password')*" >
                        <div class="invalid-feedback d-none" id="password-error">
                            @lang('validation.required', ['attribute' => __('website.New Password')])
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" id="confirm_password" name="password_confirmation"
                               placeholder="@lang('website.Confirm New Password')*" >
                        <div class="invalid-feedback d-none" id="confirm-password-error">
                            @lang('validation.required', ['attribute' => __('website.Confirm New Password')])
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-site">
                            <span>@lang('website.Reset')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Success Modal -->
    <div class="modal fade" id="modalSuccessRegReset" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-succes-sign">
                        <h3>@lang('website.Success')</h3>
                        <p>@lang('website.Reset Password successfully')!</p>
                        <a class="btn-site" href="{{ route('signIn') }}" aria-label="Close">
                            <span>@lang('website.OK')</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('reset-password-form').addEventListener('submit', function (e) {
            e.preventDefault();

            // Form validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const passwordError = document.getElementById('password-error');
            const confirmPasswordError = document.getElementById('confirm-password-error');

            // Reset validation states
            password.classList.remove('is-invalid');
            passwordError.classList.add('d-none');
            confirmPassword.classList.remove('is-invalid');
            confirmPasswordError.classList.add('d-none');

            let hasError = false;

            // Check if password is empty
            if (password.value.trim() === '') {
                password.classList.add('is-invalid');
                passwordError.classList.remove('d-none');
                hasError = true;
            }

            // Check if password is at least 8 characters
            if (password.value.length < 8) {
                password.classList.add('is-invalid');
                passwordError.textContent = "@lang('validation.min.string', ['attribute' => __('website.New Password'), 'min' => 8])";
                passwordError.classList.remove('d-none');
                hasError = true;
            }

            // Check if confirm password is empty
            if (confirmPassword.value.trim() === '') {
                confirmPassword.classList.add('is-invalid');
                confirmPasswordError.textContent = "@lang('validation.required', ['attribute' => __('website.Confirm New Password')])";
                confirmPasswordError.classList.remove('d-none');
                hasError = true;
            }

            // Check if passwords match
            if (password.value !== confirmPassword.value) {
                confirmPassword.classList.add('is-invalid');
                confirmPasswordError.textContent = "@lang('validation.confirmed', ['attribute' => __('website.New Password')])";
                confirmPasswordError.classList.remove('d-none');
                hasError = true;
            }

            // If no errors, send the form data via Ajax
            if (!hasError) {
                const formData = new FormData();
                formData.append('password', password.value);
                formData.append('password_confirmation', confirmPassword.value);
                formData.append('token', document.querySelector('input[name="token"]').value);
                formData.append('email', document.querySelector('input[name="email"]').value);
                formData.append('_token', document.querySelector('input[name="_token"]').value);

                fetch("{{ route('password.update') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        console.log('Response Status:', response.status);
                        console.log('Response Headers:', [...response.headers.entries()]);

                        if (!response.ok) {
                            return response.json().catch(() => {
                                return Promise.reject({
                                    status: response.status,
                                    statusText: response.statusText
                                });
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response Data:', data);
                        if (data.success) {
                            const modal = new bootstrap.Modal(document.getElementById('modalSuccessRegReset'));
                            modal.show();
                        } else {
                            // Handle validation errors
                            if (data.errors) {
                                if (data.errors.password) {
                                    password.classList.add('is-invalid');
                                    passwordError.textContent = data.errors.password[0];
                                    passwordError.classList.remove('d-none');
                                }
                                if (data.errors.password_confirmation) {
                                    confirmPassword.classList.add('is-invalid');
                                    confirmPasswordError.textContent = data.errors.password_confirmation[0];
                                    confirmPasswordError.classList.remove('d-none');
                                }
                                if (data.errors.email || data.errors.token) {
                                    alert(data.errors.email?.[0] || data.errors.token?.[0] || data.message);
                                }
                            } else {
                                alert(data.message || '@lang("website.An error occurred")');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Fetch Error:', error);
                        let errorMessage = '@lang("website.An error occurred while processing your request")';
                        if (error.status === 419) {
                            errorMessage = 'CSRF token mismatch. Please refresh the page and try again.';
                        } else if (error.status === 422) {
                            errorMessage = 'Validation error occurred.';
                        } else if (error.status) {
                            errorMessage = `Error ${error.status}: ${error.statusText}`;
                        }
                        alert(errorMessage);
                    });
            }
        });
    </script>
@endsection
