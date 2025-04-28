@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.users'))}}
@endsection
@section('content')
    <!--begin::Body-->
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <!--<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">-->
        <!--</div>-->
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Profile Overview-->
                <div class="d-flex flex-row">
                    <!--begin::Aside-->
                    <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
                        <!--begin::Profile Card-->
                        <div class="card card-custom card-stretch">
                            <!--begin::Body-->
                            <div class="card-body pt-4">

                                <!--begin::User-->
                                <div class="d-flex align-items-center">
                                    <div
                                        class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                    </div>
                                </div>
                                <!--end::User-->
                                <!--begin::Contact-->
                                <div class="py-9">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="font-weight-bold mr-2">{{__('cp.email')}}:</span>
                                        <a href="#" class="text-muted text-hover-primary">{{$item->email}}</a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="font-weight-bold mr-2">{{__('cp.mobile')}}:</span>
                                        <span class="text-muted">{{@$item->mobile}}</span>
                                    </div>

                                </div>
                                <!--end::Contact-->
                                <!--begin::Nav-->
                                <div class="navi navi-bold navi-hover navi-link-rounded">
                                    <div class="navi-item mb-2">
                                        <a href="{{url(getLocal().'/admin/users/'.$item->id.'/show')}}"
                                           class="navi-link py-4  @if(Route::currentRouteName() == "admins.users.show") active  @endif ">
															<span class="navi-icon mr-2">
																<span class="svg-icon">
																	<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                         height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
																		<g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
																			<polygon points="0 0 24 0 24 24 0 24"/>
																			<path
                                                                                d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                                                                fill="#000000" fill-rule="nonzero"/>
																			<path
                                                                                d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                                                                fill="#000000" opacity="0.3"/>
																		</g>
																	</svg>
                                                                    <!--end::Svg Icon-->
																</span>
															</span>
                                            <span class="navi-text font-size-lg">{{__('cp.overview')}}</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{url(getLocal().'/admin/users/'.$item->id.'/edit')}}"
                                           class="navi-link py-4  @if(Route::currentRouteName() == "admins.users.edit") active  @endif">
															<span class="navi-icon mr-2">
																<span class="svg-icon">
																	<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                         height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
																		<g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
																			<polygon points="0 0 24 0 24 24 0 24"/>
																			<path
                                                                                d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                opacity="0.3"/>
																			<path
                                                                                d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                                                                fill="#000000" fill-rule="nonzero"/>
																		</g>
																	</svg>
                                                                    <!--end::Svg Icon-->
																</span>
															</span>
                                            <span class="navi-text font-size-lg">{{__('cp.editCompany')}}</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{url(getLocal().'/admin/users/'.$item->id.'/orders')}}"
                                           class="navi-link py-4  @if(Route::currentRouteName() == "admins.users.orders") active @elseif(Route::currentRouteName() == "admins.users.showOrder") active @endif">
															<span class="navi-icon mr-2">
																<span class="svg-icon">
																	<!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0"
                                                                         viewBox="0 0 468.032 468.032" style="enable-background:new 0 0 512 512"
                                                                         xml:space="preserve"><g><path
                                                                                d="M430.006 384.005H123.644c-3.767 0-5.381-4.949-2.431-7.223l42.647-32.777h243.676c17.325 0 31.694-14.241 32.03-31.539l2.731-140.536c.312-16.021-11.42-29.932-27.289-32.304-7.634-1.142-14.783 4.107-15.927 11.752s4.131 14.759 11.783 15.903c1.989.297 3.459 2.025 3.42 4.027l-2.731 140.614c-.042 2.162-1.844 4.084-4.016 4.084H170.225L126.017 124.87l22.438 3.271c7.65 1.14 14.783-4.169 15.928-11.814 1.144-7.645-4.131-14.79-11.784-15.934L118.99 95.36l-12.848-49.943c-1.589-6.191-7.173-10.412-13.57-10.412H38.025c-7.737 0-14.01 6.27-14.01 14s6.272 14 14.01 14h43.677l61.707 261.119-39.309 30.283c-23.715 18.273-10.377 57.598 19.543 57.598h36.778c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.299-18.723 42.299-41.881c0-5.007-.894-10.146-2.522-14.146h76.515c-1.628 4-2.522 9.1-2.522 14.107 0 23.158 18.975 41.92 42.299 41.92s42.3-18.723 42.3-41.881c0-5.007-.894-10.146-2.522-14.146h33.963c7.738 0 14.01-6.27 14.01-14s-6.274-14-14.012-14zM200.198 439.96c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.874 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004zm156.068 0c-7.874 0-14.279-6.282-14.279-14.004s6.406-14.004 14.279-14.004c7.875 0 14.28 6.282 14.28 14.004s-6.406 14.004-14.28 14.004z"
                                                                                fill="#000000" opacity="1" data-original="#000000"></path><path
                                                                                d="M280.228 202.922c-56.106 0-101.752-45.515-101.752-101.461S224.122 0 280.228 0 381.98 45.515 381.98 101.461s-45.646 101.461-101.752 101.461zm0-174.928c-40.656 0-73.732 32.957-73.732 73.467s33.077 73.467 73.732 73.467 73.732-32.957 73.732-73.467-33.076-73.467-73.732-73.467z"
                                                                                fill="#000000" opacity="1" data-original="#000000"></path><path
                                                                                d="m255.411 137.097-22.503-26.705c-4.983-5.913-4.225-14.743 1.694-19.722 5.918-4.979 14.755-4.222 19.74 1.693l12.364 14.673 38.469-40.874c5.3-5.631 14.167-5.904 19.803-.609 5.638 5.295 5.91 14.154.61 19.785l-49.253 52.333c-4.399 4.631-15.657 5.548-20.924-.574z"
                                                                                fill="#000000" opacity="1" data-original="#000000"></path></g></svg>
                                                                    <!--end::Svg Icon-->
																</span>
															</span>
                                            <span class="navi-text font-size-lg">{{__('cp.orders')}}</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{url(getLocal().'/admin/users/'.$item->id.'/addresses')}}" class="navi-link py-4 @if(Route::currentRouteName() == "admins.users.addresses")  active @endif" data-toggle="tooltip" data-placement="right">
                                        <span class="navi-icon mr-2">
																<span class="svg-icon">
																	<!--begin::Svg Icon | path:assets/media/svg/icons/Text/Article.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect x="0" y="0" width="24" height="24" />
																			<rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
																			<path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L12.5,10 C13.3284271,10 14,10.6715729 14,11.5 C14,12.3284271 13.3284271,13 12.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3" />
																		</g>
																	</svg>
                                                                    <!--end::Svg Icon-->
																</span>
															</span>
                                            <span class="navi-text">{{__('cp.addresses')}}</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{url(getLocal().'/admin/users/'.$item->id.'/edit_password')}}"
                                           class="navi-link py-4  @if(Route::currentRouteName() == "admins.users.edit_password") active  @endif">
															<span class="navi-icon mr-2">
																<span class="svg-icon">
																	<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                         height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
																		<g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
																			<rect x="0" y="0" width="24" height="24"/>
																			<path
                                                                                d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
                                                                                fill="#000000" opacity="0.3"/>
																			<path
                                                                                d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"
                                                                                fill="#000000" opacity="0.3"/>
																			<path
                                                                                d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
                                                                                fill="#000000" opacity="0.3"/>
																		</g>
																	</svg>
                                                                    <!--end::Svg Icon-->
																</span>
															</span>
                                            <span class="navi-text font-size-lg">{{__('cp.Change_Password')}}</span>
                                            <span class="navi-label">
															</span>
                                        </a>
                                    </div>

                                </div>
                                <!--end::Nav-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Profile Card-->
                    </div>
                    <!--end::Aside-->
                    <!--begin::Content-->
                    <div class="flex-row-fluid ml-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::List Widget 14-->

                            @yield('companyContent')
                            <!--end::List Widget 14-->
                            </div>
                        </div>

                        @endsection
