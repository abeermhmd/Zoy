@extends('website.myAccountLayout')
@section('contentMyAccount')

<div class="col-lg-9">
    <div id="errorContainer" style="display: none;">
        <ul class="alert alert-danger"></ul>
    </div>
    <div class="cont-account wow fadeInUp">
        <form class="form-account" id="accountForm">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="d-flex">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" id="name" value="{{auth('web')->user()->name}}" required />
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email"  value="{{auth('web')->user()->email}}" required />
                </div>
            </div>
            <div class="d-flex">
                <div class="form-group d-flex">
                    <select class="form-control form-select" name="introduction" id="introduction" required>
                        <option value="965" {{substr(auth('web')->user()->mobile, 0, 3) == '965' ? 'selected' : ''}}>+965</option>
                        <option value="966" {{substr(auth('web')->user()->mobile, 0, 3) == '966' ? 'selected' : ''}}>+966</option>
                        <option value="968" {{substr(auth('web')->user()->mobile, 0, 3) == '968' ? 'selected' : ''}}>+968</option>
                        <option value="971" {{substr(auth('web')->user()->mobile, 0, 3) == '971' ? 'selected' : ''}}>+971</option>
                        <option value="973" {{substr(auth('web')->user()->mobile, 0, 3) == '973' ? 'selected' : ''}}>+973</option>
                        <option value="974" {{substr(auth('web')->user()->mobile, 0, 3) == '974' ? 'selected' : ''}}>+974</option>
                    </select>
                    <input type="number" class="form-control" name="mobile" id="mobile" value="{{substr(auth('web')->user()->mobile , 3 )}}" required/>
                </div>
                <div class="form-group form-calender">
                    <input type="text" id="dateInput" class="form-control" name="date_of_birth" value="{{auth('web')->user()->date_of_birth}}" required />
                    <i class="icon-calender"></i>
                </div>
            </div>
            <div class="form-group">
                <button  class="btn-site btnReg updateProfile" ><span>@lang('website.Update')</span></button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
    role="dialog">
    <div class="wsmall modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="content-succes-sign">
                    <h3>@lang('website.Success')</h3>
                    <p>@lang('website.Account updated successfully') !</p>
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
        // Clear error styling when field is clicked
            $(document).on('click', 'input, select, textarea, .select2', function () {
                $(this).attr('style', "").next('span.errorSpan').remove();
            });

            $(document).on('click', '.updateProfile', function (e) {
                e.preventDefault();
                var preventSubmit = false;
                var form = $('#accountForm');

                form.find('select, textarea, input').each(function () {
                    if ($(this).prop('required') && !$(this).val() && !$(this).is(":hidden")) {
                        $(this)
                            .css({
                                "background": "rgb(189 22 22 / 10%)",
                                "margin-bottom": "30px",

                            })
                            .next('span.errorSpan').remove();
                        $(this).after('<span style="color:#bd1616" class="errorSpan">{{ __("website.requiredField") }}</span>');
                        preventSubmit = true;
                    } else {
                        $(this)
                            .css({
                                "background": "",
                                "margin-bottom": "",
                            });
                        $(this).next('span.errorSpan').remove();
                    }
                });

                if (preventSubmit) {
                    return false;
                }

                var formData = {
                    _token: $('input[name="_token"]').val(),
                    name: $('#name').val(),
                    email: $('#email').val(),
                    introduction: $('#introduction').val(),
                    mobile: $('#mobile').val(),
                    date_of_birth: $('#dateInput').val()
                };

                $.ajax({
                    url: '{{ route("updateProfile") }}',
                    type: "post",
                    data: formData,
                    success: function (response) {
                        if (response.code == 300) {
                            $('#updateModal').modal('show');
                        } else if (response.message) {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __("website.Error") }}',
                                text: response.message,
                                confirmButtonText: '{{ __("website.OK") }}'
                            });
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = [];

                            $.each(errors, function (key, value) {
                                errorMessages.push(value[0]);
                            });

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

