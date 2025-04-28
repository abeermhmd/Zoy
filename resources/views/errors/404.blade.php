@extends('layout.websiteLayout')
@section('title')
    404
@endsection
@section('content')
<section class="section_page_site">
    <div class="container">
        <div class="cont-not-found">
            <div class="thumb-not-found wow fadeInUp">
                <figure><img src="{{ asset('website_assets/images/404.svg') }}" alt="Images 404" /></figure>
            </div>
            <div class="txt-not-found wow fadeInUp">
                <h5>@lang('website.PAGE NOT FOUND')</h5>
                <p>@lang('website.THE PAGE YOU ARE LOOKING FOR WAS MOVED, REMOVED'), <br />@lang('website.RENAMED OR MIGHT NEVER EXISTED').</p>
                <a href="{{route('home') }}" class="btn-site"><span>@lang('website.Try Again')</span></a>
            </div>
        </div>
    </div>
</section>
<!--section_page_site-->
@endsection
