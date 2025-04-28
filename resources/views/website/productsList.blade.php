
@forelse ($products as $product)
<div class="col-lg-3">
    <a href="{{ route('productDetails', $product->id) }}" class="item-product wow fadeInUp">
        <figure><img src="{{ @$product->image }}" alt="{{ @$product->name }}" /></figure>
        <div class="txt-product">
            <h4>{{ @$product->name }}</h4>
            <ul>

                @if (@$product->price_offer != '' && @$product->price_offer > 0)
                    <li>
                        <p>{{number_format(@$product->price_offer,3)}} {{@$product->currency}}</p>
                    </li>
                <li><del>{{number_format(@$product->price,3)}} {{@$product->currency}}</del></li>
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
@empty
@if (request()->page == 1 || request()->page == '')
@if (Route::currentRouteName() == 'search')
<div class="cont-results-found">
    <div class="cont-empty">
        <figure><i class="icon-no-search"></i></figure>
        <h5>@lang('website.No Result Found')</h5>
        <p>@lang('website.Please_new_arrivals')</p>
    </div>
</div>
@else
<div class="cont-empty">
    <div class="item-empty">
        <h5>@lang('website.noProducts')</h5>
    </div>
</div>
@endif

@endif
@endforelse

