@extends('layout.websiteLayout')
@section('title')@lang('website.Checkout')
@endsection
@section('content')
    <div class="cont-b">
        <div class="breadcrumb-bar wow fadeInUp">
            <strong>@lang('website.Checkout')</strong>
            <ol class="breadcrumb">
                <li class="breadcrumb--item"><a href="{{ route(name: 'home') }}">@lang('website.Home')</a></li>
                <li class="breadcrumb--item">@lang('website.Checkout')</li>
            </ol>
        </div>
    </div>
    <section class="section_checkout_page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cont-checkout wow fadeInUp">
                        <div class="head-checkout">
                            <p> {{ count($data['addresses']) }} @lang('website.Saved Address')</p>
                            <a class="btn-site btnReg" data-bs-toggle="modal" data-bs-target="#modalNewAddress"><span>@lang('website.Add New Address')</span></a>
                        </div>
                        <div class="cont-empty"   @if(count($data['addresses'])> 0) style="display: none" @endif>
                            <figure><i class="icon-no-location"></i></figure>
                            <h5>@lang('website.No Saved Address')</h5>
                            <p>@lang('website.We couldn\'t find a saved address in your account')
                                .<br/>@lang('website.Please add or update your address to proceed with your order') .
                            </p>
                        </div>
                        @if (count($data['addresses']) > 0)
                        <div class="all-address">
                            @foreach($data['addresses'] as $address)
                                <div class="item-address-check">
                                <input class="inp-cbx addressId" id="addres{{$address->id}}" name="address_id" value="{{$address->id}}" type="radio" required>
                                <label class="con-che" for="addres{{$address->id}}">
                                    <div class="sec-title">
                                        <strong>{{ @$address->title }}</strong>
                                        <span>{{ @$address->country->name }}</span>
                                        <p>
                                            {{ @$address->city->name }} , {{ @$address->address_line_one }}
                                            @if (@$address->address_line_two != '')
                                                , {{ @$address->address_line_two }}
                                            @endif
                                            @if (@$address->extra_directions != '')
                                                , {{ @$address->extra_directions }}
                                            @endif
                                            @if (@$address->postal_code != '')
                                                , {{ @$address->postal_code }}
                                            @endif
                                        </p>
                                    </div>
                                </label>
                            </div>
                            @endforeach

                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="aside-checkout">
                        <div class="cont-promo wow fadeInUp">
                            <h5>@lang('website.Promo Code')</h5>
                            <form class="form-promo">
                                <div class="form-group">
                                    <input type="text" class="form-control code_name" placeholder="@lang('website.Enter Here')">
                                    <button class="check_code">@lang('website.Apply')</button>
                                </div>
                            </form>
                            <span class="success-promo d-none">@lang('website.Code Applied Successfully') !</span>
                            <span class="wrong-promo d-none">@lang('website.Invalid Promo Code') !</span>
                        </div>
                        <div class="payment-method wow fadeInUp">
                            <h5>@lang('website.Payment Method')</h5>
                            <div class="list-pay">
                                <div class="check--accept knet">
                                    <input class="inp-cbx" id="knet" name="payments" value="1" type="radio" checked="">
                                    <label class="con-che" for="knet">
                                        <div class="sec-title">
                                            <i class="icon icon-knet"></i>
                                            <p>@lang('website.knet')</p>
                                        </div>
                                    </label>
                                </div>
                                <div class="check--accept">
                                    <input class="inp-cbx" id="visa" name="payments" value="2" type="radio">
                                    <label class="con-che" for="visa">
                                        <div class="sec-title">
                                            <i class="icon icon-visa"></i>
                                            <p>@lang('website.Visa')</p>
                                        </div>
                                    </label>
                                </div>
                                <div class="check--accept">
                                    <input class="inp-cbx" id="master-card" name="payments" value="3" type="radio">
                                    <label class="con-che" for="master-card">
                                        <div class="sec-title">
                                            <i class="icon icon-master-card"></i>
                                            <p>@lang('website.Mastercard')</p>
                                        </div>
                                    </label>
                                </div>
                                <div class="check--accept">
                                    <input class="inp-cbx" id="apple-pay" name="payments" value="4" type="radio">
                                    <label class="con-che" for="apple-pay">
                                        <div class="sec-title">
                                            <i class="icon icon-apple-pay"></i>
                                            <p>@lang('website.Apple pay')</p>
                                        </div>
                                    </label>
                                </div>
                                <div class="check--accept">
                                    <input class="inp-cbx" id="sumsung-pay" name="payments"  value="5" type="radio">
                                    <label class="con-che" for="sumsung-pay">
                                        <div class="sec-title">
                                            <i class="icon icon-sumsung-pay"></i>
                                            <p>@lang('website.Samsung pay')</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="tot-cart wow fadeInUp">
                            <h5>@lang('website.Payment Details')</h5>
                            <div class="d-flex justify-content-between">
                                <p>@lang('website.subtotal')</p>

                                <p class="total_price">{{number_format($data['total_cart'], 3)}} {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>@lang('website.Discount')</p>
                                <p class="discount_amount">0.000 {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>@lang('website.Delivery fees')</p>
                                <p class="delivery_fees">0.000 {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}</p>
                            </div>
                            <div class="d-flex justify-content-between d-total">
                                <p>@lang('website.total')</p>
                                <p class="final_total">{{number_format($data['total_cart'], 3)}} {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}</p>
                            </div>
                            <div class="proceed-checkout">
                                <a class="btn-site send_form" data-bs-toggle="modal" ><span>@lang('website.Proceed to Pay')</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--section_checkout_page-->
    <div class="modal fade" id="modalNewAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
         role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>@lang('website.Add Address')</h3>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <form class="form-address" id="addressForm">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="@lang('website.Address Title')"
                                   name="address_title" required/>
                        </div>
                        <div class="form-group">
                            <select class="form-control form-select country_id" name="country_id" id="country_id"
                                    required>
                                @foreach($data['countries'] as $oneCountry)
                                    <option value="{{$oneCountry->id}}">{{$oneCountry->name}}</option>
                                @endforeach
                            </select>
                            <span id="shipping_content_kuwait">{{ @$setting->shipping_content_kuwait }}</span>
                            <span id="shipping_content_outside_kuwait">{{ @$setting->shipping_content_outside_kuwait}}</span>
                        </div>
                        <div class="form-group">
                            <select class="form-control form-select city_id" name="city_id" id="city_id" required>
                                <option value="">@lang('website.Select City')</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="address_line_one"
                                   placeholder="@lang('website.Block, Street Avenue')"
                                   name="address_line_one" required/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="address_line_two"
                                   placeholder="@lang('website.Apartment, suite, etc') (@lang('website.Optional'))"
                                   name="address_line_two"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="postalCode"
                                   placeholder="@lang('website.Postal Code') (@lang('website.Optional'))"
                                   name="postal_code"/>
                        </div>
                        <div class="form-group">
                        <textarea class="form-control" id="extra_directions"
                                  placeholder="@lang('website.Extra Directions') (@lang('website.Optional'))"
                                  name="extra_directions"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn-site submitAddress"><span>@lang('website.Add')</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPaymet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Add Card</h3>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="inf-payment">
                        <p>Your payment information is safe with us!</p>
                        <ul>
                            <li><i class="icon icon-visa"></i></li>
                            <li><i class="icon icon-master-card"></i></li>
                        </ul>
                    </div>
                    <form class="form-payment">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Card holder name" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Card number" />
                        </div>
                        <div class="d-flex">
                            <div class="date-card">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="mm" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="yy" />
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="CVV" />
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn-site"><span>Add</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $(".knet").addClass("d-none");
            $("input[name='payments']").prop("checked", false);

            function setupCountryChangeHandler(formSelector) {
                $(formSelector + " .country_id").on("change", function () {
                    var countryId = $(this).val();
                    var citySelect = $(formSelector + " .city_id");
                    var addressLineOne = $(formSelector + " #address_line_one");
                    var addressLineTwo = $(formSelector + " #address_line_two");
                    var postalCodeField = $(formSelector + " #postalCode");
                    var savedCityId = citySelect.data('selected'); // Get the saved city ID

                    if (countryId) {
                        $.ajax({
                            url: "{{ route('get.cities') }}",
                            type: "POST",
                            data: {
                                country_id: countryId,
                                _token: $('input[name="_token"]').val()
                            },
                            success: function (response) {
                                citySelect.empty();

                                if (countryId == 1) { // Assuming country ID 1 is Kuwait
                                    citySelect.append('<option value="">@lang("website.Select Area")</option>');
                                    $(formSelector + " #shipping_content_kuwait").show();
                                    $(formSelector + " #shipping_content_outside_kuwait").hide();
                                    addressLineOne.attr("placeholder", "@lang('website.Block, Street Avenue')");
                                    addressLineTwo.attr("placeholder", "@lang('website.Apartment, suite, etc') (@lang('website.Optional'))");
                                    postalCodeField.parent('.form-group').hide();
                                } else {
                                    citySelect.append('<option value="">@lang("website.Select City")</option>');
                                    $(formSelector + " #shipping_content_kuwait").hide();
                                    $(formSelector + " #shipping_content_outside_kuwait").show();
                                    addressLineOne.attr("placeholder", "@lang('website.address_line_one')");
                                    addressLineTwo.attr("placeholder", "@lang('website.address_line_two') (@lang('website.Optional'))");
                                    postalCodeField.parent('.form-group').show();
                                }

                                // Populate cities
                                $.each(response.cities, function (key, city) {
                                    citySelect.append('<option value="' + city.id + '">' + city.name + '</option>');
                                });

                                // Set the saved city value after cities are populated
                                if (savedCityId && $(formSelector + " .country_id").data("initial-load") === true) {
                                    citySelect.val(savedCityId);
                                    $(formSelector + " .country_id").removeData("initial-load"); // Clear flag after initial load
                                }
                            },
                            error: function (xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    } else {
                        citySelect.empty();
                        citySelect.append('<option value="">@lang("website.Select City")</option>');
                        $(formSelector + " #shipping_content_kuwait").hide();
                        $(formSelector + " #shipping_content_outside_kuwait").hide();
                        addressLineOne.attr("placeholder", "@lang('website.Block, Street Avenue')");
                        addressLineTwo.attr("placeholder", "@lang('website.Apartment, suite, etc')");
                        postalCodeField.parent('.form-group').show();
                    }
                });
            }

            setupCountryChangeHandler("#modalNewAddress");
            $("#modalNewAddress .country_id").trigger("change");

            $(document).on('click', 'input,select,textarea,.select2', function () {
                $(this).attr('style', "").next('span.errorSpan').remove();
            });

            $(document).on('click', '.submitAddress', function (e) {
                e.preventDefault();
                var preventSubmit = false;

                $('#addressForm').find('select, textarea, input').each(function () {
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

                $('.submitAddress span').html('<i class="fa fa-spinner fa-spin" style="font-size: 20px;position: initial;color:black;"></i>');
                $(".submitAddress").attr("disabled", true);

                $.ajax({
                    url: "{{ route('addAddress') }}",
                    type: "POST",
                    data: new FormData($('#addressForm')[0]),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.code == 300) {
                            $("#addressForm").find("input, textarea, select").val("");
                            $(".submitAddress").attr("disabled", false);
                            $(".submitAddress").html("<span>@lang('website.Add')</span>");
                            $("#modalNewAddress").modal("hide");
                            location.reload();
                            return;
                        } else if (response.validator != null) {
                            Swal.fire({
                                icon: 'error',
                                title: '@lang("website.Error")',
                                text: response.validator,
                                confirmButtonText: '@lang("website.OK")'
                            });
                            $(".submitAddress").attr("disabled", false);
                            $(".submitAddress").html("<span>@lang('website.Add')</span>");
                        } else if (response.code == 201) {
                            Swal.fire({
                                icon: 'error',
                                title: '@lang("website.sorry")',
                                text: response.message,
                                confirmButtonText: '@lang("website.OK")'
                            });
                            $(".submitAddress").attr("disabled", false);
                            $(".submitAddress").html("<span>@lang('website.Add')</span>");
                        }
                    },
                    error: function (xhr) {
                        handleAjaxError(xhr, $('.submitAddress'), "@lang('website.Add')");
                    }
                });
            });

            function handleAjaxError(xhr, buttonElement, buttonText) {
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

                buttonElement.attr("disabled", false);
                buttonElement.html("<span>" + buttonText + "</span>");
            }
        });

        $(document.body).on("change", ".addressId", function (e) {
            var address_id = null;
            var country_id = null;
            var city_id = null;
            var auth_check = @json(auth()->check());

            if ( auth_check ) {
                address_id = $('input[name="address_id"]:checked').val();
            } else {
                country_id = $('select[name="country_id"]').val();
                city_id = $('select[name="city_id"]').val();
            }

            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{route('getDeliveryCost')}}',
                method: "get",
                data: {
                    country_id : country_id,
                    city_id : city_id,
                    address_id : address_id,
                    code_name:$('.code_name').val().trim(),
                },
                success: function (response) {
                    if(response.code ==200){
                        $('.total_price').html(response.total_cart+' '+" {{Session::get('country_currency') != '' ?__('website.'.Session::get('country_currency')) : __('website.KWD')}}");
                        $('.final_total').html(response.final_total+' '+" {{Session::get('country_currency') != '' ?__('website.'.Session::get('country_currency')) : __('website.KWD')}}");
                        $('.delivery_fees').html(response.delivery_charge+' '+" {{Session::get('country_currency') != '' ?__('website.'.Session::get('country_currency')) : __('website.KWD')}}");
                        $('.discount_amount').html(response.discount+' '+" {{Session::get('country_currency') != '' ?__('website.'.Session::get('country_currency')) : __('website.KWD')}}");

                        if (response.country_id == 1) { // Assuming country ID 1 is Kuwait
                            $(".knet").removeClass("d-none");
                            $("input[name='payments']").prop("checked", false); // Uncheck all payment methods
                            $("#knet").prop("checked", true); // Select KNET
                        } else {
                            $(".knet").addClass("d-none");
                            $("input[name='payments']").prop("checked", false); // Uncheck all payment methods
                            $("#visa").prop("checked", true); // Select Visa
                        }
                        return ;

                    } else if(response.code==201){
                        Swal.fire({
                            icon: 'error',
                            title: '@lang("website.sorry")',
                            text: response.message,
                            confirmButtonText: '@lang("website.OK")'
                        });
                    } else{

                    }
                }

            });

        });
    </script>
@endsection
