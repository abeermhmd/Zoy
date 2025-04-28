@extends('layout.adminLayout')

@section('title')
    {{ __('cp.reports') }}
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <h3 class="mb-0">{{ __('cp.generalReports') }}</h3>
            </div>
        </div>
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{ucwords(__('cp.generalReports'))}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div>
                    <a href="javascript:void(0)"
                       class="btn btn-secondary mr-2 btn-success export-btn"
                       data-url="{{ url(getLocal().'/admin/exportReports?') . http_build_query(request()->query()) }}">
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
                    <button type="button" class="btn btn-secondar btn--filter mr-2"><i
                            class="icon-xl la la-sliders-h"></i>{{__('cp.filter')}}</button>
                    <div class="container box-filter-collapse">
                        <div class="card">
                            <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/reports')}}">
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

                                        <a href="{{url(getLocal().'/admin/reports')}}" type="submit"
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

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs mb-4" id="reportTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="sales-tab" data-toggle="tab" href="#sales"
                               role="tab">{{ __('cp.total_sales') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="top-products-tab" data-toggle="tab" href="#top-products"
                               role="tab">{{ __('cp.top_products') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="category-tab" data-toggle="tab" href="#category"
                               role="tab">{{ __('cp.sales_by_category') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="country-tab" data-toggle="tab" href="#country"
                               role="tab">{{ __('cp.sales_by_country') }}</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="reportTabsContent">
                        <!-- Total Sales Report -->
                        <div class="tab-pane fade show active" id="sales" role="tabpanel">
                            <div class="card card-custom">
                                <div class="card-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>{{ __('cp.order_id') }}</th>
                                            <th>{{ __('cp.country') }}</th>
                                            <th>{{ __('cp.total_amount') }} ({{ __('cp.KD') }})</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($totalSales as $sale)
                                            <tr>
                                                <td>{{ $sale->id }}</td>
                                                <td>{{ $sale->country_id ? $sale->country->name : $sale->address->country->name }}</td>
                                                <td>{{ number_format($sale->total, 3) }}</td>
                                            </tr>
                                        @empty
                                            <div
                                                style="text-align: center; color: #555; font-weight: bold; font-size: 18px; margin: 15px; padding: 20px; border: 2px dashed #ccc; border-radius: 10px; background-color: #f9f9f9;" id="no-data-message">
                                                @lang('cp.no_data')
                                            </div>
                                        @endforelse
                                        </tbody>
                                    </table>

                                    <!-- Pagination for Total Sales -->
                                    <div class="pagination-wrapper">
                                        {{$totalSales->appends($_GET)->links("pagination::bootstrap-4")}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Top Products -->
                        <div class="tab-pane fade" id="top-products" role="tabpanel">
                            <div class="card card-custom">
                                <div class="card-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>{{ __('cp.product_id') }}</th>
                                            <th>{{ __('cp.product_title') }}</th>
                                            <th>{{ __('cp.quantity_sold') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($topProducts as $product)
                                            <tr>
                                                <td>{{ $product->product->id }}</td>
                                                <td>{{ $product->product->name }}</td>
                                                <td>{{ $product->quantity_sold }}</td>
                                            </tr>
                                        @empty
                                            <div
                                                style="text-align: center; color: #555; font-weight: bold; font-size: 18px; margin: 15px; padding: 20px; border: 2px dashed #ccc; border-radius: 10px; background-color: #f9f9f9;" id="no-data-message">
                                                @lang('cp.no_data')
                                            </div>
                                        @endforelse
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>

                        <!-- Sales per Category -->
                        <div class="tab-pane fade" id="category" role="tabpanel">
                            <div class="card card-custom">
                                <div class="card-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>{{ __('cp.category') }}</th>
                                            <th>{{ __('cp.quantity_sold') }}</th>
                                            <th>{{ __('cp.total_amount') }} ({{ __('cp.KD') }})</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($categorySales as $category => $sales)
                                            @foreach($sales as $sale)
                                                <tr>
                                                    <td>{{ $category }}</td>
                                                    <td>{{ $sale->quantity_sold }}</td>
                                                    <td>{{ number_format($sale->total_amount, 3) }}</td>
                                                </tr>
                                            @endforeach
                                        @empty
                                            <div
                                                style="text-align: center; color: #555; font-weight: bold; font-size: 18px; margin: 15px; padding: 20px; border: 2px dashed #ccc; border-radius: 10px; background-color: #f9f9f9;" id="no-data-message">
                                                @lang('cp.no_data')
                                            </div>
                                        @endforelse
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>

                        <!-- Sales per Country -->
                        <div class="tab-pane fade" id="country" role="tabpanel">
                            <div class="card card-custom">
                                <div class="card-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>{{ __('cp.country') }}</th>
                                            <th>{{ __('cp.orders_count') }}</th>
                                            <th>{{ __('cp.total_amount') }} ({{ __('cp.KD') }})</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($countrySales as $sale)
                                            <tr>
                                                <td>{{ $sale->country }}</td>
                                                <td>{{ $sale->orders_count }}</td>
                                                <td>{{ number_format($sale->total_amount, 3) }}</td>
                                            </tr>
                                        @empty
                                            <div
                                                style="text-align: center; color: #555; font-weight: bold; font-size: 18px; margin: 15px; padding: 20px; border: 2px dashed #ccc; border-radius: 10px; background-color: #f9f9f9;" id="no-data-message">
                                                @lang('cp.no_data')
                                            </div>
                                        @endforelse
                                        </tbody>
                                    </table>


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
                document.addEventListener('DOMContentLoaded', function () {
                    const exportBtn = document.querySelector('.export-btn');
                    const tabs = document.querySelectorAll('.nav-tabs .nav-link');

                    exportBtn.addEventListener('click', function () {
                        const activeTab = document.querySelector('.nav-tabs .nav-link.active');
                        const tabId = activeTab.getAttribute('id').replace('-tab', '');
                        const baseUrl = this.getAttribute('data-url');
                        window.location.href = `${baseUrl}&tab=${tabId}`;
                    });
                });
            </script>
@endsection
