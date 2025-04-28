@extends('layout.adminLayout')

@section('title')
    {{ __('cp.reports') }}
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{ucwords(__('cp.salesByCountry'))}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div>
                    <a href="javascript:void(0)"
                       class="btn btn-secondary mr-2 btn-success export-btn"
                       data-url="{{ url(getLocal().'/admin/exportReports?tab=sales-product-by-country&') . http_build_query(request()->query()) }}"
                       data-country-id="">
                        <i class="icon-xl la la-file-excel"></i> <span>{{__('cp.export')}}</span>
                    </a>
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <!-- Filters -->
                <div class="contentTabel">
                    <button type="button" class="btn  btn--filter mr-2"><i
                            class="icon-xl la la-sliders-h"></i>{{__('cp.filter')}}</button>
                    <div class="container box-filter-collapse">
                        <div class="card">
                            <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/salesByCountry')}}">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('cp.start_date')}}</label>
                                            <input type="date" class="form-control pull-right"
                                                   value="{{request('start_date')?request('start_date'):''}}"
                                                   name="start_date" id="from_date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">{{__('cp.end_date')}}</label>
                                            <input type="date" class="form-control pull-right"
                                                   value="{{request('end_date')?request('end_date'):''}}"
                                                   name="end_date" id="to_date">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit"
                                                class="btn sbold btn-default btnSearch">{{__('cp.search')}}
                                            <i class="fa fa-search"></i>
                                        </button>

                                        <a href="{{url(getLocal().'/admin/salesByCountry')}}" type="submit"
                                           class="btn sbold btn-default btnRest">{{__('cp.reset')}}
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div
                        class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                        <div>


                        </div>
                    </div>

                    <!-- Country Tabs -->
                    <div class="card card-custom">
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-4" id="countryTabs" role="tablist">
                                @forelse($topProductsByCountry as $index => $countryData)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                           id="country-{{ Str::slug($countryData['country_name']) }}-tab"
                                           data-toggle="tab"
                                           data-country-id="{{ $countryData['country_id'] }}"
                                           href="#country-{{ Str::slug($countryData['country_name']) }}"
                                           role="tab">
                                            {{ $countryData['country_name'] }}
                                        </a>
                                    </li>
                                @empty
                                    <li>{{ __('cp.no_data') }}</li>
                                @endforelse
                            </ul>

                            <!-- Country Tab Content -->
                            <div class="tab-content" id="countryTabsContent">
                                @forelse($topProductsByCountry as $index => $countryData)
                                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                         id="country-{{ Str::slug($countryData['country_name']) }}"
                                         role="tabpanel">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>{{ __('cp.product_id') }}</th>
                                                <th>{{ __('cp.product_title') }}</th>
                                                <th>{{ __('cp.quantity_sold') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($countryData['products'] as $product)
                                                <tr>
                                                    <td>{{ $product['product_id'] }}</td>
                                                    <td>{{ $product['product_title'] }}</td>
                                                    <td>{{ $product['quantity_sold'] }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" style="text-align: center; color: #555; font-weight: bold; font-size: 18px;">
                                                        {{ __('cp.no_data') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @empty
                                    <div style="text-align: center; color: #555; font-weight: bold; font-size: 18px; margin: 15px; padding: 20px; border: 2px dashed #ccc; border-radius: 10px; background-color: #f9f9f9;">
                                        {{ __('cp.no_data') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#countryTabs a').each(function() {
                var tabId = $(this).attr('href');
                var countryId = $(this).attr('data-country-id');
            });

            $('#countryTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var countryId = $(this).attr('data-country-id');

                var baseUrl = "{{ url(getLocal().'/admin/exportReports?tab=sales-product-by-country') }}";
                var queryString = "&country_id=" + countryId;

                @if(request('start_date'))
                    queryString += "&start_date={{ request('start_date') }}";
                @endif

                @if(request('end_date'))
                    queryString += "&end_date={{ request('end_date') }}";
                @endif

                $('.export-btn').attr('data-url', baseUrl + queryString);
                $('.export-btn').attr('data-country-id', countryId);
            });

            $('.export-btn').on('click', function(e) {
                e.preventDefault();
                var url = $(this).attr('data-url');

                if (url) {
                    window.location.href = url;
                }
            });

            setTimeout(function() {
                $('#countryTabs a.active').trigger('shown.bs.tab');
            }, 500);
        });
    </script>
@endsection
