@extends('layout.websiteLayout')
@section('title')@lang('website.Contact')
@endsection
@section('content')
<div class="cont-b">
    <div class="breadcrumb-bar wow fadeInUp">
        <strong>@lang('website.Contact')</strong>
        <ol class="breadcrumb">
            <li class="breadcrumb--item"><a href="{{ route(name: 'home') }}">@lang('website.Home')</a></li>
            <li class="breadcrumb--item">@lang('website.Contact')</li>
        </ol>
    </div>
</div>

<section class="section_contact_page">
    <div class="container">
        <div class="contact-wrapper">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="contact-ifo wow fadeInUp">
                        <h4>@lang('website.Reach out & touch us')</h4>
                        <a href="{{ @$setting->map_location_pinpoint }}" target="_blank"> <p>{{ @$setting->address }}</p></a>
                        <ul class="list-contact">
                            <li>
                                <a href="mailto:{{ @$setting->info_email }}" target="_blank">
                                    <span><i class="icon-envelope"></i></span> {{ @$setting->info_email }}
                                </a>
                            </li>
                            <li>
                                <a href="tel: {{ @$setting->mobile }}" target="_blank">
                                    <span><i class="icon-phone"></i></span> {{ @$setting->mobile }}
                                </a>
                            </li>
                            <li>
                                <a href="https://wa.me/{{ @$setting->whatsApp }}" target="_blank">
                                    <span><i class="fa-brands fa-whatsapp"></i></span> {{ @$setting->whatsApp }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="cont-form-contact wow fadeInUp">
                        <h4>@lang('website.Send us a message')</h4>
                        <div id="errorContainer" style="display: none;">
                            <ul class="alert alert-danger"></ul>
                        </div>
                        <form class="form-contact" id="contactForm">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" placeholder="@lang('website.Full name') *" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="@lang('website.Email') *" required>
                            </div>
                            <div class="form-group d-flex">
                                <select class="form-control form-select" name="introduction" id="introduction" name="introduction" required>
                                    <option value="965" {{ old('introduction')=='965' ? 'selected' : '' }}>+965</option>
                                    <option value="966" {{ old('introduction')=='966' ? 'selected' : '' }}>+966</option>
                                    <option value="968" {{ old('introduction')=='968' ? 'selected' : '' }}>+968</option>
                                    <option value="971" {{ old('introduction')=='971' ? 'selected' : '' }}>+971</option>
                                    <option value="973" {{ old('introduction')=='973' ? 'selected' : '' }}>+973</option>
                                    <option value="974" {{ old('introduction')=='974' ? 'selected' : '' }}>+974</option>
                                </select>
                                <input type="number" class="form-control" name="mobile" id="mobile" placeholder="@lang('website.Mobile Number') *" required />
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" id="message" placeholder="@lang('website.Message') *" required ></textarea>
                            </div>
                            <input type="hidden" id="recaptchaToken" name="recaptcha_token">
                            <div class="form-group">
                                <button class="btn-site btnReg contact_us" ><span>@lang('website.Send')</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--section_contact_page-->
<div class="modal fade" id="modalSendMs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="content-succes-sign">
                    <h3>@lang('website.Success') </h3>
                    <p>@lang('website.Message Send!') !</p>
                    <a class="btn-site" data-bs-dismiss="modal" aria-label="Close"><span>@lang('website.OK')</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $(document).on('click', '.contact_us', function (e) {
            e.preventDefault();

            // Reset error container and remove previous error spans
            $('#errorContainer').hide().find('ul').empty();
            $('.errorSpan').remove();
            $('#contactForm input, #contactForm select, #contactForm textarea').removeClass('is-invalid border-danger'); // إزالة التنسيق في البداية

            var form = $('#contactForm');

            // Client-side validation
            var preventSubmit = false;
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
                return false;
            }

            // Call reCAPTCHA
            grecaptcha.ready(function () {
                grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY', "6LeqtR0rAAAAAKMziyF9l1Vc8wHwO7q_9ikGVdvU") }}', { action: 'contact_us' }).then(function (token) {

                    // Append the token to the form
                    if (form.find('input[name="recaptcha_token"]').length === 0) {
                        form.append('<input type="hidden" name="recaptcha_token" value="' + token + '">');
                    } else {
                        form.find('input[name="recaptcha_token"]').val(token);
                    }

                    // Send AJAX
                    $.ajax({
                        url: '{{ route('contactUsPost') }}',
                        type: "post",
                        data: form.serialize(),
                        success: function (response) {
                            $('#errorContainer').hide().find('ul').empty();
                            $('.errorSpan').remove();
                            $('#contactForm input, #contactForm select, #contactForm textarea').removeClass('is-invalid'); // إزالة التنسيق في النجاح

                            if (response.code == 300) {
                                $('#modalSendMs').modal('show');
                                $('#contactForm')[0].reset();
                            } else if (response.code == 422 && response.validator) {
                                $('#errorContainer').hide().find('ul').empty();
                                $('.errorSpan').remove();
                                $('#contactForm input, #contactForm select, #contactForm textarea').removeClass('is-invalid'); // إزالة التنسيق عند وجود أخطاء

                                var $errorList = $('#errorContainer').show().find('ul');
                                Object.keys(response.validator).forEach(function (key) {
                                    response.validator[key].forEach(function (errorMsg) {
                                        $errorList.append('<li>' + errorMsg + '</li>');
                                    });
                                    if (response.validator[key].length > 0) {
                                        $('[name="' + key + '"]').css("border", "#bd1616 solid 1px")
                                            .after('<span style="color:#bd1616" class="errorSpan">' + response.validator[key][0] + '</span>');
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __("website.Error") }}',
                                    text: response.message || '{{ __("website.Error") }}',
                                    confirmButtonText: "{{__('website.OK')}}"
                                });
                            }
                        },
                        error: function (xhr) {
                            var $errorList = $('#errorContainer').show().find('ul');
                            $errorList.empty();
                            $('.errorSpan').remove();

                            if (xhr.status === 422 && xhr.responseJSON.errors) {
                                Object.keys(xhr.responseJSON.errors).forEach(function (key) {
                                    xhr.responseJSON.errors[key].forEach(function (errorMsg) {
                                        $errorList.append('<li>' + errorMsg + '</li>');
                                    });
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __("website.Error") }}',
                                    text: xhr.responseJSON?.message || '{{ __("website.Error") }}',
                                    confirmButtonText: "{{__('website.OK')}}"
                                });
                            }
                        }
                    });
                });
            });
        });
        $('#contactForm input, #contactForm select, #contactForm textarea').on('input', function() {
            if ($(this).val()) {
                $(this).css("border", "");
                $(this).next('.errorSpan').remove();
            }
        });
    </script>
@endsection
