<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{(app()->getLocale() == 'ar') ? 'rtl' : 'ltr'}}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('seo_meta')
    <title>{{$setting->title}} | @yield('title')</title>

    <!-- Stylesheets -->
    <link rel="icon" href="{{ asset('website_assets/images/favicon.svg') }}">
    <link href="{{ asset('website_assets/css/style.css') }}" rel="stylesheet">
    <!-- Responsive -->
    <link href="{{ asset('website_assets/css/responsive.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--[if lt IE 9]>
    <script src="js/respond.js"></script><![endif]-->
    <script src="{{ asset('website_assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('css')

    {!!@$setting->seo_in_header!!}

</head>

<body>

{!!@$setting->seo_in_body!!}

<div class="aside-menu">
    <div class="head-menu">
        <h5>@lang('website.Menu')</h5>
        <span class="close-menu"><i class="fa-solid fa-xmark"></i></span>
    </div>
    <ul class="main-menu">
        @if(@$categoriesMenu->where('department' , 'man')->count() > 0)
            <li>
                <a class="dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">@lang('website.Men')</a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                    @foreach( $categoriesMenu->where('department' , 'man') as $menCategory)
                        @if(count(@$menCategory->subcategories) > 0)

                            <li>
                                <a class="dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">{{@$menCategory->name}}</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach($menCategory->subcategories as $oneSubMen)
                                        <li><a href="{{route('products' , $oneSubMen->id)}}">{{$oneSubMen->name}}</a></li>
                                    @endforeach

                                </ul>
                            </li>
                        @else
                            <li><a href="{{route('products' , $menCategory->id)}}">{{@$menCategory->name}}</a></li>
                        @endif
                    @endforeach

                </ul>
            </li>
        @endif

        @if(@$categoriesMenu->where('department' , 'women')->count() > 0)
            <li>
                <a class="dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">@lang('website.Women')</a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                    @foreach( $categoriesMenu->where('department' , 'women') as $womenCategory)
                        @if(count(@$womenCategory->subcategories) > 0)

                            <li>
                                <a class="dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">{{@$womenCategory->name}}</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach($womenCategory->subcategories as $oneSubWomen)
                                        <li><a href="{{route('products' , $oneSubWomen->id)}}">{{$oneSubWomen->name}}</a></li>
                                    @endforeach


                                </ul>
                            </li>
                        @else
                            <li><a href="{{route('products' , $womenCategory->id)}}">{{@$womenCategory->name}}</a></li>
                        @endif
                    @endforeach

                </ul>
            </li>
        @endif

        <li><a href="{{ route('pages', 'about-us') }}">@lang('website.About Us')</a></li>
        <li><a href="{{ route('contactUs') }}">@lang('website.Contact')</a></li>
        <li>
            <a class="dropdown-toggle currency" id="navbarDropdown" data-bs-toggle="dropdown"
               aria-expanded="false">@lang('website.Currency')
                <span>{{ __('website.' . (Session::has('currency') && Session::get('currency') ? Session::get('currency') : 'KWD')) }}</span></a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a href="{{route('changeCurrency','KWD')}}">@lang('website.KWD')</a></li>
                <li><a href="{{route('changeCurrency','BHD')}}">@lang('website.BHD')</a></li>
                <li><a href="{{route('changeCurrency','OMR')}}">@lang('website.OMR')</a></li>
                <li><a href="{{route('changeCurrency','QAR')}}">@lang('website.QAR')</a></li>
                <li><a href="{{route('changeCurrency','SAR')}}">@lang('website.SAR')</a></li>
                <li><a href="{{route('changeCurrency','AED')}}">@lang('website.AED')</a></li>
            </ul>
        </li>
        <li>
            @if(app()->getLocale() == 'en')
                    <?php
                    $lang = LaravelLocalization::getSupportedLocales()['ar']
                    ?>
                <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                    <i class="icon-lang"></i>
                    {{ $lang['native'] }}
                </a>
            @else
                    <?php
                    $lang = LaravelLocalization::getSupportedLocales()['en']
                    ?>
                <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                    <i class="icon-lang"></i>
                    {{ $lang['native'] }}
                </a>
            @endif
        </li>
    </ul>
</div>

<div class="main-wrapper">

    <header id="header">
        <div class="container-fluid">
            <div class="menu_srch">
                <div class="hamburger">
                    <a class=""><i class="icon-menu"></i> <span>@lang('website.Menu')</span></a>
                </div>
                <form class="form-search" method="get" action="{{route('search')}}">
                    <div class="form-group">
                        <input type="text" name="name" value="{{request('name')?request('name'):''}}" class="form-control" placeholder="@lang('website.Search')"/>
                        <span><button type="submit" class="btn-search"><i class="icon-search"></i></button></span>
                    </div>
                </form>
                <div class="search-mobile">
                    <i class="icon-search"></i>
                </div>
            </div>
            <div class="logo_site">
                <a href="{{route('home') }}">
                    <img src="{{ asset('website_assets/images/logo.svg') }}" alt=""/>
                </a>
            </div>
            <ul class="menu_acc">
                <li><a class="page-scroll" href="{{route('cart')}}"><i class="icon-cart"></i> <span>@lang('website.Cart')</span></a>
                </li>
                @if(auth('web')->check())
                    <li><a class="page-scroll" href="{{ route('myAccount') }}"><i class="icon-user"></i>
                            <span>@lang('website.my_account') </span></a></li>
                @else
                    <li><a class="page-scroll" href="{{ route('signIn') }}"><i class="icon-user"></i>
                            <span>@lang('website.Signin/Signup')</span></a></li>
                @endif
            </ul>
        </div>
    </header>
    <!--header-->

    @yield('content')



    <footer id="footer">
        <div class="top-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="cont-ft wow fadeInUp">
                            <figure class="logo-ft">
                                <img src="{{ asset('website_assets/images/logo.svg') }}" alt="{{@$setting->title }}"
                                     class="img-fluid">
                            </figure>
                            <a href="{{@$setting->instagram}}" target="_blank"><i
                                    class="fa-brands fa-instagram"></i></a>
                            <p>{{ @$setting->instagram_text_footer}}</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="menu-ft wow fadeInUp">
                            <h5>@lang('website.About')</h5>
                            <ul class="lst-ft">
                                <li><a href="{{ route('pages', 'about-us') }}">@lang('website.About Us')</a></li>
                                <li><a href="{{ route('pages', 'return-policy') }}">@lang('website.Return policy')</a>
                                </li>
                                <li><a href="{{ route('faqs') }}">@lang('website.Faqs')</a></li>
                                <li>
                                    <a href="{{ route('pages', 'special-order-policy') }}">@lang('website.Special- Order policy') </a>
                                </li>
                                <li>
                                    <a href="{{ route('pages', 'terms-and-conditions') }}">@lang('website.Terms & Conditions')</a>
                                </li>
                                <li><a href="{{ route('pages', 'privacy-policy') }}">@lang('website.Privacy policy')</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="menu-ft wow fadeInUp">
                            <h5>@lang('website.Contact')</h5>
                            <a href="{{ @$setting->map_location_pinpoint }}" target="_blank"> <p>{{ @$setting->address }}</p></a>
                            <ul class="list-contact">
                                <li>
                                    <a href="mailto:{{ @$setting->info_email }}" target="_blank">
                                        <span><i class="icon-envelope"></i></span> {{ @$setting->info_email }}
                                    </a>
                                </li>
                                <li>
                                    <a href="tel:{{ @$setting->mobile }}" target="_blank">
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
                    <div class="col-lg-3">
                        <div class="menu-ft menu-subscribe wow fadeInUp">
                            <h5>@lang('website.SUBSCRIBE NOW')</h5>
                            <p>@lang('website.Subscribe for exclusive content and updates!')</p>
                            <form class="form-subscribe" id="subscribeForm" novalidate>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email"
                                           placeholder="@lang('website.Enter your email')" required/>
                                    <input type="hidden" id="recaptchaToken" name="recaptcha_token">
                                    <button>@lang('website.Subscribe')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-ft">
            <div class="container-fluid">
                <div class="cont-bt wow fadeInUp">
                    <p class="copyRight">@lang('website.Copyright') © {{date('Y')}} {{$setting->title}}
                        - @lang('website.allRightsReserved')</p>
                    <p>Powered By <a href="https://linekw.com/">Line</a></p>
                </div>

            </div>
        </div>
    </footer>
    <!--footer-->
    <div class="modal fade" id="modalSuccessRegSubscribtion" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-succes-sign">
                        <h3>@lang('website.Success')</h3>
                        <p>@lang('website.Subscription successful')</p>
                        <a class="btn-site" data-bs-dismiss="modal" aria-label="Close"><span>@lang('website.OK')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalFavoriteLogin" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-succes-sign">
                        <h3>@lang('website.Sorry')</h3>
                        <p>@lang('website.youcannotaddfavorite').</p>
                        <a href="{{route('signIn')}}" class="btn-site" data-bs-dismiss="modal"
                           aria-label="Close"><span>@lang('website.login')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-succes-sign">
                        <h3>@lang('website.Sorry')</h3>
                        <p class="errorTextModal"></p>
                        <a class="btn-site" data-bs-dismiss="modal" aria-label="Close"><span>@lang('website.OK')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="{{ asset('website_assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('website_assets/js/all.min.js') }}"></script>
<script src="{{ asset('website_assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('website_assets/js/wow.js') }}"></script>
<script src="{{ asset('website_assets/js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('website_assets/js/script.js') }}"></script>
<script>
    new WOW().init();
</script>
@yield('js')
<script>

    document.querySelectorAll('.dropdown-menu .dropdown-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation(); // تمنع إغلاق الدروب داون الرئيسي
            this.nextElementSibling.classList.toggle('show'); // تفتح / تغلق القائمة الفرعية
        });
    });

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#subscribeForm').on('submit', function (e) {
            e.preventDefault();
            $('.errorTextModal').empty();
            var form = $(this);
            var preventSubmit = false;

            form.find('.errorSpan').remove();
            form.find('select, textarea, input') .css({
                "background": "",
                "margin-bottom": ""
            });

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
                return;
            }

            // استخدام reCAPTCHA قبل إرسال النموذج
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ env("RECAPTCHA_SITE_KEY", "6LeqtR0rAAAAAKMziyF9l1Vc8wHwO7q_9ikGVdvU") }}', {action: 'subscribe'}).then(function(token) {
                    // إضافة رمز reCAPTCHA للنموذج
                    if(form.find('input[name="recaptcha_token"]').length === 0) {
                        form.append('<input type="hidden" name="recaptcha_token" value="' + token + '">');
                    } else {
                        form.find('input[name="recaptcha_token"]').val(token);
                    }

                    var formData = form.serialize();

                    $.ajax({
                        url: '{{ route("subscribe") }}',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                $('#modalSuccessRegSubscribtion').modal('show');
                                $('#subscribeForm')[0].reset();
                            } else if (response.code === 201) {
                                $('.errorTextModal').append(response.error);
                                $('#modalError').modal('show');

                            } else {
                                $('.errorTextModal').append(response.message);
                                $('#modalError').modal('show');

                            }
                        },
                        error: function (xhr) {
                            var errorMessage = '{{ __("website.subscription_error") }}';
                            if (xhr.status === 422) {
                                errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                            } else if (xhr.status === 500) {
                                errorMessage = 'Error';
                            }
                            $('.errorTextModal').append(errorMessage);
                            $('#modalError').modal('show');
                        }
                    });
                });
            });
        });

        // Add from favorite
        $(document).on('click', '.addToFavorite', function (e) {
            e.preventDefault();

            @if(!auth('web')->check())
            $('#modalFavoriteLogin').modal('show');
            return false;
            @endif

            var $elem = $(this);
            var productId = $elem.data('product_id');

            $.ajax({
                url: '{{ route("addToFavorite") }}',
                type: "POST",
                data: {
                    product_id: productId
                },
                success: function (response) {
                    if (response.status === true) {
                        // Update classes
                        $elem.removeClass('addToFavorite').addClass('removeFromFavorite');
                        // Replace the icon completely
                        $elem.html('<i class="fa-solid fa-heart">');
                    } else {
                        $('.errorTextModal').empty();
                        $('.errorTextModal').append(response.message);
                        $('#modalError').modal('show');
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("website.Error") }}',
                        text: 'An error occurred while adding to favorites.',
                        confirmButtonText: '@lang("website.OK")'
                    });
                }
            });
        });

        // Remove from favorite
        $(document).on('click', '.removeFromFavorite', function (e) {
            e.preventDefault();
            var $elem = $(this);
            var productId = $elem.data('product_id');

            $.ajax({
                url: '{{ route("removeFavorite") }}',
                type: "POST",
                data: {
                    product_id: productId
                },
                success: function (response) {
                    if (response.status === true) {
                        // Update classes
                        $elem.removeClass('removeFromFavorite').addClass('addToFavorite');
                        // Replace the icon completely
                        $elem.html('<i class="fa-regular fa-heart">');
                    } else {
                        $('.errorTextModal').empty();
                        $('.errorTextModal').append(response.message);
                        $('#modalError').modal('show');
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("website.Error") }}',
                        text: 'An error occurred while removing from favorites.',
                        confirmButtonText: '@lang("website.OK")'
                    });
                }
            });
        });
    });

    ///////// if the input search empty not clicable
    document.querySelector('.form-search').addEventListener('submit', function(e) {
        if (this.querySelector('input[name=name]').value.trim() === '') {
            e.preventDefault();
        }
    });

    /////// for loader and paginage
    $(document).ready(function () {
        var csrf_token = '{{csrf_token()}}';
        page = 1;
        noAjaxInUse = true;

        $(window).scroll(function () {
            if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight - 200)) {
                if (page !== 0 && noAjaxInUse) {
                    page++;
                    loadMoreData(page);
                }
            }
        });

        function loadMoreData(page1) {
            noAjaxInUse = false;
            var char;
            if (window.location.search === "") {
                char = "?";
            } else {
                char = window.location.href + "&";
            }

            // Show the loader before making the AJAX request
            $('.loader').show();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                url: char + 'page=' + page1,
                method: "get",
                data: {},
                beforeSend: function () {
                    // You already have this, but using loader instead
                    $('.ajax-load').hide();
                }
            })
                .done(function (data) {
                    // Hide the loader when the request is complete
                    $('.loader').hide();
                    $('.ajax-load').hide();

                    $("#products").append(data.html);

                    if (data.is_more === "no") {
                        $('.ajax-load').hide();
                        page = 0;
                        return;
                    }
                    noAjaxInUse = true;
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    $('.loader').hide();
                    return false;
                });
        }
    });
    $('.code_name').on('input', function() {
        $(".success-promo").hide().addClass("d-none");
        $(".wrong-promo").hide().addClass("d-none");
    });

    $(document).on('click', '.check_code', function (e) {
        e.preventDefault();
        var ele = $(this);
        var codeName = $('.code_name').val().trim();
        if (!codeName) {
            return;
        }

        var address_id = null;
        var country_id = null;
        var city_id = null;
        var auth_check = @json(auth()->check());

        if (auth_check) {
            address_id = $('input[name="address_id"]:checked').val();
            if (!address_id) {
                $('.errorTextModal').empty();
                $('.errorTextModal').append("@lang('website.address_required')");
                $('#modalError').modal('show');
                return;
            }
        } else {
            country_id = $('select[name="country_id"]').val();
            city_id = $('select[name="city_id"]').val();
            if (!country_id) {
                $('.errorTextModal').empty();
                $('.errorTextModal').append("@lang('website.country_required')");
                $('#modalError').modal('show');
                return;
            }
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{route('checkPromo')}}',
            method: "post",
            data: {
                code_name: codeName,
                address_id: address_id,
                country_id: country_id,
                city_id: city_id,
            },
            success: function (response) {
                if(response.code == 200){
                    $('.total_price').html(response.total_cart+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                    $('.final_total').html(response.final_total+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                    $('.delivery_fees').html(response.delivery_charge+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                    $('.discount_amount').html(response.discount+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                    $(".success-promo").removeClass("d-none").show();
                    $(".wrong-promo").hide().addClass("d-none");
                    return ;
                } else if(response.code == 201){
                    $('.total_price').html(response.total_cart+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                    $('.final_total').html(response.final_total+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                    $('.delivery_fees').html(response.delivery_charge+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                    $('.discount_amount').html(response.discount+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                    $(".wrong-promo").removeClass("d-none").show();
                    $(".success-promo").hide().addClass("d-none");
                } else {
                    $(".success-promo").hide().addClass("d-none");
                    $(".wrong-promo").hide().addClass("d-none");

                    $('.errorTextModal').empty();
                    $('.errorTextModal').append(response.messages);
                    $('#modalError').modal('show');

                }
            },
            error: function (xhr) {
                $(".success-promo").hide().addClass("d-none");
                $(".wrong-promo").hide().addClass("d-none");
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessages = [];
                    $.each(errors, function (key, value) {
                        errorMessages.push(value[0]);
                    });
                    Swal.fire({
                        icon: 'error',
                        title: '@lang("website.Error")',
                        html: errorMessages.join('<br>'),
                        confirmButtonText: '@lang("website.OK")'
                    });
                } else {
                    var errorMsg = xhr.statusText || '@lang("website.Error occurred. Please try again.")';
                    Swal.fire({
                        icon: 'error',
                        title: '@lang("website.Error")',
                        text: xhr.status + ': ' + errorMsg,
                        confirmButtonText: '@lang("website.OK")'
                    });
                }
            }
        });
    });

    $(document).on('click', '.send_form', function (e) {
        e.preventDefault();
        let preventSubmit = false;
        let form = $('#formCheckout');
        var isAuth = @json(auth('web')->check());


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


        if (preventSubmit) return false;

        let formData = new FormData();

        formData.append('_token', '{{ csrf_token() }}');

        if (isAuth) {
            let addressId = $('input[name="address_id"]:checked').val();
            if (!addressId) {
                $('.errorTextModal').empty();
                $('.errorTextModal').append("@lang('website.noAddress')");
                $('#modalError').modal('show');


                return false;
            }
            formData.append('address_id', addressId);
            formData.append('code_name', $('.code_name').val());

        } else {
            formData.append('name', $('#full_name').val());
            formData.append('email', $('#email').val());
            formData.append('introduction', $('#introduction').val());
            formData.append('mobile', $('#mobile').val());
            formData.append('country_id', $('#country_id').val());
            formData.append('city_id', $('#city_id').val());
            formData.append('address_line_one', $('#address_line_one').val());
            formData.append('address_line_two', $('#address_line_two').val());
            formData.append('postal_code', $('#postalCode').val());
            formData.append('extra_directions', $('#extra_directions').val());
            formData.append('code_name', $('.code_name').val()); // رمز الخصم إن وجد
        }

        formData.append('payment_method', $('input[name="payments"]:checked').val());

        $('.send_form').html('<i class="fa fa-spinner fa-spin" style="font-size: 20px;"></i>');
        $(".send_form").css("pointer-events", "none");



        $.ajax({
            url: '{{ route("checkOut") }}',
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                if (response.code == 200) {
                    if (response.url !== '') {
                        location.href = response.url;
                        $('.send_form').html('<span>{{__("website.Proceed to Pay")}}</span>');
                        $(".send_form").css("pointer-events", "auto");
                    } else {
                        location.reload();
                    }
                } else if (response.validator != null) {
                    $('.errorTextModal').empty();
                    $('.errorTextModal').append(response.validator);
                    $('#modalError').modal('show');


                    $('.send_form').html('<span>{{__("website.Proceed to Pay")}}</span>');
                    $(".send_form").css("pointer-events", "auto");
                } else {
                    $('.errorTextModal').empty();
                    $('.errorTextModal').append(response.message);
                    $('#modalError').modal('show');

                    $('.send_form').html('<span>{{__("website.Proceed to Pay")}}</span>');
                    $(".send_form").css("pointer-events", "auto");
                }
            },
            error: function (xhr) {
                $('.send_form').html('<span>{{__("website.Proceed to Pay")}}</span>');
                $(".send_form").css("pointer-events", "auto");

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


    const inputs = document.querySelectorAll('input, select');

    inputs.forEach(function (input) {
        input.addEventListener('input', function () {
            $(this).css({
                "background": "",
                "margin-bottom": ""
            });

            const form = this.closest('form');
            if (form) {
                const errorSpan = this.nextElementSibling;
                if (errorSpan && errorSpan.classList.contains('errorSpan')) {
                    errorSpan.remove();
                }
            }
        });
    });

</script>
</body>

</html>
