@extends('website.myAccountLayout')
@section('contentMyAccount')
@if (count($products) > 0)
<div class="col-lg-9 favoriteTable">
    <div class="cont-wishlist wow fadeInUp">
        <div class="row">
            @foreach ($products as $product)
            <div class="col-lg-4 row_product_{{ $product->id }}">
                <a  href="{{ route('productDetails', $product->id) }}"class="item-product wow fadeInUp">
{{--                <a  class="item-product wow fadeInUp">--}}
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
                    <div class="favorite-product fav-prd" data-bs-toggle="modal" data-bs-target="#removeFavoriteModal{{ @$product->id }}"><i class="fa-solid fa-heart"></i></div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@foreach($products as $product)
    <div class="modal fade" id="removeFavoriteModal{{ @$product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-modal="true" role="dialog">
        <div class="wsmall modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-succes-sign">
                        <h3>@lang('website.Delete')</h3>
                        <p>@lang('website.Are you sure want to delete product from wishlist')</p>
                        <ul>
                            <li><a class="btn-site btn-cancel" data-bs-dismiss="modal"
                                    aria-label="Close"><span>@lang('website.no')</span></a></li>
                            <li><a class="btn-site removeFromFavInside"
                                    data-product_id="{{@$product->id}}"><span>@lang('website.yes')</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endif
<div class="col-lg-9 emptyFavorite" @if (count($products) > 0) style="display: none" @endif>
    <div class="cont-orders wow fadeInUp">
        <div class="cont-empty">
            <figure><i class="icon-no-product"></i></figure>
            <h5>@lang('website.No products added yet')</h5>
            <p>@lang('website.Your wishlist is empty') .<br />@lang('website.Add items to save for later') .
            </p>
        </div>
    </div>
</div>



@endsection
@section('js')
    <script>
        $('.fav-prd').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation(); // Stop event bubbling to parent elements
        });

        $(document).on('click', '.removeFromFavInside', function () {
            var product_id = $(this).data('product_id');
            var elem = $(this);
            $.ajax({
                url: '{{route("removeFavorite")}}',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                type: "post",
                data: {
                    product_id: product_id,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.status == true) {
                        $("#removeFavoriteModal" + product_id).modal('hide');
                        $('.row_product_' + product_id).fadeOut(800, function () {
                            $(this).remove();
                        });
                        if (response.count == 0) {
                            $('.favoriteTable').hide();
                            $('.emptyFavorite').show();

                        }
                    }
                }
            });
        });
    </script>
@endsection
