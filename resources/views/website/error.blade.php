@extends('layout.websiteLayout')
@section('title')@lang('website.Error')
@endsection
@section('content')
    <section class="section_succes_page">
        <div class="container">
            <div class="msg-error wow fadeInUp">
                <h4>@lang('website.Error') !</h4>
                <p>@lang('website.Order could not be placed. Please review and retry').</p>
            </div>
            <div class="dta-error wow fadeInUp">
                <p>@lang('website.Apologies for the inconvenience'). <br />@lang('website.textError2').</p>
                <strong>@lang('website.The order was not placed and it won’t be delivered').</strong>
                <span>@lang('website.error') 0x000231</span>
                <a href="{{route('home')}}" class="btn-site"><span>@lang('website.Try Again')</span></a>
            </div>
        </div>
    </section>
    <!--section_succes_page-->
@endsection
