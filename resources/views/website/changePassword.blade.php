@extends('website.myAccountLayout')
@section('contentMyAccount')
<div class="col-lg-9">
    <div class="cont-account wow fadeInUp">
        <form class="form-change" id="changeForm">
            <div class="d-flex">
                <div class="form-group">
                    <input type="password" id="oldPassword" class="form-control" placeholder="@lang('website.Old Password') *" required/>
                </div>
                <div class="form-group">
                    <input type="password" id="newPassword" class="form-control" placeholder="@lang('website.New Password') *" required/>
                </div>
            </div>
            <div class="d-flex">
                <div class="form-group">
                    <input type="password" id="confirmPassword" class="form-control" placeholder="@lang('website.Confirm New Password') *" required/>
                </div>
            </div>
            <div class="form-group">
                <button class="btn-site btnReg updatePassword" ><span>@lang('website.Change')</span></button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalChange" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
    role="dialog">
    <div class="wsmall modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="content-succes-sign">
                    <h3>@lang('website.Success')</h3>
                    <p>@lang('website.Password changed successfully') !</p>
                    <a class="btn-site" data-bs-dismiss="modal" aria-label="Close"><span>@lang('website.OK')</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $(document).on('click', 'input,select,textarea,.select2', function () {
            $(this).attr('style', "").next('span.errorSpan').remove();
        });

        var preventSubmit = false;
        $(document).on('click', '.updatePassword', function (e) {
            e.preventDefault();

            preventSubmit = false;

            var form = $(this).closest("#changeForm");

            // Validate required fields
            form.find('select, textarea, input').each(function () {
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

            $.ajax({
                url: '{{route('changePasswordPost')}}',
                type: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                    old_password: $('#oldPassword').val(),
                    new_password: $('#newPassword').val(),
                    confirm_password: $('#confirmPassword').val(),
                },
                success: function (response) {
                    if (response.code == 300) {
                        $('#modalChange').modal('show');
                        $('#oldPassword').val('');
                        $('#newPassword').val('');
                        $('#confirmPassword').val('');
                    } else if (response.validator != null) {
                        $('.errorTextModal').empty();
                        $('.errorTextModal').append(response.validator);
                        $('#modalError').modal('show');

                    } else {
                        $('.errorTextModal').empty();
                        $('.errorTextModal').append(response.message);
                        $('#modalError').modal('show');

                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = [];

                        // Collect all error messages
                        $.each(errors, function (key, value) {
                            errorMessages.push(value[0]);
                        });

                        // Show errors in SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("website.Error") }}',
                            html: errorMessages.join('<br>'),
                            confirmButtonText: '{{ __("website.OK") }}'
                        });
                    } else {
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
        });
    });
</script>
@endsection
