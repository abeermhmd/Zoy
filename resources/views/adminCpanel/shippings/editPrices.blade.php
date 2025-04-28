@extends('layout.adminLayout')
@section('title') {{ ucwords(__('cp.shippingManagement')) }} @endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <h3>{{ __('cp.shipping_prices') }}</h3>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <button id="submitButton" class="btn btn-success">{{ __('cp.save') }}</button>
            </div>
        </div>
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <form method="post" action="{{ route('admins.update.shipping.prices') }}" enctype="multipart/form-data"
                class="form-horizontal" role="form" id="form">
                @csrf
                <!-- جدول الدول -->
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('cp.countries_shipping_fees') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('cp.country_name') }}</th>
                                        <th>{{ __('cp.shipping_fees').' / '.__('cp.KD') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($countries as $country)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $country->name }}"
                                                disabled>
                                            <input type="hidden" name="countries[{{ $country->id }}][id]"
                                                value="{{ $country->id }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control"
                                                name="countries[{{ $country->id }}][delivery_fees]"
                                                value="{{ $country->delivery_fees }}" min="0" step="0.01" required>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- جدول المدن -->
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('cp.cities_shipping_fees') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('cp.city_name') }}</th>
                                        <th>{{ __('cp.delivery_fees').' / '.__('cp.KD') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cities as $city)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" value="{{ $city->name }}" disabled>
                                            <input type="hidden" name="cities[{{ $city->id }}][id]"
                                                value="{{ $city->id }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control"
                                                name="cities[{{ $city->id }}][delivery_fees]"
                                                value="{{ $city->delivery_fees }}" min="0" step="0.01" required>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <button type="submit" id="submitForm" style="display:none"></button>
            </form>
        </div>
    </div>
</div>
@endsection
