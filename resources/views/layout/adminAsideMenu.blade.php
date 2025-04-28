<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
         data-menu-dropdown-timeout="500">

        <ul class="menu-nav">
            <li class="menu-item  {{ (explode("/", request()->url())[5] == "home") ? "menu-item-here" : '' }}"
                aria-haspopup="true">
                <a href="{{url('/admin/home')}}" class="menu-link">
                                <span class="svg-icon menu-icon">
                                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Home\Home.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24px"
                                        height="24px" viewBox="0 0 24 24" version="1.1">
<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
<rect x="0" y="0" width="24" height="24"/>
<path
    d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
    fill="#000000"/>
</g>
</svg>
                                    <!--end::Svg Icon-->
                                </span>
                    <span class="menu-text">{{__('cp.home')}}</span>

                </a>
            </li>
            @if(can('admins'))
                <li class="menu-item {{(explode("/", request()->url())[5] == "admins") ? "menu-item-here" : ''}}"
                    aria-haspopup="true">
                    <a href="{{url(getLocal().'/admin/admins')}}" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Delete-user.svg-->
                        <svg
                            xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0"
                            viewBox="0 0 474.565 474.565"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path
                                    d="M255.204 102.3c-.606-11.321-12.176-9.395-23.465-9.395 8.339 2.221 16.228 5.311 23.465 9.395zM134.524 73.928c-43.825 0-63.997 55.471-28.963 83.37 11.943-31.89 35.718-54.788 66.886-63.826-8.526-11.787-22.301-19.544-37.923-19.544z"
                                    fill="#000000" data-original="#000000" class=""></path>
                                <path
                                    d="M43.987 148.617a97.207 97.207 0 0 0 6.849 16.438L36.44 179.459c-3.866 3.866-3.866 10.141 0 14.015l25.375 25.383a9.93 9.93 0 0 0 7.019 2.888c2.61 0 5.125-1.04 7.005-2.888l14.38-14.404c2.158 1.142 4.55 1.842 6.785 2.827 0-.164-.016-.334-.016-.498 0-11.771 1.352-22.875 3.759-33.302C83.385 162.306 71.8 142.91 71.8 120.765c0-34.592 28.139-62.739 62.723-62.739 23.418 0 43.637 13.037 54.43 32.084 11.523-1.429 22.347-1.429 35.376 1.033-1.676-5.07-3.648-10.032-6.118-14.683l14.396-14.411a9.839 9.839 0 0 0 2.918-7.004 9.837 9.837 0 0 0-2.918-7.004l-25.361-25.367a9.863 9.863 0 0 0-7.003-2.904 9.806 9.806 0 0 0-6.989 2.904l-14.442 14.411c-5.217-2.764-10.699-5.078-16.444-6.825V9.9c0-5.466-4.411-9.9-9.893-9.9h-35.888c-5.451 0-9.909 4.434-9.909 9.9v20.359c-5.73 1.747-11.213 4.061-16.446 6.825L75.839 22.689a9.869 9.869 0 0 0-7.005-2.904 9.864 9.864 0 0 0-7.003 2.896L36.44 48.048a9.952 9.952 0 0 0-2.888 7.012 9.921 9.921 0 0 0 2.888 7.004l14.396 14.403c-2.75 5.218-5.063 10.708-6.817 16.438H23.675c-5.482 0-9.909 4.441-9.909 9.915v35.889c0 5.458 4.427 9.908 9.909 9.908h20.312zM354.871 340.654c15.872-8.705 26.773-25.367 26.773-44.703 0-28.217-22.967-51.168-51.184-51.168-9.923 0-19.118 2.966-26.975 7.873-4.705 18.728-12.113 36.642-21.803 52.202a153.3 153.3 0 0 1 73.189 35.796z"
                                    fill="#000000" data-original="#000000" class=""></path>
                                <path
                                    d="M460.782 276.588c0-5.909-4.799-10.693-10.685-10.693H428.14c-1.896-6.189-4.411-12.121-7.393-17.75l15.544-15.544a10.624 10.624 0 0 0 3.137-7.555c0-2.835-1.118-5.553-3.137-7.563l-27.363-27.371a10.651 10.651 0 0 0-7.561-3.138 10.616 10.616 0 0 0-7.547 3.138l-15.576 15.552c-5.623-2.982-11.539-5.481-17.751-7.369v-21.958c0-5.901-4.768-10.685-10.669-10.685H311.11c-2.594 0-4.877 1.04-6.739 2.578 3.26 11.895 5.046 24.793 5.046 38.552 0 8.735-.682 17.604-1.956 26.423 7.205-2.656 14.876-4.324 22.999-4.324 36.99 0 67.086 30.089 67.086 67.07 0 23.637-12.345 44.353-30.872 56.303a152.948 152.948 0 0 1 31.168 51.976c1.148.396 2.344.684 3.54.684 2.733 0 5.467-1.04 7.563-3.13l27.379-27.371c2.004-2.004 3.106-4.721 3.106-7.555s-1.102-5.551-3.106-7.563l-15.576-15.552c2.982-5.621 5.497-11.555 7.393-17.75h21.957c2.826 0 5.575-1.118 7.563-3.138a10.676 10.676 0 0 0 3.138-7.555l-.017-38.712zM376.038 413.906c-16.602-48.848-60.471-82.445-111.113-87.018-16.958 17.958-37.954 29.351-61.731 29.351-23.759 0-44.771-11.392-61.713-29.351-50.672 4.573-94.543 38.17-111.145 87.026l-9.177 27.013c-2.625 7.773-1.368 16.338 3.416 23.007a25.462 25.462 0 0 0 20.685 10.631h315.853c8.215 0 15.918-3.96 20.702-10.631a25.476 25.476 0 0 0 3.4-23.007l-9.177-27.021z"
                                    fill="#000000" data-original="#000000" class=""></path>
                                <path
                                    d="M120.842 206.782c0 60.589 36.883 125.603 82.352 125.603 45.487 0 82.368-65.014 82.368-125.603.001-125.594-164.72-125.843-164.72 0z"
                                    fill="#000000" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>

                        <span class="menu-text">{{__('cp.admins')}}</span>
                    </a>
                </li>
            @endif
            @if(can('users'))
                <li class="menu-item {{(explode("/", request()->url())[5] == "users") ? "menu-item-here" : ''}}"
                    aria-haspopup="true">
                    <a href="{{url(getLocal().'/admin/users')}}" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                             height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"/>
                                <path
                                    d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                    fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                <path
                                    d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                    fill="#000000" fill-rule="nonzero"/>
                            </g>
                        </svg>
                    </span>
                        <span class="menu-text">{{__('cp.users')}}</span>
                    </a>
                </li>
            @endif

            @if(can('products'))
                <li class="menu-item {{(explode("/", request()->url())[5] == "products")  || (explode("/", request()->url())[5] == "productsQuantites") ? "menu-item-here" : ''}}"
                    aria-haspopup="true">
                    <a href="{{url(getLocal().'/admin/products')}}" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="512"
                             height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                             xml:space="preserve">
                            <g>
                                <path fill-rule="evenodd"
                                      d="M256 89.632c48.712 0 88.201 39.489 88.201 88.2 0 48.712-39.489 88.2-88.201 88.2s-88.199-39.488-88.199-88.2c0-48.71 39.487-88.2 88.199-88.2zm8 250.154v165.519l163.27-63.483V338.314l-127.664 49.64c-3.713 1.436-7.844-.098-9.775-3.441zm-16 165.518V339.786l-25.824 44.73a7.982 7.982 0 0 1-10.114 3.307l-127.33-49.509v103.507zm183.775-255.128L267.56 314.028l32.663 56.574 164.216-63.852zM244.44 314.028 80.224 250.176 47.561 306.75l164.217 63.852zM256 282.032c-43.803 0-81.293-27.028-96.703-65.317l-60.563 23.548L256 301.413l157.266-61.15-60.563-23.548c-15.409 38.288-52.899 65.317-96.703 65.317zm161.031-110.094c4.42 0 8 3.582 8 8s-3.58 8-8 8h-37.467a8 8 0 0 1 0-16zM248 14.696a8 8 0 0 1 16 0v37.469a8 8 0 0 1-16 0zm-80.757 24.771a7.966 7.966 0 0 1 13.813-7.937l18.734 32.449a7.966 7.966 0 0 1-13.813 7.937zm-57.576 61.88a7.981 7.981 0 0 1 8-13.812l32.448 18.734a7.982 7.982 0 0 1-8 13.812zm-18.909 82.38a8 8 0 0 1 0-16h37.468c4.419 0 8 3.582 8 8s-3.581 8-8 8zM330.38 33.635a7.968 7.968 0 0 1 10.876-2.938 7.967 7.967 0 0 1 2.938 10.875L325.46 74.021a7.965 7.965 0 1 1-13.813-7.937zm61.849 57.546a7.981 7.981 0 0 1 8 13.812l-32.449 18.734c-3.813 2.209-8.697.907-10.906-2.906s-.906-8.697 2.906-10.906zM289.396 137.61l-52.247 52.248-17.83-22.438c-4.386-5.518-12.414-6.434-17.931-2.049-5.518 4.387-6.435 12.414-2.048 17.932l26.238 33.019c4.537 6.499 13.88 7.388 19.534 1.733l62.364-62.363c4.991-4.993 4.991-13.088 0-18.082-4.992-4.992-13.087-4.992-18.08 0z"
                                      clip-rule="evenodd" fill="#000000" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                    </span>

                        <span class="menu-text">{{__('cp.products')}}</span>
                    </a>
                </li>
            @endif
            @if(can('orders'))
                <li class="menu-item {{(explode("/", request()->url())[5] == "orders") ? "menu-item-here" : ''}}"
                    aria-haspopup="true">
                    <a href="{{url(getLocal().'/admin/orders')}}" class="menu-link">

                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                        <span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Devices\Server.svg-->
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
                        </span>
                        <!--end::Svg Icon-->

                        <span class="menu-text">{{__('cp.orders')}}</span>
                        @php
                            $count=App\Models\Order::query()->where('status', 0)->where('payment_status', 1)->count();
                        @endphp
                        @if($count > 0)
                            <span style="
                                    background-color: #dc3545;
                                    color: white;
                                    font-size: 12px;
                                    width: 22px;
                                    height: 22px;
                                    border-radius: 50%;
                                    font-weight: bold;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    line-height: 1;
                                    text-align: center;
                                ">
                                    {{ $count }}
                                </span>
                        @endif
                    </a>
                </li>
            @endif

            @if(can('reports'))
                <li class="menu-item menu-item-submenu  {{(explode("/", request()->url())[5] == "reports") || (explode("/", request()->url())[5] == "usersOrdersReports") ||(explode("/", request()->url())[5] == "salesByCountry")? "menu-item-open" : ''}}" aria-haspopup="true"
                    data-menu-toggle="">
                    <a href="javascript:" class="menu-link menu-toggle">
                   <span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Devices\Server.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M61 15v392c0 8.291 6.709 15 15 15h270c8.291 0 15-6.709 15-15V15c0-8.291-6.709-15-15-15H76c-8.291 0-15 6.709-15 15zm240 331h-60c-8.291 0-15-6.709-15-15s6.709-15 15-15h60c8.291 0 15 6.709 15 15s-6.709 15-15 15zM121 76h90c8.291 0 15 6.709 15 15s-6.709 15-15 15h-90c-8.291 0-15-6.709-15-15s6.709-15 15-15zm0 60h180c8.291 0 15 6.709 15 15s-6.709 15-15 15H121c-8.291 0-15-6.709-15-15s6.709-15 15-15zm0 60h180c8.291 0 15 6.709 15 15s-6.709 15-15 15H121c-8.291 0-15-6.709-15-15s6.709-15 15-15zm0 60h180c8.291 0 15 6.709 15 15s-6.709 15-15 15H121c-8.291 0-15-6.709-15-15s6.709-15 15-15z" fill="#000000" opacity="1" data-original="#000000" class=""></path><path d="M166 512h270c8.291 0 15-6.709 15-15V106c0-8.291-6.709-15-15-15h-45v316c0 24.814-20.186 45-45 45H151v45c0 8.291 6.709 15 15 15z" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg>
                        </span>

                        <span class="menu-text">{{__('cp.reports')}}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">

                        <ul class="menu-subnav">

                            <li class="menu-item {{(explode("/", request()->url())[5] == "reports") ? "menu-item-here" : ''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.reports') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.generalReports')}}</span>
                                </a>
                            </li>
                            <li class="menu-item  {{(explode("/", request()->url())[5] == "salesByCountry") ? "menu-item-here" :''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.salesByCountry') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.salesByCountry')}} </span>
                                </a>
                            </li>
                            <li class="menu-item  {{(explode("/", request()->url())[5] == "usersOrdersReports") ? "menu-item-here" :''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.usersOrdersReports') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.usersOrdersReports')}} </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif
            @if(can('banners'))
                <li class="menu-item menu-item-submenu  {{(explode("/", request()->url())[5] == "banners") ||(explode("/",
                request()->url())[5] == "bannerAd") ||(explode("/", request()->url())[5] == "adPopUp")? "menu-item-open" : ''}}" aria-haspopup="true"
                    data-menu-toggle="">
                    <a href="javascript:" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                       <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Devices\Display1.svg--><svg
                            xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0"
                            viewBox="0 0 512 512"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path
                                d="M114.758 44.137v99.289l19.82-36.348a17.641 17.641 0 0 1 15.492-9.203h.012a17.647 17.647 0 0 1 15.492 9.191l24.637 45.176 14.984-27.484a17.658 17.658 0 0 1 15.5-9.203c6.461 0 12.407 3.53 15.5 9.203l19.82 36.37L256 44.138zm79.449 61.793c-14.625 0-26.484-11.856-26.484-26.48 0-14.63 11.859-26.485 26.484-26.485s26.484 11.855 26.484 26.484c-.02 14.617-11.863 26.465-26.484 26.48zm0 0"
                                fill="#000000" data-original="#000000" class=""></path>
                            <path
                                d="M114.758 180.305v5.074h73.402l-38.082-69.852zM200.262 170.68l8.015 14.699h40.848l-28.434-52.172zM203.035 79.45a8.829 8.829 0 1 1-17.658-.002 8.829 8.829 0 0 1 17.658.001zm0 0"
                                fill="#000000" data-original="#000000" class=""></path>
                            <path
                                d="M503.172 0H8.828A8.829 8.829 0 0 0 0 8.828v211.863c0 4.875 3.953 8.825 8.828 8.825h494.344c4.875 0 8.828-3.95 8.828-8.825V8.828A8.829 8.829 0 0 0 503.172 0zM76.863 143.828a8.83 8.83 0 0 1-3.898 14.89 8.835 8.835 0 0 1-8.586-2.41L29.07 121a8.829 8.829 0 0 1 0-12.484L64.38 73.207a8.828 8.828 0 0 1 12.375.11 8.824 8.824 0 0 1 .11 12.37l-29.071 29.07zm196.793 41.55a17.52 17.52 0 0 1-4.187 11.282c-.106.14-.219.266-.336.406a17.546 17.546 0 0 1-13.133 5.97H114.758c-9.746-.013-17.645-7.911-17.656-17.657V44.137c.011-9.746 7.91-17.645 17.656-17.653H256c9.746.008 17.645 7.907 17.656 17.653zm70.621-26.48h-44.14a8.829 8.829 0 0 1 0-17.656h44.14c4.875 0 8.825 3.953 8.825 8.828s-3.95 8.828-8.825 8.828zm26.48-35.312h-70.62a8.829 8.829 0 0 1 0-17.656h70.62a8.829 8.829 0 0 1 0 17.656zm26.485-35.309h-97.105a8.829 8.829 0 0 1 0-17.656h97.105a8.829 8.829 0 0 1 0 17.656zm17.656-35.312H300.137a8.829 8.829 0 0 1 0-17.656h114.761c4.875 0 8.825 3.953 8.825 8.828s-3.95 8.828-8.825 8.828zM482.93 121l-35.309 35.309a8.829 8.829 0 0 1-12.484-12.48l29.07-29.071-29.07-29.07a8.824 8.824 0 0 1 .11-12.372 8.828 8.828 0 0 1 12.374-.109l35.309 35.309a8.829 8.829 0 0 1 0 12.484zM220.691 317.793c0 9.75-7.906 17.656-17.656 17.656s-17.656-7.906-17.656-17.656 7.906-17.656 17.656-17.656 17.656 7.906 17.656 17.656zM326.621 317.793c0 9.75-7.906 17.656-17.656 17.656s-17.656-7.906-17.656-17.656 7.906-17.656 17.656-17.656 17.656 7.906 17.656 17.656zM432.55 317.793c0 9.75-7.902 17.656-17.652 17.656-9.753 0-17.656-7.906-17.656-17.656s7.903-17.656 17.656-17.656c9.75 0 17.653 7.906 17.653 17.656zM150.07 317.793c0-29.25-23.715-52.965-52.968-52.965-29.25 0-52.965 23.715-52.965 52.965 0 29.254 23.715 52.965 52.965 52.965 29.246-.024 52.945-23.723 52.968-52.965zm-70.62 0c0-9.75 7.902-17.656 17.652-17.656 9.753 0 17.656 7.906 17.656 17.656s-7.903 17.656-17.656 17.656c-9.739-.031-17.625-7.918-17.653-17.656zm0 0"
                                fill="#000000" data-original="#000000" class=""></path>
                        </g>
                    </svg>
                        <!--end::Svg Icon-->
                    </span>
                        <span class="menu-text">{{__('cp.banners')}}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">

                        <ul class="menu-subnav">

                            <li class="menu-item {{(explode("/", request()->url())[5] == "banners") ? "menu-item-here" : ''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.banners.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.bannerSlider')}}</span>
                                </a>
                            </li>
                            <li class="menu-item  {{(explode("/", request()->url())[5] == "bannerAd") ? "menu-item-here" :''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.bannerAd') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.bannerAd')}} </span>
                                </a>
                            </li>
                            <li class="menu-item  {{(explode("/", request()->url())[5] == "adPopUp") ? "menu-item-here" :''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.adPopUp') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.adPopUp')}} </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif
            @if(can('categories'))
                <li class="menu-item menu-item-submenu  {{(explode("/", request()->url())[5] == "categories") ||(explode("/",
                request()->url())[5] == "subCategories") ? "menu-item-open" : ''}}" aria-haspopup="true"
                    data-menu-toggle="">
                    <a href="javascript:" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                       <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="512"
                            height="512" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512"
                            xml:space="preserve"
                            class="">
                        <g>
                            <path
                                d="M4 40.962c0 .36.19.69.5.871l15 8.66V32.582L4 23.621zM11.68 18.023 5 21.878l15.5 8.971 6.68-3.865zM36 21.878l-15-8.661a.992.992 0 0 0-1 0l-6.32 3.645 15.5 8.96zM21.5 50.494l15-8.661c.31-.18.5-.51.5-.871V23.62l-15.5 8.961zM52.14 33.002c1.197 4.48 7.802 3.686 7.86-1.001a4.001 4.001 0 0 0-4-4.005c-1.86 0-3.41 1.281-3.86 3.003H48V10.974c0-.55.45-1.001 1-1.001h3.14c.45 1.722 2 3.004 3.86 3.004 2.21 0 4-1.793 4-4.005-.057-4.676-6.657-5.492-7.86-1.002H49c-1.65 0-3 1.352-3 3.004V31h-5c-.55 0-1 .451-1 1.002s.45 1 1 1h5v20.026a3.01 3.01 0 0 0 3 3.004h3.14c1.192 4.47 7.8 3.697 7.86-1.001-.066-4.7-6.662-5.474-7.86-1.001H49c-.55 0-1-.451-1-1.002V33.002h4.14z"
                                fill="#000000" opacity="1" data-original="#000000" class=""></path>
                        </g>
                    </svg>
                    </span>
                        <span class="menu-text">{{__('cp.categories')}}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">

                        <ul class="menu-subnav">

                            <li class="menu-item {{(explode("/", request()->url())[5] == "categories") ? "menu-item-here" : ''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.categories.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.main_categories')}}</span>
                                </a>
                            </li>
                            <li class="menu-item  {{(explode("/", request()->url())[5] == "subCategories") ? "menu-item-here" :''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.subCategories.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.subCategories')}} </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif
            @if(can('promoCodes'))
                <li class="menu-item {{(explode("/", request()->url())[5] == "promoCodes") ? "menu-item-here" : ''}}"
                    aria-haspopup="true">
                    <a href="{{url(getLocal().'/admin/promoCodes')}}" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Shopping\ATM.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                             xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0"
                             viewBox="0 0 32 32"
                             style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <g>
                                <path
                                    d="M9.19 17.55a.61.61 0 0 0-.42-.17.59.59 0 0 0-.42.17.58.58 0 0 0 0 .84.6.6 0 0 0 .84 0 .6.6 0 0 0 0-.84z"
                                    fill="#000000" data-original="#000000"></path>
                                <path
                                    d="m28.24 9.33.32-.2a8.82 8.82 0 0 0 1.21-1 4.19 4.19 0 1 0-5.92-5.92 11.79 11.79 0 0 0-1.17 1.53l1.94.65a6.06 6.06 0 0 1 .64-.77 2.24 2.24 0 0 1 3.1 0A2.18 2.18 0 0 1 29 5.19a2.21 2.21 0 0 1-.64 1.55 7.56 7.56 0 0 1-.77.63L27 5.62a1 1 0 0 0-.62-.62l-1.76-.58c-1.12 1.52-2.39 4.1-2.39 5.1a.68.68 0 0 0 .05.27 1 1 0 0 1-.71 1.68 1 1 0 0 1-.73-.3c-1.56-1.56.38-5.25 1.84-7.4L17.35 2a1 1 0 0 0-1 .24l-15 15a1 1 0 0 0 0 1.42l12 12A1 1 0 0 0 14 31a1.05 1.05 0 0 0 .71-.29l15-15a1 1 0 0 0 .24-1zM10.6 19.81a2.6 2.6 0 0 1-3.67-3.67 2.66 2.66 0 0 1 3.67 0 2.6 2.6 0 0 1 0 3.67zm4.4 5.68a1 1 0 0 1-2 0v-15a1 1 0 0 1 2 0zm6.1-5.68a2.6 2.6 0 0 1-3.67-3.67 2.6 2.6 0 0 1 3.67 3.67z"
                                    fill="#000000" data-original="#000000"></path>
                                <path d="M19.29 17.38a.58.58 0 0 0-.42.17.59.59 0 1 0 .84 0 .57.57 0 0 0-.42-.17z"
                                      fill="#000000"
                                      data-original="#000000"></path>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                        <span class="menu-text">{{__('cp.promoCodes')}}</span>
                    </a>
                </li>
            @endif
            @if(can('shippingManagement'))
                <li class="menu-item menu-item-submenu  {{(explode("/", request()->url())[5] == "shippingContent") ||(explode("/",
                request()->url())[5] == "shippingPrices") ? "menu-item-open" : ''}}" aria-haspopup="true"
                    data-menu-toggle="">
                    <a href="javascript:" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="512"
                             height="512" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512"
                             xml:space="preserve">
                            <g>
                                <path d="M24 19h3.465a1 1 0 0 1 .832.445L30 22h-6z" fill="#000000" opacity="1"
                                      data-original="#000000"></path>
                                <circle cx="11" cy="28" r="2" fill="#000000" opacity="1"
                                        data-original="#000000"></circle>
                                <path
                                    d="M23 25.78V18a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h2c0-1.654 1.346-3 3-3s3 1.346 3 3h8c0-.883.39-1.67 1-2.22zM24 23v2.184A2.965 2.965 0 0 1 25 25c1.654 0 3 1.346 3 3h1a1 1 0 0 0 1-1v-4z"
                                    fill="#000000" opacity="1" data-original="#000000"></path>
                                <circle cx="25" cy="28" r="2" fill="#000000" opacity="1"
                                        data-original="#000000"></circle>
                                <path
                                    d="M18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8c0 2.39 1.06 4.533 2.726 6H9.5v-.55A2.998 2.998 0 0 1 7 12.5a.5.5 0 1 1 1 0c0 1.103.897 2 2 2s2-.897 2-2-.897-2-2-2c-1.654 0-3-1.346-3-3a2.998 2.998 0 0 1 2.5-2.95V3.5a.5.5 0 1 1 1 0v1.05A2.998 2.998 0 0 1 13 7.5a.5.5 0 1 1-1 0c0-1.103-.897-2-2-2s-2 .897-2 2 .897 2 2 2c1.654 0 3 1.346 3 3a2.998 2.998 0 0 1-2.5 2.95V16h4.774A7.976 7.976 0 0 0 18 10z"
                                    fill="#000000" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                    </span>
                        <span class="menu-text">{{__('cp.shippingManagement')}}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">

                        <ul class="menu-subnav">

                            <li class="menu-item {{(explode("/", request()->url())[5] == "shippingContent") ? "menu-item-here" : ''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.shipping.content') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.shipping_content')}}</span>
                                </a>
                            </li>
                            <li class="menu-item  {{(explode("/", request()->url())[5] == "shippingPrices") ? "menu-item-here" :''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.shipping.prices') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.shipping_prices')}} </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif
            @if(can('variants'))
                <li class="menu-item menu-item-submenu  {{(explode("/", request()->url())[5] == "sizes") ||(explode("/",
                request()->url())[5] == "colors") ? "menu-item-open" : ''}}" aria-haspopup="true"
                    data-menu-toggle="">
                    <a href="javascript:" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="512" height="512" x="0" y="0" viewBox="0 0 302.172 302.172"
                             style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path
                                    d="M256.422 247.176c16.373 0 29.536-11.164 39.126-33.171 8.43-19.346 8.813-35.082 1.149-46.784-4.909-7.487-13.022-13.054-24.177-16.735 20.998-6.654 33.166-22.339 20.277-55.122-12.893-32.806-32.503-36.042-52.418-26.597 4.604-8.319 7.224-16.782 6.747-25.019-.896-15.462-12.039-27.954-33.119-37.137-24.503-10.667-43.227-8.313-54.966 6.379-3.691 4.619-6.462 10.317-8.541 16.676-6.648-21.013-22.333-33.2-55.134-20.303-32.816 12.901-36.04 32.521-26.58 52.446-7.664-4.235-15.431-6.835-23.04-6.835-16.373 0-29.539 11.161-39.126 33.171-8.425 19.338-8.813 35.082-1.147 46.779 4.906 7.493 13.023 13.054 24.174 16.73C8.651 158.315-3.517 174 9.374 206.782c12.894 32.804 32.503 36.04 52.418 26.595-4.601 8.321-7.226 16.782-6.75 25.021.896 15.461 12.042 27.951 33.119 37.137 10.095 4.396 19.291 6.628 27.322 6.628h.01c11.438 0 20.733-4.375 27.628-13.007 3.689-4.619 6.463-10.325 8.541-16.685 6.649 21.008 22.334 33.202 55.137 20.304 32.814-12.898 36.04-32.519 26.58-52.443 7.669 4.245 15.436 6.839 23.043 6.844zM167.333 19.614c4.852-6.077 11.185-9.025 19.355-9.025 6.561 0 14.333 1.937 23.089 5.748 17.114 7.457 26.113 16.883 26.761 28.024 1.486 25.546-38.82 58.417-66.062 76.769a301.3 301.3 0 0 0 5.51-11.941c10.46-24.003 16.047-44.721 12.484-46.274s-14.929 16.65-25.383 40.653a303.291 303.291 0 0 0-3.791 9.093c-4.049-27.265-7.856-73.153 8.037-93.047zm-5.06 106.868c-.202.127-.409.262-.605.389-.042-.218-.089-.5-.13-.728.243.107.492.218.735.339zm-147.915 2.636c-5.584-8.521-4.912-20.881 1.999-36.733C24.103 74.6 33.999 65.58 45.758 65.58c24.387 0 54.95 36.475 73.247 62.992a307.864 307.864 0 0 0-9.057-4.114C85.945 114 65.228 108.413 63.674 111.976c-1.553 3.562 16.65 14.926 40.653 25.383a314.113 314.113 0 0 0 12.065 4.953c-12.345 1.944-29.588 4.039-46.657 4.039h-.005c-28.845-.006-47.991-5.96-55.372-17.233zm120.487 153.42c-4.852 6.069-11.179 9.021-19.345 9.021h-.01c-6.568 0-14.336-1.937-23.092-5.748-17.111-7.456-26.113-16.886-26.761-28.023-1.432-24.57 35.802-55.908 62.886-74.602a307.43 307.43 0 0 0-3.298 7.307c-10.455 24.006-16.044 44.724-12.479 46.276 3.562 1.554 14.926-16.652 25.38-40.653a312.398 312.398 0 0 0 4.221-10.19c4.206 26.645 9.109 75.832-7.502 96.612zm39.229-73.017c-2.444.963-9.683-11.619-16.166-28.102a233.375 233.375 0 0 1-2.081-5.53c-.187.042-.373.083-.564.13a381.23 381.23 0 0 0-2.105 10.19 359.652 359.652 0 0 0-1.61-9.688c-.562.036-1.113.124-1.686.124-1.325 0-2.62-.207-3.92-.403-2.216-.342-4.401-.865-6.496-1.776-1.851-.808-3.537-1.858-5.121-3.034-1.129-.839-2.222-1.72-3.198-2.719a368.218 368.218 0 0 0-7.185 4.77 379.925 379.925 0 0 0 5.196-7.271c-.562-.74-1.119-1.476-1.598-2.284a241.298 241.298 0 0 1-5.041 2.062c-16.479 6.483-30.621 9.75-31.586 7.307-.96-2.444 11.623-9.679 28.102-16.161a227.446 227.446 0 0 1 5.17-1.952c-.021-.124-.021-.254-.041-.378a350.573 350.573 0 0 0-8.241-1.678c2.91-.445 5.6-.886 7.995-1.305-.111-2.211-.031-4.42.425-6.6.323-1.538.818-3.042 1.421-4.523.081-.191.106-.394.192-.583.09-.207.217-.388.313-.595a25.997 25.997 0 0 1 3.493-5.566 26.309 26.309 0 0 1 2.327-2.449c.334-.313.676-.622 1.025-.912-.005-.013-.016-.023-.021-.034a398.348 398.348 0 0 0-4.407-6.623 407.739 407.739 0 0 0 6.711 4.806c.5-.36.971-.738 1.497-1.062a218.133 218.133 0 0 1-2.439-5.939c-6.48-16.479-9.75-30.621-7.307-31.587 2.444-.963 9.681 11.625 16.161 28.104.8 2.04 1.553 4.047 2.252 5.991.601-.116 1.214-.132 1.82-.212a390.66 390.66 0 0 0 1.649-8.101c.435 2.843.864 5.473 1.276 7.827.044.254.085.482.134.73a26.34 26.34 0 0 1 4.306.445c1.9.362 3.76.894 5.562 1.678 2.082.906 3.904 2.115 5.613 3.451a25.814 25.814 0 0 1 4.086 4.039c.315-.199.646-.417.968-.629a372.771 372.771 0 0 0 7.265-4.826 375.443 375.443 0 0 0-5.266 7.381c1.849-.79 3.77-1.58 5.748-2.361 16.477-6.478 30.618-9.751 31.581-7.307s-11.62 9.683-28.102 16.164a203.287 203.287 0 0 1-6.027 2.263c.145.733.196 1.458.274 2.19a363.73 363.73 0 0 0 9.838 2.022 374.238 374.238 0 0 0-9.6 1.59c-.238.041-.487.083-.715.124-.005 1.093-.191 2.186-.337 3.283-.315 2.346-.833 4.681-1.827 6.959-.715 1.646-1.642 3.154-2.657 4.588-.378.544-.745 1.088-1.165 1.601-.145.165-.279.336-.424.507-.415.445-.829.881-1.274 1.3-.181.182-.347.368-.528.539a362.981 362.981 0 0 0 5.759 8.714 396.953 396.953 0 0 0-8.793-6.25c-.104.078-.202.166-.306.233a224.335 224.335 0 0 1 2.352 5.743c6.495 16.485 9.768 30.627 7.323 31.585zm7.069-38.929a306.035 306.035 0 0 0 10.118 4.629c24.006 10.455 44.724 16.047 46.276 12.484 1.554-3.567-16.652-14.929-40.653-25.383a283.521 283.521 0 0 0-7.265-3.05c11.972-1.766 27.438-3.475 42.833-3.475 28.837 0 47.986 5.96 55.37 17.232 5.587 8.519 4.914 20.884-1.999 36.733-7.746 17.787-17.637 26.808-29.401 26.808-25.316-.003-57.29-39.311-75.279-65.978z"
                                    fill="#000000" opacity="1" data-original="#000000"></path><path
                                    d="M164.857 164.891a21.135 21.135 0 0 0 1.62-1.911c.959-1.273 1.808-2.63 2.465-4.132.928-2.123 1.373-4.318 1.559-6.504.021-.196.058-.394.068-.59.093-1.678.057-3.34-.244-4.964-.083-.44-.264-.856-.367-1.292a20.545 20.545 0 0 0-1.14-3.357 20.723 20.723 0 0 0-1.9-3.399 20.12 20.12 0 0 0-1.403-1.802c-.678-.779-1.434-1.484-2.227-2.165-1.522-1.292-3.185-2.459-5.101-3.296-1.651-.717-3.37-1.137-5.113-1.411-.541-.085-1.093-.127-1.644-.171-.516-.036-1.021-.158-1.543-.158-.813 0-1.608.085-2.398.173-.505.06-.997.14-1.483.233a20.796 20.796 0 0 0-5.691 1.973 25.34 25.34 0 0 0-1.16.647c-1.126.678-2.196 1.437-3.177 2.322-.026.028-.049.054-.081.08-.486.44-.937.922-1.377 1.406-1.507 1.654-2.786 3.542-3.713 5.667-.663 1.527-1.077 3.107-1.362 4.705a20.505 20.505 0 0 0-.324 3.932c.016.845.085 1.688.202 2.522.127.911.354 1.812.603 2.708.192.684.318 1.377.583 2.045a21.127 21.127 0 0 0 1.771 3.47c.039.057.06.13.096.187.95 1.476 2.133 2.76 3.41 3.94.355.331.728.637 1.103.938 1.427 1.144 2.954 2.169 4.671 2.92 1.962.854 4.016 1.284 6.105 1.513.73.077 1.452.228 2.192.228.241 0 .469-.047.702-.058a20.793 20.793 0 0 0 3.521-.435 19.92 19.92 0 0 0 2.526-.679 21.198 21.198 0 0 0 5.593-2.945 20.223 20.223 0 0 0 2.438-2.123c.081-.072.153-.14.22-.217z"
                                    fill="#000000" opacity="1" data-original="#000000"></path></g></svg>
                        <!--end::Svg Icon-->
                    </span>
                        <span class="menu-text">{{__('cp.variants_management')}}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">

                        <ul class="menu-subnav">

                            <li class="menu-item {{(explode("/", request()->url())[5] == "colors") ? "menu-item-here" : ''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.colors.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.colors')}}</span>
                                </a>
                            </li>
                            <li class="menu-item  {{(explode("/", request()->url())[5] == "sizes") ? "menu-item-here" :''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.sizes.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.sizes')}} </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif
            @if(can('faqs'))
                <li class="menu-item {{(explode("/", request()->url())[5] == 'faqs') ? 'menu-item-here' : ''}}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="{{url(getLocal().'/admin/faqs')}}" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Question-circle.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                             version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                <path
                                    d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z"
                                    fill="#000000"/>
                            </g>
                        </svg>
                    </span>
                        <span class="menu-text">{{__('cp.faqs')}}</span>
                    </a>
                </li>
            @endif
            @if(can('newsletterManagement'))
                <li class="menu-item menu-item-submenu  {{(explode("/", request()->url())[5] == "subscribers") ||(explode("/",
                request()->url())[5] == "newsletters") ? "menu-item-open" : ''}}" aria-haspopup="true"
                    data-menu-toggle="">
                    <a href="javascript:" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                       <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="512"
                            height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                            xml:space="preserve">
                        <g>
                            <path fill-rule="evenodd"
                                  d="M128.81 0h223.34c19.35 0 35.48 15.72 35.48 35.07v171.34A3.61 3.61 0 0 1 384 210H234a33.81 33.81 0 0 0-33.87 33.87V406a33.21 33.21 0 0 0 33.09 33H384a3.55 3.55 0 0 1 3.63 3.23v34.26A35.8 35.8 0 0 1 352.15 512H38.9c-19.35 0-35.07-16.13-35.07-35.48V124.57c0-2 1.21-3.63 3.23-3.63h75.79a42.32 42.32 0 0 0 42.33-42.33V3.23c0-2 1.61-3.23 3.63-3.23zm361.62 224.15H234a19.79 19.79 0 0 0-19.76 19.76V406a18.85 18.85 0 0 0 18.95 18.55h256.44A18.76 18.76 0 0 0 508.17 406V241.89a17.89 17.89 0 0 0-17.74-17.74zm-18.54 26.21c6.85-6.86 16.93 3.22 10.08 10.07l-61.69 61.69a3.66 3.66 0 0 0 0 4.83L482 388.64c6.85 6.45-3.23 16.53-10.08 10.07L410.2 337c-1.2-1.61-3.22-1.61-4.83 0l-18.55 18.55a35.76 35.76 0 0 1-50.79 0l-18.95-18.95a3.68 3.68 0 0 0-4.84 0l-61.68 62.08c-6.45 6.46-16.53-3.62-10.08-10.07l61.68-62.09a3.68 3.68 0 0 0 0-4.84L240.48 260c-6.45-6.45 3.63-16.53 10.08-10.08l95.54 95.58a21.65 21.65 0 0 0 30.64 0zM93.73 262.85c-9.27 0-9.27-14.11 0-14.11h68.94c9.27 0 9.27 14.11 0 14.11zm0 75c-9.27 0-9.27-14.11 0-14.11h68.94c9.27 0 9.27 14.11 0 14.11zm0 75.39c-9.27 0-9.27-14.52 0-14.52h68.94c9.27 0 9.27 14.52 0 14.52zm17.34-334.63V25.4c0-3.23-3.63-4.84-5.65-2.42l-78.21 78.21c-2.42 2-.8 5.64 2.42 5.64h53.22a28.57 28.57 0 0 0 28.22-28.22z"
                                  fill="#000000" opacity="1" data-original="#000000"></path>
                        </g>
                    </svg>
                        <!--end::Svg Icon-->
                    </span>
                        <span class="menu-text">{{__('cp.newsletter_management')}}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">

                        <ul class="menu-subnav">

                            <li class="menu-item {{(explode("/", request()->url())[5] == "subscribers") ? "menu-item-here" : ''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.subscribers.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.subscribers')}}</span>
                                </a>
                            </li>
                            <li class="menu-item  {{(explode("/", request()->url())[5] == "newsletters") ? "menu-item-here" :''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.newsletters.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.newsletters')}} </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif

            @if(can('notificationManagement'))
                <li class="menu-item menu-item-submenu  {{(explode("/", request()->url())[5] == "emailTexts") ||(explode("/", request()->url())[5] == "manual_emails") ? "menu-item-open" : ''}}" aria-haspopup="true"
                    data-menu-toggle="">
                    <a href="javascript:" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                       <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M254.466 481.94c-60.801 0-110.266-49.465-110.266-110.266 0-8.284-6.716-15-15-15s-15 6.716-15 15c0 77.343 62.923 140.266 140.266 140.266 8.284 0 15-6.716 15-15s-6.716-15-15-15z" fill="#000000" opacity="1" data-original="#000000"></path><path d="M254.467 421.94c-27.717 0-50.267-22.549-50.267-50.266 0-8.284-6.716-15-15-15s-15 6.716-15 15c0 44.259 36.008 80.266 80.267 80.266 8.284 0 15-6.716 15-15s-6.716-15-15-15zM377.827 147.172c11.098 0 21.906 1.267 32.287 3.662V8.655L234.559 150.336a47.114 47.114 0 0 1-29.502 10.422 47.124 47.124 0 0 1-29.502-10.422L0 8.655V244.3c0 9.371 7.597 16.968 16.967 16.968h220.361c13.621-65.073 71.44-114.096 140.499-114.096zM377.827 450.307c20.936 0 38.02-16.759 38.57-37.566h-77.14c.55 20.807 17.634 37.566 38.57 37.566z" fill="#000000" opacity="1" data-original="#000000"></path><path d="M497 352.742a5.64 5.64 0 0 1-5.633-5.633v-56.397c0-62.606-50.934-113.54-113.54-113.54s-113.54 50.934-113.54 113.54v56.397a5.64 5.64 0 0 1-5.633 5.633c-8.284 0-15 6.716-15 15s6.716 15 15 15H497c8.284 0 15-6.716 15-15s-6.716-15-15-15zM205.057 130.758c3.774 0 7.549-1.255 10.658-3.765L372.952.06H37.162l157.237 126.933a16.938 16.938 0 0 0 10.658 3.765z" fill="#000000" opacity="1" data-original="#000000"></path></g></svg>
                        <!--end::Svg Icon-->
                    </span>
                        <span class="menu-text">{{__('cp.notification_management')}}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">

                        <ul class="menu-subnav">

                            <li class="menu-item {{(explode("/", request()->url())[5] == "emailTexts") ? "menu-item-here" : ''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.emailTexts.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.emailTexts')}}</span>
                                </a>
                            </li>
                            <li class="menu-item  {{(explode("/", request()->url())[5] == "manual_emails") ? "menu-item-here" :''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.manual_emails.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.manual_emails')}} </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif

            @if(can('contact'))
                <li class="menu-item {{(explode("/", request()->url())[5] == "contact") || (explode("/", request()->url())[5] ==
                    "viewMessage") ? "menu-item-here" : ''}}"
                    aria-haspopup="true">
                    <a href="{{url(getLocal().'/admin/contact')}}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Chat4.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path
                                        d="M21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L5,18 C3.34314575,18 2,16.6568542 2,15 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 Z M6.16794971,10.5547002 C7.67758127,12.8191475 9.64566871,14 12,14 C14.3543313,14 16.3224187,12.8191475 17.8320503,10.5547002 C18.1384028,10.0951715 18.0142289,9.47430216 17.5547002,9.16794971 C17.0951715,8.86159725 16.4743022,8.98577112 16.1679497,9.4452998 C15.0109146,11.1808525 13.6456687,12 12,12 C10.3543313,12 8.9890854,11.1808525 7.83205029,9.4452998 C7.52569784,8.98577112 6.90482849,8.86159725 6.4452998,9.16794971 C5.98577112,9.47430216 5.86159725,10.0951715 6.16794971,10.5547002 Z"
                                        fill="#000000"/>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-text">{{__('cp.contact')}}</span>
                        @php
                            $count=App\Models\Contact::query()->where('read',0)->count();
                        @endphp
                        @if($count > 0)
                            <span style="
                                    background-color: #dc3545;
                                    color: white;
                                    font-size: 12px;
                                    width: 22px;
                                    height: 22px;
                                    border-radius: 50%;
                                    font-weight: bold;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    line-height: 1;
                                    text-align: center;
                                ">
                                    {{ $count }}
                                </span>

                        @endif
                    </a>
                </li>
            @endif
            @if(can('pages'))
                <li class="menu-item {{(explode("/", request()->url())[5] == "pages") ? "menu-item-here" : ''}}"
                    aria-haspopup="true">
                    <a href="{{url(getLocal().'/admin/pages')}}" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                             xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0"
                             viewBox="0 0 426.667 426"
                             style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path
                                    d="M426.668 64.332V53.668c-.035-29.441-23.895-53.3-53.336-53.336h-320C23.891.367.035 24.227 0 53.668v10.664zM0 85.668V331c.035 29.441 23.89 53.3 53.332 53.332h320c29.441-.031 53.3-23.89 53.336-53.332V85.668zm64 74.664c0-2.828 1.121-5.543 3.121-7.543a10.66 10.66 0 0 1 7.547-3.121H160a10.65 10.65 0 0 1 7.543 3.121c2.004 2 3.125 4.715 3.125 7.543v64A10.664 10.664 0 0 1 160 235H74.668a10.676 10.676 0 0 1-7.547-3.121A10.676 10.676 0 0 1 64 224.332zM352 299H74.668C68.778 299 64 294.223 64 288.332s4.777-10.664 10.668-10.664H352c5.89 0 10.668 4.773 10.668 10.664S357.891 299 352 299zm0-64H224c-5.89 0-10.668-4.777-10.668-10.668s4.777-10.664 10.668-10.664h128c5.89 0 10.668 4.773 10.668 10.664S357.891 235 352 235zm0-64H224c-5.89 0-10.668-4.777-10.668-10.668s4.777-10.664 10.668-10.664h128c5.89 0 10.668 4.773 10.668 10.664S357.891 171 352 171zm0 0"
                                    fill="#000000" data-original="#000000" class=""></path>
                                <path d="M85.332 171h64v42.668h-64zm0 0" fill="#000000" data-original="#000000"
                                      class=""></path>
                            </g>
                        </svg></span>
                        <span class="menu-text">{{__('cp.pages')}}</span>
                    </a>
                </li>
            @endif
            @if(can('permissions'))
                <li class="menu-item {{(explode("/", request()->url())[5] == "permissions") ? "menu-item-here" : ''}}"
                    aria-haspopup="true">
                    <a href="{{ route('admins.permissions.index') }}" class="menu-link">
                                <span class="svg-icon menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" width="512"
                                         height="512" x="0" y="0" viewBox="0 0 511.999 511.999"
                                         style="enable-background:new 0 0 512 512"
                                         xml:space="preserve" class="">
                                        <g>
                                            <path
                                                d="M452.19 511.999h-75c-12.406 0-22.5-10.094-22.5-22.5V424.58c-11.96 9.955-24.647 18.744-35.698 25.772-27.767 17.66-59.826 33.214-81.676 39.624a12.844 12.844 0 0 1-7.254 0c-21.848-6.41-53.907-21.964-81.674-39.624-24.117-15.34-56.039-39.067-71.152-64.998-43.076-73.903-58.25-265.528-58.25-301.024 0-5.494 2.657-10.405 6.935-12.816C65.044 49.458 131.797 26.076 224.325 2.021 227.078 1.305 231.612 0 233.691 0s6.612 1.305 9.365 2.021c75.55 19.642 134.349 39.005 174.763 57.551a7.499 7.499 0 1 1-6.256 13.632c-39.617-18.18-97.581-37.245-172.281-56.667a873.044 873.044 0 0 1-5.591-1.464c-1.248.335-3.137.826-5.592 1.464C115.424 45.832 60.393 69.431 33.992 84.185a1.66 1.66 0 0 0-.006.146c0 33.427 15.309 223.299 56.209 293.472 10.608 18.201 34.135 39.472 66.243 59.894 26.424 16.806 56.649 31.555 77.252 37.712 20.604-6.158 50.83-20.907 77.252-37.712 32.108-20.422 55.634-41.692 66.243-59.894.154-.266.309-.533.463-.803h-.458a22.4 22.4 0 0 1-14.061-4.946c-20.819 33.019-88.355 73.14-126.881 86.741a7.5 7.5 0 0 1-1.883.419l-.012.001a8.287 8.287 0 0 1-.69.029h-.014a7.489 7.489 0 0 1-2.683-.508c-29.435-10.427-76.986-36.542-107.405-64.554a7.5 7.5 0 0 1 10.16-11.036c24.886 22.916 64.112 45.826 92.464 57.655l.002-198.803H81.01c8.476 48.465 20.146 95.032 35.104 120.696a7.5 7.5 0 0 1-2.703 10.256 7.498 7.498 0 0 1-10.256-2.703C66.137 306.736 51.315 139.32 49.372 97.963a7.5 7.5 0 0 1 4.185-7.083c38.571-18.954 98.485-39.062 178.085-59.765a7.521 7.521 0 0 1 1.862-.281H233.522c.111-.002.226-.002.337 0h.016a7.523 7.523 0 0 1 1.868.282c79.599 20.703 139.511 40.81 178.082 59.764a7.504 7.504 0 0 1 4.185 7.084c-.33 7.002-.857 15.195-1.546 24.035h14.944c1.453-18.85 1.987-31.672 1.987-37.669 0-.075-.005-.145-.012-.204a7.502 7.502 0 0 1 8.077-12.613c4.277 2.411 6.935 7.322 6.935 12.816 0 6.157-.526 19.05-1.952 37.773a7.501 7.501 0 0 1-1.252 14.896h-68c-4.136 0-7.5 3.364-7.5 7.5v75c0 4.136 3.364 7.5 7.5 7.5h75c4.136 0 7.5-3.364 7.5-7.5v-53.571l-37.165 37.166a7.502 7.502 0 0 1-10.607 0l-25.031-25.031a7.5 7.5 0 0 1 10.607-10.607l19.728 19.729 62.987-62.988a7.5 7.5 0 0 1 10.607 10.607l-16.126 16.125v68.571c0 12.406-10.094 22.5-22.5 22.5h-20.188a1080.84 1080.84 0 0 1-2.617 15h15.805c4.143 0 7.5 3.357 7.5 7.5s-3.357 7.5-7.5 7.5h-68c-4.136 0-7.5 3.364-7.5 7.5 0 0 .039 75.878.113 76.301.027.123.053.247.075.372.762 3.333 3.751 5.827 7.312 5.827h75c4.136 0 7.5-3.364 7.5-7.5v-53.571l-37.165 37.166a7.502 7.502 0 0 1-10.607 0l-25.031-25.031a7.5 7.5 0 0 1 10.607-10.607l19.728 19.729 62.987-62.988a7.5 7.5 0 0 1 10.607 10.607l-16.126 16.125V354.5c0 12.406-10.094 22.5-22.5 22.5h-57.532a152.737 152.737 0 0 1-4.514 8.355 96.762 96.762 0 0 1-4.261 6.645h59.307c4.143 0 7.5 3.357 7.5 7.5s-3.357 7.5-7.5 7.5h-68c-4.136 0-7.5 3.364-7.5 7.5v75c0 4.136 3.364 7.5 7.5 7.5h75c4.136 0 7.5-3.364 7.5-7.5v-53.571l-37.165 37.166a7.502 7.502 0 0 1-10.607 0l-25.031-25.031a7.5 7.5 0 0 1 10.607-10.607l19.728 19.729 62.987-62.988a7.5 7.5 0 0 1 10.607 10.607l-16.126 16.125v68.571c-.001 12.404-10.094 22.498-22.501 22.498zm-211.002-270-.002 198.833c40.715-16.82 95.226-52.652 110.08-78.138 1.165-2 2.334-4.174 3.488-6.484a22.534 22.534 0 0 1-.064-1.711v-75c0-12.406 10.094-22.5 22.5-22.5h6.401a969.178 969.178 0 0 0 2.74-15zm157.67 15h15.277c.904-4.895 1.792-9.905 2.656-15h-15.235c-.878 5.097-1.78 10.107-2.698 15zm-157.67-30h114.787a22.407 22.407 0 0 1-1.285-7.5v-75c0-12.406 10.094-22.5 22.5-22.5h24.227a864.536 864.536 0 0 0 1.353-19.794c-26.253-12.395-74.771-31.164-161.579-54.151zm-162.694 0h147.694l.002-178.945C139.383 71.041 90.862 89.812 64.609 102.206c1.635 29.665 6.235 77.194 13.885 124.793zM434.086 84.576l.007.004-.007-.004z"
                                                fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                        </g>
                                    </svg>
                                </span>
                        <span class="menu-text">{{__('cp.permissions')}}</span>
                    </a>
                </li>
            @endif
            @if(can('settings'))
                <li class="menu-item menu-item-submenu  {{(explode("/", request()->url())[5] == "system_maintenance") ||(explode("/", request()->url())[5] == "settings") || (explode("/", request()->url())[5] == "system_seo") ? "menu-item-open" : ''}}"
                    aria-haspopup="true"
                    data-menu-toggle="">
                    <a href="javascript:" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                             xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0"
                             viewBox="0 0 512 512"
                             style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path
                                    d="m263.1 361.803 54.852-54.856c-5.093-34 10.644-67.328 40.517-84.578 16.919-9.77 36.885-13.347 56.122-9.897l1.135.203c-.046-9.4-.574-17.747-1.918-27.07-1.216-8.431-8.279-14.559-16.799-14.559-19.803 0-38.179-10.537-48.077-27.681-9.876-17.105-9.837-38.344.051-55.436 4.25-7.346 2.491-16.558-4.167-21.821a185.961 185.961 0 0 0-46.377-26.842c-7.906-3.154-16.777-.073-21.021 7.307-9.848 17.126-28.236 27.792-47.996 27.792-19.763 0-38.163-10.657-48.01-27.792-4.241-7.38-13.112-10.461-21.016-7.307a186.08 186.08 0 0 0-46.382 26.841c-6.661 5.265-8.415 14.474-4.163 21.821 9.891 17.091 9.922 38.332.047 55.436-9.864 17.083-28.245 27.681-47.969 27.681-8.631 0-15.691 6.084-16.907 14.56a188.34 188.34 0 0 0 0 53.539c1.222 8.489 8.24 14.554 16.907 14.554 19.727 0 38.104 10.591 47.969 27.676 9.875 17.104 9.844 38.345-.047 55.436-4.255 7.352-2.492 16.561 4.173 21.826a186.172 186.172 0 0 0 46.373 26.837c7.907 3.156 16.772.073 21.016-7.307 9.854-17.133 28.243-27.787 48.01-27.787 12.56.002 23.659 3.945 33.677 11.424zM156.569 212.371c0-40.169 32.682-72.852 72.852-72.852 40.168 0 72.847 32.685 72.847 72.852 0 40.169-32.677 72.852-72.847 72.852-40.172 0-72.852-32.68-72.852-72.852zm277.83 141.504a68.87 68.87 0 0 1-48.131 7.851 7.035 7.035 0 0 0-6.38 1.922L277.03 466.506c-9.941 9.941-26.116 9.942-36.06.005l-13.3-13.291c-9.931-9.924-9.939-26.146-.01-36.075l102.849-102.839a7.05 7.05 0 0 0 1.922-6.38c-8.719-42.945 24.344-82.667 67.61-82.667a68.518 68.518 0 0 1 36.814 10.74c.915.582.885 1.92-.054 2.462l-38.61 22.285c-14.245 8.222-19.153 26.564-10.929 40.806 8.223 14.241 26.554 19.155 40.797 10.933l38.61-22.289a1.437 1.437 0 0 1 2.158 1.185c1.111 25.621-12.193 49.655-34.428 62.494z"
                                    fill="#000000" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                        <span class="menu-text">{{__('cp.setting')}}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">

                        <ul class="menu-subnav">

                            <li class="menu-item {{(explode("/", request()->url())[5] == "settings") ? "menu-item-here" : ''}}"
                                aria-haspopup="true">
                                <a href="{{ route('admins.settings.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.general_setting')}}</span>
                                </a>
                            </li>
                            <li class="menu-item  {{(explode("/", request()->url())[5] == "system_maintenance") ? "menu-item-here" :
                            ''}}" aria-haspopup="true">
                                <a href="{{ route('admins.system.maintenance') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.system_maintenance')}} </span>
                                </a>
                            </li>
                            <li class="menu-item  {{(explode("/", request()->url())[5] == "system_seo") ? "menu-item-here" :
                            ''}}" aria-haspopup="true">
                                <a href="{{ route('admins.system.system_seo') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">{{__('cp.seo_setting')}} </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>

    <!--end::Menu Nav-->
</div>
<!--end::Menu Container-->

