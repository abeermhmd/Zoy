@extends('layout.websiteLayout')
@section('title'){{@$page->name}}
@endsection
@section('seo_meta')
    <meta name="keywords" content="{{@$setting->key_words}}"/>
    <meta name="description" content="{{@$page->description}}">
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{@$page->name}}"/>
    <meta property="og:description" content="{{@$page->description}} "/>
    <meta property="og:image" content="{{@$setting->logo}}"/>
    <meta property="fb:app_id" content="177380226248562"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="{{url()->current()}}"/>
    <meta name="twitter:creator" content="{{url()->current()}}"/>
    <meta name="twitter:title" content="{{@$page->name}}"/>
    <meta name="twitter:description" content="{{@$page->description}}"/>
    <meta name="twitter:image" content="{{@$setting->logo}}"/>
@endsection
@section('content')
<div class="cont-b">
    <div class="breadcrumb-bar wow fadeInUp">
        <strong>{{@$page->name}}</strong>
        <ol class="breadcrumb">
            <li class="breadcrumb--item"><a href="{{ route(name: 'home') }}">@lang('website.Home')</a></li>
            <li class="breadcrumb--item">{{@$page->name}}</li>
        </ol>
    </div>
</div>
<section class="section_about_page">
    <div class="container">
        <div class="cont-about wow fadeInUp">

            @if (@$page->slug == 'about-us')
                <figure><img src="{{@$page->image}}" alt="{{@$page->name}}" /></figure>
            @endif

            <div class="txt-abt">
                <p>
                    {!! @$page->description !!}
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
