@extends('layout.websiteLayout')
@section('title')@lang('website.Shopping cart')
@endsection
@section('content')
    <div class="cont-b">
        <div class="breadcrumb-bar wow fadeInUp">
            <strong>@lang('website.Shopping cart')</strong>
            <ol class="breadcrumb">
                <li class="breadcrumb--item"><a href="{{ route(name: 'home') }}">@lang('website.Home')</a></li>
                <li class="breadcrumb--item">@lang('website.Shopping cart')</li>
            </ol>
        </div>
    </div>
    <section class="section_cart_page cartItemsProducts" @if(count($cart) == 0) style="display: none" @endif>
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="cont-cart wow fadeInUp">
                        <p class="cartCount">@lang('website.You have') {{count($cart)}} @lang('website.item in your cart')</p>
                        <div class="head-table">
                            <p>@lang('website.Product')</p>
                            <p>@lang('website.Quantity')</p>
                            <p>@lang('website.subtotal')</p>
                        </div>
                        <div class="prd-cart">
                            @foreach($cart as $onePro)
                                <div class="item-cart row_product_cart_{{$onePro->id}}">
                                    <div class="pdu-tb">
                                        <figure><img src="{{@$onePro->product->image}}" alt="{{@$onePro->product->name}}" /></figure>
                                        <div class="txt-pdu">
                                            <p>{{@$onePro->product->name}}</p>
                                           @if(@$onePro->size_id != '')  <span>@lang('website.Size') : {{@$onePro->size->name}}</span> @endif
                                            @if(@$onePro->color_id != '') <span>@lang('website.Color') : {{@$onePro->color->name}}</span>@endif
                                            <strong>{{number_format(@$onePro->product->price_offer > 0 ? @$onePro->product->price_offer : @$onePro->product->price,3)}} {{@$onePro->product->currency}} </strong>
                                        </div>
                                    </div>
                                    <div class="qty-cart">
                                        <div class="quantity">
                                            <div class="btn button-count dec jsQuantityDecrease @if($onePro->quantity <= 1) disabled @endif"
                                                 data-minimum="1">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </div>
                                            <input type="text"
                                                   name="count-quat1"
                                                   class="count-quat"
                                                   value="{{@$onePro->quantity}}"
                                                   data-max="{{
                   ($onePro->size_id || $onePro->color_id)
                   ? $onePro->product->productColorSizes()
                       ->when($onePro->size_id, fn($q) => $q->where('size_id', $onePro->size_id))
                       ->when($onePro->color_id, fn($q) => $q->where('color_id', $onePro->color_id))
                       ->first()
                       ?->quantity
                   : $onePro->product->remaining_quantity
               }}"
                                                   data-cart-id="{{ $onePro->id }}"
                                                   data-product-id="{{ $onePro->product_id }}"
                                                   data-size-id="{{ $onePro->size_id ?? '' }}"
                                                   data-color-id="{{ $onePro->color_id ?? '' }}">
                                            <div class="btn button-count inc jsQuantityIncrease @if($onePro->quantity >= (($onePro->size_id || $onePro->color_id) ? $onePro->product->productColorSizes()->when($onePro->size_id, fn($q) => $q->where('size_id', $onePro->size_id))->when($onePro->color_id, fn($q) => $q->where('color_id', $onePro->color_id))->first()?->quantity : $onePro->product->remaining_quantity)) disabled @endif">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <a class="remove-tb" data-bs-toggle="modal" data-bs-target="#removeCartModal{{ $onePro->id }}"><i class="icon-trash"></i></a>
                                    </div>
                                    <div class="total-price">
                                        <p>{{ number_format(@$onePro->quantity * (@$onePro->product->price_offer > 0 ? @$onePro->product->price_offer : @$onePro->product->price) ,3)}} {{@$onePro->product->currency}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sec-pay-dtals wow fadeInUp">
                        <h5>@lang('website.Payment Details')</h5>
                        <div class="d-flex justify-content-between">
                            <p>@lang('website.total') </p>

                            <p class="final_total">{{number_format($total_cart, 3)}} {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}</p>
                        </div>
                        <div class="proceed-checkout">
                            @if(auth('web')->check())
                                <a href="{{route('checkOutPage')}}" class="btn-site"><span>@lang('website.Proceed To Checkout')</span></a>
                            @else
                                <a data-bs-toggle="modal"  data-bs-target="#modalSign"  class="btn-site"><span>@lang('website.Proceed To Checkout')</span></a>

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--section_cart_page-->

    <section class="section_cart_page NoItemsProducts" @if(count($cart) > 0) style="display: none" @endif>
        <div class="container">
            <div class="cont-empty wow fadeInUp">
                <figure><i class="icon-cart"></i></figure>
                <h5>@lang('website.Empty Cart')</h5>
                <p>@lang('website.text_cart')</p>
            </div>
        </div>
    </section>

    <!--section_cart_page-->
    @foreach($cart as $onePro)
    <div class="modal fade"  data-bs-toggle="modal" id="removeCartModal{{ $onePro->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-succes-sign">
                        <h3>@lang('website.Remove Item From Cart')</h3>
                        <p>@lang('website.Are You Sure Want To Remove Product From Cart')</p>
                        <ul>
                            <li><a class="btn-site btn-cancel" data-bs-dismiss="modal"
                                   aria-label="Close"><span>@lang('website.no')</span></a></li>
                            <li><a class="btn-site removeFromCartInside" data-cart_id="{{ @$onePro->id }}"  data-product_id="{{ @$onePro->product_id }}" data-product_color_size_id="{{ @$onePro->product_color_size_id }}" data-bs-dismiss="modal" aria-label="Close"><span>@lang('website.yes')</span></a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalSign" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="cont-sign">
                        <div class="head-sign">
                            <h5>@lang('website.Login into your Account')</h5>
                        </div>
                        <form class="form-group"  id="loginForm">
                            @csrf
                            <div id="login-error-msg" style="color:red;"></div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="@lang('website.Email Address')*" />
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="@lang('website.Password')*" />
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
{{--                                    <li><a href="{{ route('login.social', 'facebook') }}"><i class="icon icon-facebook"></i></a></li>--}}
                                    <li><a href="{{ route('signUpGoogle') }}"><i class="icon icon-google"></i></a></li>
                                    <li><a href="{{route('signUpApple')}}"><i class="icon icon-apple"></i></a></li>
                                </ul>
                            </div>
                            <div class="cont-have-acc">
                                <p>@lang('website.Don’t have an account')</p>
                                <a href="{{route('signUp')}}" class="btn-site"><span>@lang('website.signup')</span></a>
                                <br>
                                <a href="{{route('checkOutPage')}}" class="btn-site"><span>@lang('website.Continue as a Guest')</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('#loginForm input[name="email"], #loginForm input[name="password"]').on('input', function () {
            $('#login-error-msg').fadeOut();
        });

        $('#loginForm').on('submit', function (e) {
            e.preventDefault();

            var form = $(this);

            grecaptcha.ready(function () {
                grecaptcha.execute('{{ env("RECAPTCHA_SITE_KEY", "6LeqtR0rAAAAAKMziyF9l1Vc8wHwO7q_9ikGVdvU") }}', {action: 'login'}).then(function (token) {
                    // إضافة رمز reCAPTCHA للنموذج
                    if (form.find('input[name="recaptcha_token"]').length === 0) {
                        form.append('<input type="hidden" name="recaptcha_token" value="' + token + '">');
                    } else {
                        form.find('input[name="recaptcha_token"]').val(token);
                    }

                    var formData = form.serialize();

                    $.ajax({
                        url: '{{ route("loginPopUp") }}',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            } else {
                                $('#loginForm')[0].reset();
                                window.location.href = '{{ route('checkOutPage') }}';
                            }
                        },
                        error: function (xhr) {
                            var errorBox = $('#login-error-msg');
                            var errorMessage = '{{ __("website.login_error") }}';

                            if (xhr.status === 422) {
                                errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                            } else if (xhr.status === 400) {
                                errorMessage = xhr.responseJSON.error || errorMessage;
                            }

                            errorBox.text(errorMessage).fadeIn();
                        }
                    });
                });
            });
        });

    });


    $(document).on('click', '.removeFromCartInside', function (e) {
        e.preventDefault();
        var ele = $(this);
        var cart_id = ele.data('cart_id');
        var product_id = ele.data('product_id');
        var product_color_size_id = ele.data('product_color_size_id');

        var data = { 'product_id': product_id };
        if (product_color_size_id) {
            data['product_color_size_id'] = product_color_size_id;
        }

        $.ajax({
            url: '{{route('deleteProductCart')}}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: data,
            success: function (response) {
                if (response.status == true) {
                    $("#removeCartModal"+cart_id).modal('hide');
                    $('.final_total').html(response.final_total+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                    $('.row_product_cart_'+cart_id).fadeOut(500, function () {
                        ele.remove();
                    });
                    $(".cartCount").html('@lang("website.You have") ' + response.count_products + ' @lang("website.item in your cart")');

                    if(response.count_products == 0){
                        $(".cartItemsProducts").hide();
                        $(".NoItemsProducts").show();
                    }else{

                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('website.Error') }}",
                        text: response.message || "{{ __('website.Something went wrong') }}",
                        confirmButtonText: '@lang("website.OK")'
                    });
                }
            },
            error: function (jqXHR, error, errorThrown) {
                var errorMessage = jqXHR.responseJSON && jqXHR.responseJSON.message
                    ? jqXHR.responseJSON.message
                    : "{{ __('website.Something went wrong') }}";
                Swal.fire({
                    icon: 'error',
                    title: "{{ __('website.Error') }}",
                    text: errorMessage,
                    confirmButtonText: '@lang("website.OK")'
                });
            }
        });
    });

    /* Quantity Increase */
    $(document).on('click', '.jsQuantityIncrease', function(e) {
        e.preventDefault();
        let $input = $(this).siblings('.count-quat');
        let currentVal = parseInt($input.val()) || 1;
        let maxVal = parseInt($input.data('max')) || 0;

        if (maxVal === 0) {
            Swal.fire({
                icon: 'error',
                title: "{{ __('website.Error') }}",
                text: "{{ __('website.No stock available') }}",
                confirmButtonText: '@lang("website.OK")'
            });
            return;
        }

        if (currentVal < maxVal) {
            updateQuantity($input, currentVal + 1);
        }
    });

    /* Quantity Decrease*/
    $(document).on('click', '.jsQuantityDecrease', function(e) {
        e.preventDefault();
        let $input = $(this).siblings('.count-quat');
        let currentVal = parseInt($input.val()) || 1;

        if (currentVal > 1) {
            updateQuantity($input, currentVal - 1);
        }
    });

    /* Manual input handling */
    $(document).on('change', '.count-quat', function() {
        let currentVal = parseInt($(this).val()) || 1;
        let maxVal = parseInt($(this).data('max')) || 0;
        let minVal = 1;

        if (maxVal === 0) {
            Swal.fire({
                icon: 'error',
                title: "{{ __('website.Error') }}",
                text: "{{ __('website.notifyMeText1') }}",
                confirmButtonText: '@lang("website.OK")'
            });
            $(this).val(1);
            return;
        }

        if (currentVal > maxVal) {
            currentVal = maxVal;
        } else if (currentVal < minVal) {
            currentVal = minVal;
        }

        updateQuantity($(this), currentVal);
    });

    function updateQuantity($input, newQuantity) {
        let cartId = $input.data('cart-id');
        let productId = $input.data('product-id');
        let sizeId = $input.data('size-id');
        let colorId = $input.data('color-id');
        let maxVal = parseInt($input.data('max'));

        $.ajax({
            url: '{{ route("changeQuantity") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                cart_id: cartId,
                product_id: productId,
                size_id: sizeId,
                color_id: colorId,
                quantity: newQuantity
            },
            success: function(response) {
                if (response.status) {
                    $input.val(newQuantity);

                    let $item = $input.closest('.item-cart');
                    let price = parseFloat($item.find('.txt-pdu strong').text());
                    $item.find('.total-price p').text((newQuantity * price).toFixed(3) + ' ' + '{{@$onePro->product->currency}}');

                    $('.final_total').text(response.final_total + ' ' + "{{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");

                    $input.siblings('.jsQuantityDecrease').toggleClass('disabled', newQuantity <= 1);
                    $input.siblings('.jsQuantityIncrease').toggleClass('disabled', newQuantity >= maxVal);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('website.Error') }}",
                        text: response.message,
                        confirmButtonText: '@lang("website.OK")'
                    });
                }
            },
            error: function(jqXHR) {
                Swal.fire({
                    icon: 'error',
                    title: "{{ __('website.Error') }}",
                    text: jqXHR.responseJSON?.message || "{{ __('website.Something went wrong') }}",
                    confirmButtonText: '@lang("website.OK")'
                });
            }
        });
    }

</script>
@endsection
