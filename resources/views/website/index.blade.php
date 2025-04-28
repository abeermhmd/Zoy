@extends('layout.websiteLayout')
@section('title')
    {{__('website.Home')}}
@endsection
@section('seo_meta')
    <meta name="keywords" content="{{@$setting->key_words}}"/>
    <meta name="description" content="{{@$setting->instagram_text_footer}}">
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{@$setting->title}}"/>
    <meta property="og:description" content="{{@$setting->instagram_text_footer}} "/>
    <meta property="og:image" content="{{@$setting->logo}}"/>
    <meta property="fb:app_id" content="177380226248562"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="{{url()->current()}}"/>
    <meta name="twitter:creator" content="{{url()->current()}}"/>
    <meta name="twitter:title" content="{{@$setting->title}}"/>
    <meta name="twitter:description" content="{{@$setting->instagram_text_footer}}"/>
    <meta name="twitter:image" content="{{@$setting->logo}}"/>
@endsection
@section('content')

    <section class="section_home">
        <div class="owl-carousel" id="slide-home">
            @foreach ($data['banners'] as $banner)
                <!--2->product ,3->category , 4->subcategory-->
                <a @if (@$banner->type_link == 2)
                       href="{{ route('productDetails' , @$banner->linked_id) }}"
                   @elseif (@$banner->type_link == 3 || @$banner->type_link == 4)
                       href="{{ route('products' , @$banner->linked_id) }}"
                @else

                    @endif>
                    @if ($banner->type == 2)
                        <div class="item">
                            <video class="banner-video" width="100%" height="100%" autoplay>
                                <source src="{{ asset($banner->image) }}" type="video/mp4">
                            </video>
                        </div>
                    @else
                        <div class="item" style="background: url({{ asset($banner->image) }})"></div>
                    @endif
                </a>
            @endforeach
        </div>
    </section>
    <!--section_home-->

    <section class="section_featured_categories">
        <div class="container-fluid">
            <div class="owl-carousel" id="categories-slider">
                @foreach (@$data['categories'] as $category)
                    <div class="item">
                        <a href="{{ route('products' , $category->id) }}" class="item-categories wow fadeInUp">
                            <figure><img src="{{ asset(@$category->image) }}" alt="{{ @$category->name }}"/></figure>
                            <div class="txt-categories">
                                <h4>{{ @$category->name }}</h4>
                                <span><i class="fa-solid fa-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                @endforeach


            </div>
        </div>
    </section>
    <!--section_featured_categories-->

    <section class="section_most_selling">
        <div class="container-fluid">
            <div class="sec_head wow fadeInUp">
                <span>@lang('website.Trending Now: Elevate Your Style!')</span>
                <h2>@lang('website.Most Selling')</h2>
            </div>
            <div class="owl-carousel" id="selling-slider">
                @foreach ($data['products'] as $product)
                    <div class="item">
                        <a href="{{ route('productDetails', $product->id) }}" class="item-product wow fadeInUp">
                            <figure><img src="{{ asset(@$product->image) }}" alt="{{ @$product->name }}"/></figure>
                            <div class="txt-product">
                                <h4>{{ @$product->name }}</h4>
                                <ul>

                                    @if (@$product->price_offer != '' && @$product->price_offer > 0)
                                        <li>
                                            <p>{{number_format(@$product->price_offer,3)}} {{@$product->currency}}</p>
                                        </li>
                                        <li>
                                            <del>{{number_format(@$product->price,3)}} {{@$product->currency}}</del>
                                        </li>
                                    @else
                                        <li>
                                            <p>{{number_format(@$product->price,3)}} {{@$product->currency}}</p>
                                        </li>
                                    @endif

                                </ul>
                            </div>

                            @if($product->is_favourite == 0)
                                <div class="favorite-product addToFavorite" data-product_id="{{$product->id}}">
                                    <i class="fa-regular fa-heart"></i>
                                </div>
                            @else
                                <div class="favorite-product removeFromFavorite" data-product_id="{{$product->id}}">
                                    <i class="fa-solid fa-heart"></i>
                                </div>
                            @endif
                        </a>
                    </div>
                @endforeach


            </div>
        </div>
    </section>
    <!--section_most_selling-->

    <section class="section_main_banner">
        <div class="container-fluid">
            <div class="cont-banner">
                <!--2->product ,3->category , 4->subcategory-->
                <a @if (@$setting->type_link == 2)
                       href="{{ route('productDetails' , @$setting->linked_id) }}"
                   @elseif(@$setting->type_link == 3 || @$setting->type_link == 4)
                       href="{{ route('products' , @$setting->linked_id) }}"
                @else

                    @endif>
                    <img src="{{ asset(@$setting->banner_ad_image) }}" alt="{{ @$setting->title }}"/></a>
            </div>
        </div>
    </section>
    <!--section_main_banner-->

    <section class="section_arrival">
        <div class="container-fluid">
            <div class="sec_head wow fadeInUp">
                <span>@lang('website.Trendy Looks, First Access!')</span>
                <h2>@lang('website.New Arrival')</h2>
            </div>
            <div class="owl-carousel" id="arrival-slider">
                @foreach ($data['newArrival'] as $newArrivalPro)
                    <div class="item">
                        <a href="{{ route('productDetails', $newArrivalPro->id) }}" class="item-arrival wow fadeInUp">
                            <figure><img src="{{ asset(@$newArrivalPro->image) }}" alt="{{ @$newArrivalPro->name }}"/>
                            </figure>
                            <div class="txt-arrival">
                                <h5>{{ @$newArrivalPro->name }}</h5>

                                @if (@$newArrivalPro->price_offer != '' && @$newArrivalPro->price_offer > 0)
                                    <p>{{number_format(@$newArrivalPro->price_offer,3)}} {{@$newArrivalPro->currency}}</p>
                                    <del>{{number_format(@$newArrivalPro->price,3)}} {{@$newArrivalPro->currency}}</del>
                                @else
                                    <p>{{number_format(@$newArrivalPro->price,3)}} {{@$newArrivalPro->currency}}</p>
                                @endif
                            </div>
                            @if($newArrivalPro->is_favourite == 0)
                                <div class="favorite-arrival addToFavorite" data-product_id="{{$newArrivalPro->id}}">
                                    <i class="fa-regular fa-heart"></i>
                                </div>
                            @else
                                <div class="favorite-arrival removeFromFavorite"
                                     data-product_id="{{$newArrivalPro->id}}">
                                    <i class="fa-solid fa-heart"></i>
                                </div>
                            @endif
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <div class="modal fade show" id="modalAd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <a @if (@$setting->type_link_pop == 2)
                       href="{{ route('productDetails' , @$setting->linked_id_pop) }}"
                   @elseif(@$setting->type_link_pop == 3 || @$setting->type_link_pop == 4)
                       href="{{ route('products' , @$setting->linked_id_pop) }}"
                @else

                    @endif>
                    <img src="{{ asset(@$setting->ad_popUp_image) }}" alt="{{ @$setting->title }}"/>
                </a>
            </div>
        </div>
    </div>

    <!--section_arrival-->
@endsection
@section('js')
    <script>
        window.addEventListener('load', function () {
            var myModal = new bootstrap.Modal(document.getElementById('modalAd'));
            myModal.show();
        });
    </script>
@endsection
