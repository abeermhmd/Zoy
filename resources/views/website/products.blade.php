@extends('layout.websiteLayout')
@section('title') {{ @$category->name }}
@endsection
@section('seo_meta')
    <meta name="keywords" content="{{@$category->key_words}}"/>
    <meta name="description" content="{{@$setting->instagram_text_footer}}">
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{@$category->name}}"/>
    <meta property="og:description" content="{{@$setting->instagram_text_footer}} "/>
    <meta property="og:image" content="{{@$setting->logo}}"/>
    <meta property="fb:app_id" content="177380226248562"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="{{url()->current()}}"/>
    <meta name="twitter:creator" content="{{url()->current()}}"/>
    <meta name="twitter:title" content="{{@$category->name}}"/>
    <meta name="twitter:description" content="{{@$setting->instagram_text_footer}}"/>
    <meta name="twitter:image" content="{{@$setting->logo}}"/>
@endsection
@section('content')
<div class="cont-b">
    <div class="breadcrumb-bar wow fadeInUp">
        <strong>{{ @$category->name }}</strong>
        <ol class="breadcrumb">
            <li class="breadcrumb--item"><a href="{{ route(name: 'home') }}">@lang('website.Home')</a></li>
            <li class="breadcrumb--item">{{ @$category->name }}</li>
        </ol>
    </div>
</div>

<section class="section_products_page">
    <div class="container-fluid">
        <div class="sec_head wow fadeInUp">
            <h2>{{ $counts }}
                @if ($counts > 10)
                    @lang('website.products')
                @else
                    @lang('website.products')
                @endif
            </h2>
        </div>
        <div class="row" id="products">
            @include('website.productsList')
        </div>
        <div class="loader" style="display: none"></div>
    </div>
</section>
<!--section_products_page-->
@endsection

