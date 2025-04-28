@extends('layout.websiteLayout')
@section('title')
    @lang('website.Checkout')
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
                            <p>@lang('website.Continue as a Guest')</p>
                        </div>
                        <form class="form-checkout" id="formCheckout">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="d-flex">
                                <div class="form-group">
                                    <input type="text" id="full_name"  class="form-control" placeholder="@lang('website.Full name')*" required/>
                                </div>
                                <div class="form-group">
                                    <input type="email" id="email" class="form-control"
                                           placeholder="@lang('website.Email Address')*" required/>
                                </div>
                                <div class="form-group d-flex">
                                    <select class="form-control form-select" id="introduction" name="introduction"
                                            required>
                                        <option value="965" {{ old('introduction')=='965' ? 'selected' : '' }}>+965
                                        </option>
                                        <option value="966" {{ old('introduction')=='966' ? 'selected' : '' }}>+966
                                        </option>
                                        <option value="968" {{ old('introduction')=='968' ? 'selected' : '' }}>+968
                                        </option>
                                        <option value="971" {{ old('introduction')=='971' ? 'selected' : '' }}>+971
                                        </option>
                                        <option value="973" {{ old('introduction')=='973' ? 'selected' : '' }}>+973
                                        </option>
                                        <option value="974" {{ old('introduction')=='974' ? 'selected' : '' }}>+974
                                        </option>
                                    </select>
                                    <input type="number" class="form-control" id="mobile"
                                           placeholder="@lang('website.Mobile Number')*"
                                           onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="form-control form-select country_id "  name="country_id" id="country_id"
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
                                <input type="text" class="form-control" id="address_line_one" placeholder="@lang('website.Block, Street Avenue')"
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
                        </form>
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
                                <div class="check--accept">
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
                                    <input class="inp-cbx" id="sumsung-pay" name="payments" value="5" type="radio">
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
                                <p class="discount_amount">
                                    0.000 {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>@lang('website.Delivery fees')</p>
                                <p class="delivery_fees">
                                    0.000 {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}</p>
                            </div>
                            <div class="d-flex justify-content-between d-total">
                                <p>@lang('website.total')</p>
                                <p class="final_total">{{number_format($data['total_cart'], 3)}} {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}</p>
                            </div>
                            <div class="proceed-checkout">
                                <a class="btn-site send_form" data-bs-toggle="modal"><span>@lang('website.Proceed to Pay')</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--section_checkout_page-->

@endsection
@section('js')
<script>
    $(document).ready(function () {
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

        setupCountryChangeHandler("#formCheckout");
        $("#formCheckout .country_id").trigger("change");

        $(document.body).on("change", ".country_id, .city_id", function (e) {

            country_id = $('select[name="country_id"]').val();
            city_id = $('select[name="city_id"]').val();

            if (country_id == 1 &&  city_id == '') {
                return ;
            }else if(country_id == '' &&  city_id == ''){
                return ;
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
                    code_name:$('.code_name').val().trim(),
                },
                success: function (response) {
                    if(response.code ==200){
                        $('.total_price').html(response.total_cart+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                        $('.final_total').html(response.final_total+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                        $('.delivery_fees').html(response.delivery_charge+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                        $('.discount_amount').html(response.discount+' '+" {{Session::get('currency') != '' ?__('website.'.Session::get('currency')) : __('website.KWD')}}");
                        return ;

                    } else if(response.code==201){
                        $('.errorTextModal').empty();
                        $('.errorTextModal').append(response.message);
                        $('#modalError').modal('show');

                    } else{
                        Swal.fire({
                            icon: 'error',
                            title: '@lang("website.sorry")',
                            confirmButtonText: '@lang("website.OK")'
                        });
                    }
                }

            });

        });


        // Add input event to clear error messages on input
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(function (input) {
            input.addEventListener('input', function () {
                $(this) .css({
                    "background": "",
                    "margin-bottom": ""
                });
                $(this).next('span.errorSpan').remove()
            });
        });
    });


</script>
@endsection
