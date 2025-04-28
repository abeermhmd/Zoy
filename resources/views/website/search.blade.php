@extends('layout.websiteLayout')
@section('title') @lang('website.Search Results')
@endsection
@section('content')

<div class="cont-b">
    <div class="breadcrumb-bar wow fadeInUp">
        <strong>@lang('website.Search Results')</strong>
        <ol class="breadcrumb">
            <li class="breadcrumb--item"><a href="{{ route(name: 'home') }}">@lang('website.Home')</a></li>
            <li class="breadcrumb--item">@lang('website.Search Results')</li>
        </ol>
    </div>
</div>

<section class="section_results_page">
    <div class="container-fluid">
        <div class="sec_head wow fadeInUp">
            <h2>@lang('website.Search Results for') “{{ request('name') }}”</h2>
        </div>
        <div class="row" id="products">
            @include('website.productsList')
        </div>

        <div class="loader" style="display: none"></div>
    </div>
</section>
<!--section_results_page-->
@endsection
