@extends('layout.websiteLayout')
@section('title')@lang('website.Faqs')
@endsection
@section('content')
<div class="cont-b">
    <div class="breadcrumb-bar wow fadeInUp">
        <strong>@lang('website.Faqs')</strong>
        <ol class="breadcrumb">
            <li class="breadcrumb--item"><a href="{{ route(name: 'home') }}">@lang('website.Home')</a></li>
            <li class="breadcrumb--item">@lang('website.Faqs')</li>
        </ol>
    </div>
</div>

<section class="section_faqs_page">
    <div class="container">
        <div class="cont-faq wow fadeInUp">
            @forelse (@$faqs as $faq)
                <div class="item-faq">
                    <div class="head-faq {{ $loop->first ? 'active' : '' }}">
                        <h4>{{$faq->question}}</h4>
                        <span><i class="icon-plus"></i></span>
                    </div>
                    <div class="bdy-faq {{ $loop->first ? 'active' : '' }}">
                        <p>
                            {{$faq->answer}}
                        </p>
                    </div>
                </div>
            @empty
                <div class="item-faq">
                    <div class="head-faq active">
                        <h4>@lang('website.No Data') ..!</h4>
                    </div>

                </div>
            @endforelse


        </div>
    </div>
</section>
<!--section_faqs_page-->
@endsection
