@extends('layout.websiteLayout')
@section('title') @lang('website.my_account')
@endsection
@section('content')
<div class="cont-b">
    <div class="breadcrumb-bar wow fadeInUp">
        <strong>@lang('website.my_account')</strong>
        <ol class="breadcrumb">
            <li class="breadcrumb--item"><a href="{{ route('home') }}">@lang('website.Home')</a></li>
            <li class="breadcrumb--item">@lang('website.my_account')</li>
        </ol>
    </div>
</div>
<section class="section_account_page">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="aside-account wow fadeInUp">
                    <ul class="ls--acco">
                        <li @if(Route::currentRouteName() == 'orders') class="active" @elseif( Route::currentRouteName()  == 'orderDetails') class="active" @endif><a href="{{ route('orders') }}">@lang('website.Orders')</a></li>
                        <li class="{{Route::currentRouteName()  == 'myAddresses' ? 'active' : ''}}"><a href="{{route('myAddresses')}}">@lang('website.Addresses')</a></li>
{{--                        <li class="{{Route::currentRouteName()  == 'myCards' ? 'active' : ''}}"><a href="{{ route('myCards') }}">@lang('website.Saved Cards')</a></li>--}}
                        <li class="{{Route::currentRouteName()  == 'myFavorite' ? 'active' : ''}}"><a href="{{ route('myFavorite') }}">@lang('website.Wishlist')</a></li>
                        <li class="{{Route::currentRouteName()  == 'myAccount' ? 'active' : ''}}"><a href="{{route('myAccount')}}">@lang('website.Edit Account')</a></li>
                        <li class="{{Route::currentRouteName()  == 'changePassword' ? 'active' : ''}}"><a href="{{ route('changePassword') }}">@lang('website.Change Password')</a></li>
                        <li><a class="btnSt" data-bs-toggle="modal" data-bs-target="#modalLogout">@lang('website.logout')</a></li>
                    </ul>
                </div>
            </div>
            @yield('contentMyAccount')
        </div>
    </div>
</section>
<!--section_account_page-->

<div class="modal fade" id="modalLogout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
    role="dialog">
    <div class="wsmall modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="content-succes-sign">
                    <h3>@lang('website.logout')</h3>
                    <p>@lang('website.Are you sure want to logout')</p>
                    <ul>
                        <li><a class="btn-site btn-cancel" data-bs-dismiss="modal"
                                aria-label="Close"><span>@lang('website.no')</span></a></li>
                        <li><a class="btn-site" aria-label="Close" href="{{route('logout')}}"><span>@lang('website.yes')</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
