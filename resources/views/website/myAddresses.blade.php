@extends('website.myAccountLayout')
@section('contentMyAccount')

    <div class="col-lg-9">
        <div class="cont-address wow fadeInUp">
            <div class="head-account">
                <p>
                    {{ count($data['addresses']) }} @lang('website.Saved Address')
                </p>
                <a class="btn-site btnReg" data-bs-toggle="modal"
                   data-bs-target="#modalNewAddress"><span>@lang('website.Add New Address')</span></a>
            </div>
            @if (count($data['addresses']) > 0)
                @foreach($data['addresses'] as $address)
                    <div class="item-address row_address_{{ $address->id }}">
                        <div>
                            <strong>{{ @$address->title }}</strong>
                            <span>{{ @$address->country->name }}</span>
                            <p>{{ @$address->city->name }} , {{ @$address->address_line_one }}
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
                        <ul>
                            <li><a href="" class="btn-site btn-delete btnReg" data-bs-toggle="modal"
                                   data-bs-target="#deleteAddressModal{{ @$address->id }}"><span>@lang('website.Delete')</span></a>
                            </li>
                            <li><a class="btn-site addressDetails" data-id="{{$address->id}}"
                                   data-url="{{ route('addressDetails', @$address->id) }}"><span>@lang('website.Edit')</span></a>
                            </li>
                        </ul>
                    </div>
                @endforeach
            @endif
            <div class="cont-orders wow fadeInUp NoAddressesClass"
                 @if(count($data['addresses'])> 0) style="display: none" @endif>
                <div class="cont-empty">
                    <figure><i class="icon-no-location"></i></figure>
                    <h5>@lang('website.No Saved Address')</h5>
                    <p>@lang('website.We couldn\'t find a saved address in your account')
                        .<br/>@lang('website.Please add or update your address to proceed with your order') .
                    </p>
                </div>
            </div>
        </div>
    </div>



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
                            <span
                                id="shipping_content_outside_kuwait">{{ @$setting->shipping_content_outside_kuwait}}</span>
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
    <div class="modal fade" id="modalEditAdress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
         role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>@lang('website.Edit Address')</h3>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <form class="form-address editAdressContent edit_address_form">

                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach($data['addresses'] as $address)
        <div class="modal fade" id="deleteAddressModal{{ @$address->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-modal="true"role="dialog">
            <div class="wsmall modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="content-succes-sign">
                            <h3>@lang('website.Delete')</h3>
                            <p>@lang('website.Are you sure want to delete address')</p>
                            <ul>
                                <li><a class="btn-site btn-cancel" data-bs-dismiss="modal"
                                       aria-label="Close"><span>@lang('website.no')</span></a></li>
                                <li><a class="btn-site removeAddress"
                                       data-address_id="{{@$address->id}}"><span>@lang('website.yes')</span></a></li>
                            </ul>
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

            $(document).on('click', '.addressDetails', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var url = $(this).data('url');

                $.ajax({
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "GET",
                    data: {id: id},
                    success: function (data) {
                        $("#modalEditAdress").modal('show');
                        $(".editAdressContent").html(data.html);

                        setupCountryChangeHandler("#modalEditAdress");

                        $("#modalEditAdress .country_id").data("initial-load", true);
                        $("#modalEditAdress .country_id").trigger("change");
                    }
                });
            });

            $(document).on('click', '.editAddress', function (e) {
                e.preventDefault();
                var address_id = $(this).data("address_id");
                var urlUpdate = '{{ route('updateAddress', ':id') }}'.replace(':id', address_id);

                var preventSubmit = false;

                $('.edit_address_form').find('select, textarea, input').each(function () {
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

                $('.editAddress span').html('<i class="fa fa-spinner fa-spin" style="font-size: 20px;position: initial;color:black;"></i>');
                $(".editAddress").attr("disabled", true);

                $.ajax({
                    url: urlUpdate,
                    type: "POST",
                    data: new FormData($('.edit_address_form')[0]),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.code == 300) {
                            $(".editAddress").attr("disabled", false);
                            $(".editAddress").html("<span>@lang('website.Update')</span>");
                            $("#modalEditAdress").modal("hide");
                            location.reload();
                            return;
                        } else if (response.validator != null) {
                            Swal.fire({
                                icon: 'error',
                                title: '@lang("website.Error")',
                                text: response.validator,
                                confirmButtonText: '@lang("website.OK")'
                            });
                            $(".editAddress").attr("disabled", false);
                            $(".editAddress").html("<span>@lang('website.Update')</span>");
                        } else if (response.code == 201) {
                            Swal.fire({
                                icon: 'error',
                                title: '@lang("website.sorry")',
                                text: response.message,
                                confirmButtonText: '@lang("website.OK")'
                            });
                            $(".editAddress").attr("disabled", false);
                            $(".editAddress").html("<span>@lang('website.Update')</span>");
                        }
                    },
                    error: function (xhr) {
                        handleAjaxError(xhr, $('.editAddress'), "@lang('website.Update')");
                    },
                    servedError(xhr) {
                        handleAjaxError(xhr, $('.editAddress'), "@lang('website.Update')");
                    }
                });
            });

            $(document).on('click', '.removeAddress', function (e) {
                e.preventDefault();
                var address_id = $(this).data("address_id");
                $.ajax({
                    url: '{{url(app()->getLocale().'/deleteAddress')}}' + '/' + address_id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'get',
                    success: function (response) {
                        if (response.status == true) {
                            $("#deleteAddressModal" + address_id).modal('hide');
                            $('.row_address_' + address_id).fadeOut(500, function () {
                                $(this).remove();
                            });
                        }
                        if (response.totalAddress == 0) {
                            $(".NoAddressesClass").show();
                            location.reload();
                            return;
                        }
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
    </script>
@endsection
