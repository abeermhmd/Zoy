@extends('layout.adminLayout')

@section('title')
    {{ ucwords(__('cp.home')) }}
@endsection

@section('css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .card-custom {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 12px;
            overflow: hidden;
        }
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-weight: 600;
            color: #2c3e50;
            font-size: 2rem;
        }
        .text-muted {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .svg-icon {
            margin-bottom: 10px;
        }
        .section-title {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.5rem;
        }
        .gutter-b {
            margin-bottom: 2rem;
        }
        .svg-icon-success {
            fill: #28a745;
        }
        .svg-icon-danger {
            fill: #dc3545;
        }
        .svg-icon-primary {
            fill: #007bff;
        }
        .svg-icon-warning {
            fill: #ffc107;
        }
        .svg-icon-dark {
            fill: #343a40;
        }
        canvas#orderStatusChart {
            max-height: 300px;
        }
    </style>
@endsection

@section('content')
    @if(auth('admin')->user()->id === 1 || auth('admin')->user()->can('home'))
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Subheader-->
            <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
                <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <div class="d-flex align-items-center flex-wrap mr-1">
                        <div class="d-flex align-items-baseline mr-5">
                            <h3>{{ ucwords(__('cp.statistics')) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Subheader-->
            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
                <div class="container">
                    <div class="gutter-b example example-compact">
                        <!-- User Statistics Section -->
                        <h4 class="section-title">{{ __('cp.userStatistics') }}</h4>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 mb-5">
                                <div class="card card-custom wave wave-animate-fast">
                                    <div class="card-body">
                                        <span class="svg-icon svg-icon-3x svg-icon-dark">
                                            <!-- Same SVG for Users -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span id="countUsers" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$countUsers}}</span>
                                        <span class="font-weight-bold text-muted font-size-sm">{{ __('cp.countUser') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6 mb-5">
                                <div class="card card-custom wave wave-animate-fast">
                                    <div class="card-body">
                                        <span class="svg-icon svg-icon-3x svg-icon-dark">
                                            <!-- Same SVG for Guests -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 2048 2048">
                                                <g><g fill="#424242" fill-rule="nonzero">
                                                    <path d="M1024 892.644c102.534 0 195.729 41.924 263.271 109.468 67.544 67.544 109.468 160.739 109.468 263.273v183.706c0 52.016-21.258 99.282-55.504 133.53-34.248 34.246-81.515 55.504-133.53 55.504H840.291c-52.015 0-99.282-21.258-133.53-55.504-34.246-34.247-55.503-81.514-55.503-133.53v-183.706c0-102.534 41.924-195.729 109.468-263.273 67.542-67.544 160.738-109.468 263.27-109.468zM1024 409.875c64.81 0 123.488 26.273 165.963 68.749 42.476 42.474 68.749 101.153 68.749 165.963 0 64.808-26.273 123.487-68.749 165.962-42.475 42.476-101.153 68.748-165.963 68.748-64.81 0-123.488-26.273-165.963-68.749-42.476-42.474-68.749-101.153-68.749-165.962 0-64.809 26.273-123.488 68.749-165.963 42.475-42.475 101.153-68.748 165.963-68.748z" fill="#424242"/>
                                                    <path d="M1504 924.09c80.809 0 154.257 33.041 207.488 86.274 53.232 53.232 86.274 126.68 86.274 207.488v144.782c0 40.995-16.753 78.245-43.744 105.236-26.991 26.99-64.242 43.743-105.237 43.743h-229.097a219.991 219.991 0 0 0 9.056-62.523v-183.706c0-102.917-39.18-200.967-109.114-275.829 50.492-40.894 114.696-65.465 184.375-65.465zM1504 543.613c51.077 0 97.323 20.706 130.798 54.182 33.476 33.475 54.182 79.72 54.182 130.798 0 51.076-20.706 97.322-54.182 130.797-33.475 33.476-79.72 54.18-130.798 54.18-51.077 0-97.323-20.704-130.798-54.18-33.476-33.475-54.182-79.721-54.182-130.797 0-51.078 20.706-97.323 54.182-130.798 33.475-33.476 79.72-54.182 130.798-54.182zM544 924.09c69.68 0 133.883 24.57 184.375 65.465-69.933 74.862-109.114 172.912-109.114 275.829v183.706c0 21.406 3.104 42.432 9.056 62.523h-229.1c-40.993 0-78.245-16.753-105.235-43.743-26.991-26.991-43.744-64.242-43.744-105.236v-144.782c0-80.808 33.042-154.256 86.274-207.488C389.743 957.13 463.19 924.09 544 924.09zM544 543.613c51.077 0 97.323 20.706 130.798 54.182 33.476 33.475 54.182 79.72 54.182 130.798 0 51.076-20.706 97.322-54.182 130.797-33.475 33.476-79.72 54.18-130.798 54.18-51.077 0-97.323-20.704-130.798-54.18-33.476-33.475-54.182-79.721-54.182-130.797 0-51.078 20.706-97.323 54.182-130.798 33.475-33.476 79.72-54.182 130.798-54.182z" fill="#424242"/>
                                                </g></g>
                                            </svg>
                                        </span>
                                        <span id="countGuest" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$countGuest}}</span>
                                        <span class="font-weight-bold text-muted font-size-sm">{{ __('cp.countGuest') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Statistics Section -->
                        <h4 class="section-title">{{ __('cp.orderStatistics') }}</h4>
                        <div class="row">

                            <div class="col-12 col-md-6 mb-5">
                                <div class="card card-custom wave wave-animate-fast">
                                    <div class="card-body">
                                        <span class="svg-icon svg-icon-3x svg-icon-danger">
                                            <!-- Same SVG for Failed Orders -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 468.032 468.032">
                                                <g><path d="M430.006 384.005H123.644c-3.767 0-5.381-4.949-2.431-7.223l42.647-32.777h243.676c17.325 0 31.694-14.241 32.03-31.539l2.731-140.536c.312-16.021-11.42-29.932-27.289-32.304-7.634-1.142-14.783 4.107-15.927 11.752s4.131 14.759 11.783 15.903c1.989.297 3.459 2.025 3.42 4.027l-2.731 140.614c-.042 2.162-1.844 4.084-4.016 4.084H170.225L126.017 124.87l22.438 3.271c7.65 1.14 14.783-4.169 15.928-11.814 1.144-7.645-4.131-14.79-11.784-15.934L118.99 95.36l-12.848-49.943c-1.589-6.191-7.173-10.412-13.57-10.412H38.025c-7.737 0-14.01 6.27-14.01 14s6.272 14 14.01 14h43.677l61.707 261.119-39.309 30.283c-23.715 18.273-10.377 57.598 19.543 57.598h36.778c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.299-18.723 42.299-41.881c0-5.007-.894-10.146-2.522-14.146h76.515c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.3-18.723 42.3-41.881c0-5.007-.894-10.146-2.522-14.146h33.963c7.738 0 14.01-6.27 14.01-14s-6.274-14-14.012-14zM200.198 439.96c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.874 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004zm156.068 0c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.875 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004z" fill="#000000"/>
                                                <path d="M280.228 202.922c-56.106 0-101.752-45.515-101.752-101.461S224.122 0 280.228 0 381.98 45.515 381.98 101.461s-45.646 101.461-101.752 101.461zm0-174.928c-40.656 0-73.732 32.957-73.732 73.467s33.077 73.467 73.732 73.467 73.732-32.957 73.732-73.467-33.076-73.467-73.732-73.467z" fill="#000000"/>
                                                <path d="m255.411 137.097-22.503-26.705c-4.983-5.913-4.225-14.743 1.694-19.722 5.918-4.979 14.755-4.222 19.74 1.693l12.364 14.673 38.469-40.874c5.3-5.631 14.167-5.904 19.803-.609 5.638 5.295 5.91 14.154.61 19.785l-49.253 52.333c-4.399 4.631-15.657 5.548-20.924-.574z" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span id="countFailedOrders" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$countFailedOrders}}</span>
                                        <span class="font-weight-bold text-muted font-size-sm">{{ __('cp.countFailedOrders') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-5">
                                <div class="card card-custom wave wave-animate-fast">
                                    <div class="card-body">
                                        <span class="svg-icon svg-icon-3x svg-icon-success">
                                            <!-- Same SVG for Total Orders Today -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 468.032 468.032">
                                                <g><path d="M430.006 384.005H123.644c-3.767 0-5.381-4.949-2.431-7.223l42.647-32.777h243.676c17.325 0 31.694-14.241 32.03-31.539l2.731-140.536c.312-16.021-11.42-29.932-27.289-32.304-7.634-1.142-14.783 4.107-15.927 11.752s4.131 14.759 11.783 15.903c1.989.297 3.459 2.025 3.42 4.027l-2.731 140.614c-.042 2.162-1.844 4.084-4.016 4.084H170.225L126.017 124.87l22.438 3.271c7.65 1.14 14.783-4.169 15.928-11.814 1.144-7.645-4.131-14.79-11.784-15.934L118.99 95.36l-12.848-49.943c-1.589-6.191-7.173-10.412-13.57-10.412H38.025c-7.737 0-14.01 6.27-14.01 14s6.272 14 14.01 14h43.677l61.707 261.119-39.309 30.283c-23.715 18.273-10.377 57.598 19.543 57.598h36.778c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.299-18.723 42.299-41.881c0-5.007-.894-10.146-2.522-14.146h76.515c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.3-18.723 42.3-41.881c0-5.007-.894-10.146-2.522-14.146h33.963c7.738 0 14.01-6.27 14.01-14s-6.274-14-14.012-14zM200.198 439.96c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.874 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004zm156.068 0c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.875 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004z" fill="#000000"/>
                                                <path d="M280.228 202.922c-56.106 0-101.752-45.515-101.752-101.461S224.122 0 280.228 0 381.98 45.515 381.98 101.461s-45.646 101.461-101.752 101.461zm0-174.928c-40.656 0-73.732 32.957-73.732 73.467s33.077 73.467 73.732 73.467 73.732-32.957 73.732-73.467-33.076-73.467-73.732-73.467z" fill="#000000"/>
                                                <path d="m255.411 137.097-22.503-26.705c-4.983-5.913-4.225-14.743 1.694-19.722 5.918-4.979 14.755-4.222 19.74 1.693l12.364 14.673 38.469-40.874c5.3-5.631 14.167-5.904 19.803-.609 5.638 5.295 5.91 14.154.61 19.785l-49.253 52.333c-4.399 4.631-15.657 5.548-20.924-.574z" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span id="totalOrderToday" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$totalOrderToday}}</span>
                                        <span class="font-weight-bold text-muted font-size-sm">{{ __('cp.totalOrderToday') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 mb-5">
                                <div class="card card-custom wave wave-animate-fast">
                                    <div class="card-body">
                                        <span class="svg-icon svg-icon-3x svg-icon-primary">
                                            <!-- Same SVG for Placed Orders -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 468.032 468.032">
                                                <g><path d="M430.006 384.005H123.644c-3.767 0-5.381-4.949-2.431-7.223l42.647-32.777h243.676c17.325 0 31.694-14.241 32.03-31.539l2.731-140.536c.312-16.021-11.42-29.932-27.289-32.304-7.634-1.142-14.783 4.107-15.927 11.752s4.131 14.759 11.783 15.903c1.989.297 3.459 2.025 3.42 4.027l-2.731 140.614c-.042 2.162-1.844 4.084-4.016 4.084H170.225L126.017 124.87l22.438 3.271c7.65 1.14 14.783-4.169 15.928-11.814 1.144-7.645-4.131-14.79-11.784-15.934L118.99 95.36l-12.848-49.943c-1.589-6.191-7.173-10.412-13.57-10.412H38.025c-7.737 0-14.01 6.27-14.01 14s6.272 14 14.01 14h43.677l61.707 261.119-39.309 30.283c-23.715 18.273-10.377 57.598 19.543 57.598h36.778c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.299-18.723 42.299-41.881c0-5.007-.894-10.146-2.522-14.146h76.515c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.3-18.723 42.3-41.881c0-5.007-.894-10.146-2.522-14.146h33.963c7.738 0 14.01-6.27 14.01-14s-6.274-14-14.012-14zM200.198 439.96c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.874 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004zm156.068 0c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.875 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004z" fill="#000000"/>
                                                <path d="M280.228 202.922c-56.106 0-101.752-45.515-101.752-101.461S224.122 0 280.228 0 381.98 45.515 381.98 101.461s-45.646 101.461-101.752 101.461zm0-174.928c-40.656 0-73.732 32.957-73.732 73.467s33.077 73.467 73.732 73.467 73.732-32.957 73.732-73.467-33.076-73.467-73.732-73.467z" fill="#000000"/>
                                                <path d="m255.411 137.097-22.503-26.705c-4.983-5.913-4.225-14.743 1.694-19.722 5.918-4.979 14.755-4.222 19.74 1.693l12.364 14.673 38.469-40.874c5.3-5.631 14.167-5.904 19.803-.609 5.638 5.295 5.91 14.154.61 19.785l-49.253 52.333c-4.399 4.631-15.657 5.548-20.924-.574z" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span id="placedOrder" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$placedOrder}}</span>
                                        <span class="font-weight-bold text-muted font-size-sm">{{ __('cp.placedOrderCount') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-5">
                                <div class="card card-custom wave wave-animate-fast">
                                    <div class="card-body">
                                        <span class="svg-icon svg-icon-3x svg-icon-warning">
                                            <!-- Same SVG for On The Way Orders -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 468.032 468.032">
                                                <g><path d="M430.006 384.005H123.644c-3.767 0-5.381-4.949-2.431-7.223l42.647-32.777h243.676c17.325 0 31.694-14.241 32.03-31.539l2.731-140.536c.312-16.021-11.42-29.932-27.289-32.304-7.634-1.142-14.783 4.107-15.927 11.752s4.131 14.759 11.783 15.903c1.989.297 3.459 2.025 3.42 4.027l-2.731 140.614c-.042 2.162-1.844 4.084-4.016 4.084H170.225L126.017 124.87l22.438 3.271c7.65 1.14 14.783-4.169 15.928-11.814 1.144-7.645-4.131-14.79-11.784-15.934L118.99 95.36l-12.848-49.943c-1.589-6.191-7.173-10.412-13.57-10.412H38.025c-7.737 0-14.01 6.27-14.01 14s6.272 14 14.01 14h43.677l61.707 261.119-39.309 30.283c-23.715 18.273-10.377 57.598 19.543 57.598h36.778c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.299-18.723 42.299-41.881c0-5.007-.894-10.146-2.522-14.146h76.515c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.3-18.723 42.3-41.881c0-5.007-.894-10.146-2.522-14.146h33.963c7.738 0 14.01-6.27 14.01-14s-6.274-14-14.012-14zM200.198 439.96c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.874 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004zm156.068 0c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.875 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004z" fill="#000000"/>
                                                <path d="M280.228 202.922c-56.106 0-101.752-45.515-101.752-101.461S224.122 0 280.228 0 381.98 45.515 381.98 101.461s-45.646 101.461-101.752 101.461zm0-174.928c-40.656 0-73.732 32.957-73.732 73.467s33.077 73.467 73.732 73.467 73.732-32.957 73.732-73.467-33.076-73.467-73.732-73.467z" fill="#000000"/>
                                                <path d="m255.411 137.097-22.503-26.705c-4.983-5.913-4.225-14.743 1.694-19.722 5.918-4.979 14.755-4.222 19.74 1.693l12.364 14.673 38.469-40.874c5.3-5.631 14.167-5.904 19.803-.609 5.638 5.295 5.91 14.154.61 19.785l-49.253 52.333c-4.399 4.631-15.657 5.548-20.924-.574z" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span id="onTheWayOrderCount" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$onTheWayOrderCount}}</span>
                                        <span class="font-weight-bold text-muted font-size-sm">{{ __('cp.onTheWayOrderCount') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-5">
                                <div class="card card-custom wave wave-animate-fast">
                                    <div class="card-body">
                                        <span class="svg-icon svg-icon-3x svg-icon-success">
                                            <!-- Same SVG for Delivered Orders -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 468.032 468.032">
                                                <g><path d="M430.006 384.005H123.644c-3.767 0-5.381-4.949-2.431-7.223l42.647-32.777h243.676c17.325 0 31.694-14.241 32.03-31.539l2.731-140.536c.312-16.021-11.42-29.932-27.289-32.304-7.634-1.142-14.783 4.107-15.927 11.752s4.131 14.759 11.783 15.903c1.989.297 3.459 2.025 3.42 4.027l-2.731 140.614c-.042 2.162-1.844 4.084-4.016 4.084H170.225L126.017 124.87l22.438 3.271c7.65 1.14 14.783-4.169 15.928-11.814 1.144-7.645-4.131-14.79-11.784-15.934L118.99 95.36l-12.848-49.943c-1.589-6.191-7.173-10.412-13.57-10.412H38.025c-7.737 0-14.01 6.27-14.01 14s6.272 14 14.01 14h43.677l61.707 261.119-39.309 30.283c-23.715 18.273-10.377 57.598 19.543 57.598h36.778c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.299-18.723 42.299-41.881c0-5.007-.894-10.146-2.522-14.146h76.515c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.3-18.723 42.3-41.881c0-5.007-.894-10.146-2.522-14.146h33.963c7.738 0 14.01-6.27 14.01-14s-6.274-14-14.012-14zM200.198 439.96c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.874 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004zm156.068 0c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.875 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004z" fill="#000000"/>
                                                <path d="M280.228 202.922c-56.106 0-101.752-45.515-101.752-101.461S224.122 0 280.228 0 381.98 45.515 381.98 101.461s-45.646 101.461-101.752 101.461zm0-174.928c-40.656 0-73.732 32.957-73.732 73.467s33.077 73.467 73.732 73.467 73.732-32.957 73.732-73.467-33.076-73.467-73.732-73.467z" fill="#000000"/>
                                                <path d="m255.411 137.097-22.503-26.705c-4.983-5.913-4.225-14.743 1.694-19.722 5.918-4.979 14.755-4.222 19.74 1.693l12.364 14.673 38.469-40.874c5.3-5.631 14.167-5.904 19.803-.609 5.638 5.295 5.91 14.154.61 19.785l-49.253 52.333c-4.399 4.631-15.657 5.548-20.924-.574z" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span id="deliveredOrder" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$deliveredOrder}}</span>
                                        <span class="font-weight-bold text-muted font-size-sm">{{ __('cp.deliveredOrderCount') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-5">
                                <div class="card card-custom wave wave-animate-fast">
                                    <div class="card-body">
                                        <span class="svg-icon svg-icon-3x svg-icon-danger">
                                            <!-- Same SVG for Canceled Orders -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 468.032 468.032">
                                                <g><path d="M430.006 384.005H123.644c-3.767 0-5.381-4.949-2.431-7.223l42.647-32.777h243.676c17.325 0 31.694-14.241 32.03-31.539l2.731-140.536c.312-16.021-11.42-29.932-27.289-32.304-7.634-1.142-14.783 4.107-15.927 11.752s4.131 14.759 11.783 15.903c1.989.297 3.459 2.025 3.42 4.027l-2.731 140.614c-.042 2.162-1.844 4.084-4.016 4.084H170.225L126.017 124.87l22.438 3.271c7.65 1.14 14.783-4.169 15.928-11.814 1.144-7.645-4.131-14.79-11.784-15.934L118.99 95.36l-12.848-49.943c-1.589-6.191-7.173-10.412-13.57-10.412H38.025c-7.737 0-14.01 6.27-14.01 14s6.272 14 14.01 14h43.677l61.707 261.119-39.309 30.283c-23.715 18.273-10.377 57.598 19.543 57.598h36.778c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.299-18.723 42.299-41.881c0-5.007-.894-10.146-2.522-14.146h76.515c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.3-18.723 42.3-41.881c0-5.007-.894-10.146-2.522-14.146h33.963c7.738 0 14.01-6.27 14.01-14s-6.274-14-14.012-14zM200.198 439.96c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.874 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004zm156.068 0c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.875 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004z" fill="#000000"/>
                                                <path d="M280.228 202.922c-56.106 0-101.752-45.515-101.752-101.461S224.122 0 280.228 0 381.98 45.515 381.98 101.461s-45.646 101.461-101.752 101.461zm0-174.928c-40.656 0-73.732 32.957-73.732 73.467s33.077 73.467 73.732 73.467 73.732-32.957 73.732-73.467-33.076-73.467-73.732-73.467z" fill="#000000"/>
                                                <path d="m255.411 137.097-22.503-26.705c-4.983-5.913-4.225-14.743 1.694-19.722 5.918-4.979 14.755-4.222 19.74 1.693l12.364 14.673 38.469-40.874c5.3-5.631 14.167-5.904 19.803-.609 5.638 5.295 5.91 14.154.61 19.785l-49.253 52.333c-4.399 4.631-15.657 5.548-20.924-.574z" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span id="canceledOrder" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$canceledOrder}}</span>
                                        <span class="font-weight-bold text-muted font-size-sm">{{ __('cp.canceledOrderCount') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-5">
                                <div class="card card-custom wave wave-animate-fast">
                                    <div class="card-body">
                                        <span class="svg-icon svg-icon-3x svg-icon-primary">
                                            <!-- Same SVG for Income -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <rect fill="#000000" opacity="0.3" x="2" y="2" width="10" height="12" rx="2"/>
                                                    <path d="M4,6 L20,6 C21.1045695,6 22,6.8954305 22,8 L22,20 C22,21.1045695 21.1045695,22 20,22 L4,22 C2.8954305,22 2,21.1045695 2,20 L2,8 C2,6.8954305 2.8954305,6 4,6 Z M18,16 C19.1045695,16 20,15.1045695 20,14 C20,12.8954305 19.1045695,12 18,12 C16.8954305,12 16,12.8954305 16,14 C16,15.1045695 16.8954305,16 18,16 Z" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span id="totalAmountOrder" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ number_format($totalAmountOrder, 3) }} {{ __('cp.KD') }}</span>
                                        <span class="font-weight-bold text-muted font-size-sm">{{ __('cp.incomeOrder') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Statistics Section -->
                        <h4 class="section-title">{{ __('cp.productStatistics') }}</h4>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-5">
                                <div class="card card-custom wave wave-animate-fast">
                                    <div class="card-body">
                                        <span class="svg-icon svg-icon-3x svg-icon-dark">
                                            <!-- Same SVG for Categories -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 64 64">
                                                <g><path d="M4 40.962c0 .36.19.69.5.871l15 8.66V32.582L4 23.621zM11.68 18.023 5 21.878l15.5 8.971 6.68-3.865zM36 21.878l-15-8.661a.992.992 0 0 0-1 0l-6.32 3.645 15.5 8.96zM21.5 50.494l15-8.661c.31-.18.5-.51.5-.871V23.62l-15.5 8.961zM52.14 33.002c1.197 4.48 7.802 3.686 7.86-1.001a4.001 4.001 0 0 0-4-4.005c-1.86 0-3.41 1.281-3.86 3.003H48V10.974c0-.55.45-1.001 1-1.001h3.14c.45 1.722 2 3.004 3.86 3.004 2.21 0 4-1.793 4-4.005-.057-4.676-6.657-5.492-7.86-1.002H49c-1.65 0-3 1.352-3 3.004V31h-5c-.55 0-1 .451-1 1.002s.45 1 1 1h5v20.026a3.01 3.01 0 0 0 3 3.004h3.14c1.192 4.47 7.8 3.697 7.86-1.001-.066-4.7-6.662-5.474-7.86-1.001H49c-.55 0-1-.451-1-1.002V33.002h4.14z" fill="#000000"/></g>
                                            </svg>
                                        </span>
                                        <span id="countCategories" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$countCategories}}</span>
                                        <span class="font-weight-bold text-muted font-size-sm">{{ __('cp.countCategories') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-5">
                                <div class="card card-custom wave wave-animate-fast">
                                    <div class="card-body">
                                        <span class="svg-icon svg-icon-3x svg-icon-dark">
                                            <!-- Same SVG for Subcategories -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 64 64">
                                                <g><path d="M4 40.962c0 .36.19.69.5.871l15 8.66V32.582L4 23.621zM11.68 18.023 5 21.878l15.5 8.971 6.68-3.865zM36 21.878l-15-8.661a.992.992 0 0 0-1 0l-6.32 3.645 15.5 8.96zM21.5 50.494l15-8.661c.31-.18.5-.51.5-.871V23.62l-15.5 8.961zM52.14 33.002c1.197 4.48 7.802 3.686 7.86-1.001a4.001 4.001 0 0 0-4-4.005c-1.86 0-3.41 1.281-3.86 3.003H48V10.974c0-.55.45-1.001 1-1.001h3.14c.45 1.722 2 3.004 3.86 3.004 2.21 0 4-1.793 4-4.005-.057-4.676-6.657-5.492-7.86-1.002H49c-1.65 0-3 1.352-3 3.004V31h-5c-.55 0-1 .451-1 1.002s.45 1 1 1h5v20.026a3.01 3.01 0 0 0 3 3.004h3.14c1.192 4.47 7.8 3.697 7.86-1.001-.066-4.7-6.662-5.474-7.86-1.001H49c-.55 0-1-.451-1-1.002V33.002h4.14z" fill="#000000"/></g>
                                            </svg>
                                        </span>
                                        <span id="countSubCategories" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$countSubCategories}}</span>
                                        <span class="font-weight-bold text-muted font-size-sm">{{ __('cp.countSubCategories') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-5">
                                <div class="card card-custom wave wave-animate-fast">
                                    <div class="card-body">
                                        <span class="svg-icon svg-icon-3x svg-icon-warning">
                                            <!-- Same SVG for Products -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                                                <g><path fill-rule="evenodd" d="M256 89.632c48.712 0 88.201 39.489 88.201 88.2 0 48.712-39.489 88.2-88.201 88.2s-88.199-39.488-88.199-88.2c0-48.71 39.487-88.2 88.199-88.2zm8 250.154v165.519l163.27-63.483V338.314l-127.664 49.64c-3.713 1.436-7.844-.098-9.775-3.441zm-16 165.518V339.786l-25.824 44.73a7.982 7.982 0 0 1-10.114 3.307l-127.33-49.509v103.507zm183.775-255.128L267.56 314.028l32.663 56.574 164.216-63.852zM244.44 314.028 80.224 250.176 47.561 306.75l164.217 63.852zM256 282.032c-43.803 0-81.293-27.028-96.703-65.317l-60.563 23.548L256 301.413l157.266-61.15-60.563-23.548c-15.409 38.288-52.899 65.317-96.703 65.317zm161.031-110.094c4.42 0 8 3.582 8 8s-3.58 8-8 8h-37.467a8 8 0 0 1 0-16zM248 14.696a8 8 0 0 1 16 0v37.469a8 8 0 0 1-16 0zm-80.757 24.771a7.966 7.966 0 0 1 13.813-7.937l18.734 32.449a7.966 7.966 0 0 1-13.813 7.937zm-57.576 61.88a7.981 7.981 0 0 1 8-13.812l32.448 18.734a7.982 7.982 0 0 1-8 13.812zm-18.909 82.38a8 8 0 0 1 0-16h37.468c4.419 0 8 3.582 8 8s-3.581 8-8 8zM330.38 33.635a7.968 7.968 0 0 1 10.876-2.938 7.967 7.967 0 0 1 2.938 10.875L325.46 74.021a7.965 7.965 0 1 1-13.813-7.937zm61.849 57.546a7.981 7.981 0 0 1 8 13.812l-32.449 18.734c-3.813 2.209-8.697.907-10.906-2.906s-.906-8.697 2.906-10.906zM289.396 137.61l-52.247 52.248-17.83-22.438c-4.386-5.518-12.414-6.434-17.931-2.049-5.518 4.387-6.435 12.414-2.048 17.932l26.238 33.019c4.537 6.499 13.88 7.388 19.534 1.733l62.364-62.363c4.991-4.993 4.991-13.088 0-18.082-4.992-4.992-13.087-4.992-18.08 0z" clip-rule="evenodd" fill="#000000"/></g>
                                            </svg>
                                        </span>
                                        <span id="countProducts" class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{$countProducts}}</span>
                                        <span class="font-weight-bold text-muted font-size-sm">{{ __('cp.countProducts') }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="content d-flex justify-content-center align-items-center" style="height: 70vh; margin: 0; overflow: hidden;">
            <div class="text-center">
                <h1 class="display-4 mb-4" style="color: #452C44;">{{ __('cp.Welcome to the Admin Panel') }}</h1>
            </div>
        </div>
    @endif
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.3.2/countUp.min.js" integrity="sha512-6M2v8f4D4FJgjV3Mlt6a3VxaJIorT0Ri7dW4iJdh5AAMOpF6RRBVyLnaJXD7ZNVJ7o3T7U+Vx7mmMkR80hXGsuw==" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // CountUp Animations
            const countUsers = new CountUp('countUsers', {{ @$countUsers }}, { duration: 2 });
            const countGuest = new CountUp('countGuest', {{ @$countGuest }}, { duration: 2 });
            const countFailedOrders = new CountUp('countFailedOrders', {{ @$countFailedOrders }}, { duration: 2 });
            const totalOrderToday = new CountUp('totalOrderToday', {{ @$totalOrderToday }}, { duration: 2 });
            const placedOrder = new CountUp('placedOrder', {{ @$placedOrder }}, { duration: 2 });
            const onTheWayOrderCount = new CountUp('onTheWayOrderCount', {{ @$onTheWayOrderCount }}, { duration: 2 });
            const deliveredOrder = new CountUp('deliveredOrder', {{ @$deliveredOrder }}, { duration: 2 });
            const canceledOrder = new CountUp('canceledOrder', {{ @$canceledOrder }}, { duration: 2 });
            const countCategories = new CountUp('countCategories', {{ @$countCategories }}, { duration: 2 });
            const countSubCategories = new CountUp('countSubCategories', {{ @$countSubCategories }}, { duration: 2 });
            const countProducts = new CountUp('countProducts', {{ @$countProducts }}, { duration: 2 });
            const totalAmountOrder = new CountUp('totalAmountOrder', {{ @$totalAmountOrder }}, { duration: 2, decimals: 3 });

            countUsers.start();
            countGuest.start();
            countFailedOrders.start();
            totalOrderToday.start();
            placedOrder.start();
            onTheWayOrderCount.start();
            deliveredOrder.start();
            canceledOrder.start();
            countCategories.start();
            countSubCategories.start();
            countProducts.start();
            totalAmountOrder.start();

            // Pie Chart for Order Status
            var ctx = document.getElementById('orderStatusChart').getContext('2d');
            var orderStatusChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['{{ __('cp.deliveredOrder') }}', '{{ __('cp.canceledOrder') }}', '{{ __('cp.countFailedOrders') }}'],
                    datasets: [{
                        data: [{{ @$deliveredOrder }}, {{ @$canceledOrder }}, {{ @$countFailedOrders }}],
                        backgroundColor: ['#28a745', '#dc3545', '#ffc107']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endsection
