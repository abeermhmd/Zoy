@extends('layout.websiteLayout')
@section('title')
    {{ @$product->name }}
@endsection
@section('seo_meta')
    <meta name="keywords" content="{{@$product->key_words}}"/>
    <meta name="description" content="{{@$product->description}}">
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{@$product->name}}"/>
    <meta property="og:description" content="{{@$product->description}} "/>
    <meta property="og:image" content="{{@$setting->logo}}"/>
    <meta property="fb:app_id" content="177380226248562"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="{{url()->current()}}"/>
    <meta name="twitter:creator" content="{{url()->current()}}"/>
    <meta name="twitter:title" content="{{@$product->name}}"/>
    <meta name="twitter:description" content="{{@$product->description}}"/>
    <meta name="twitter:image" content="{{@$setting->logo}}"/>
@endsection
@section('content')
    <div class="cont-b">
        <div class="breadcrumb-bar wow fadeInUp">
            <ol class="breadcrumb">
                <li class="breadcrumb--item"><a href="{{ route('home') }}">@lang('website.Home')</a></li>
                <li class="breadcrumb--item">{{ @$product->name }}</li>
            </ol>
        </div>
    </div>

    <section class="section_product_details">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="thumb-slider-product">
                        <span class="outOfStock" style="display: none">@lang('website.Out of Stock')</span>
                        <div class="owl-carousel productSliderImages" id="thumb-slider">

                            <div class="item">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}"/>
                            </div>
                            @foreach ($product->images as $oneImage)
                                <div class="item">

                                    <img src="{{ @$oneImage->image }}" alt="{{ @$oneImage->name }}"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="data-product">
                        <div class="name-product">
                            <h5>{{ @$product->name }}</h5>
                            <ul>
                                <li><a href="" class="btn-share"><i class="fa-solid fa-arrow-up-from-bracket"></i></a>
                                </li>
                                <li>
                                    @if(@$product->is_favourite == 0)
                                        <a class="btn-wishlist addToFavorite" data-product_id="{{$product->id}}"><i
                                                class="fa-regular fa-heart"></i></a>
                                    @else
                                        <a class="btn-wishlist removeFromFavorite" data-product_id="{{$product->id}}"><i
                                                class="fa-solid fa-heart"></i></a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="sec-price-prod">
                            <ul class="prc-prd">

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
                            <div class="cont-seller">
                                <a href="https://wa.me/{{ $setting->whatsApp }}"
                                   target="_blank">@lang('website.Contact Seller')</a>
                            </div>
                        </div>
                        @if (in_array($product->type_variants, [1, 2], true))
                            <div class="dt-color">
                                <h5>@lang('website.Color') *</h5>
                                <div class="choose-color">
                                    @foreach ($product->productColorSizes->groupBy('color_id') as $colorId => $oneColorGroup)
                                        @php
                                            $firstColor = $oneColorGroup->first();
                                            $images = $firstColor->images;
                                            $totalQuantity = $oneColorGroup->sum('quantity');
                                            $isOutOfStock = $totalQuantity <= 0;
                                            $productColorSizeId = $firstColor->id; // Assuming this is the ID field
                                        @endphp
                                        <div class="colorImages"
                                             data-color_images="{{ json_encode($images) }}"
                                             data-product_color_size_id="{{ $productColorSizeId }}">
                                            <input data-image="" type="radio"
                                                   id="color{{ $colorId }}"
                                                   name="color"
                                                   value="{{ $colorId }}"
                                                {{ $isOutOfStock ? 'disabled' : '' }}>
                                            <label for="color{{ $colorId }}"
                                                   class="{{ $isOutOfStock ? 'disabled' : '' }}">
                                                <figure>
                                                    @if($images && count($images))
                                                        <img src="{{ $images[0]->image }}"
                                                             alt="{{ $firstColor->color->name }}"/>
                                                    @endif
                                                </figure>
                                                <span>{{ $firstColor->color->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (in_array($product->type_variants, [1, 3], true))
                            <div class="dt-size">
                                <h5>
                                    @lang('website.Size') *
                                    @if($product->getRawOriginal('size_guide_image'))
                                        <a class="btnReg" data-bs-toggle="modal" data-bs-target="#modalSizeChart">
                                            @lang('website.SizeGuide')
                                        </a>
                                    @endif
                                </h5>
                                <div class="choose-size">
                                    @foreach ($product->productColorSizes->groupBy('size_id') as $sizeId => $oneSizeGroup)
                                        @php
                                            $firstSize = $oneSizeGroup->first();
                                            $totalQuantity = $oneSizeGroup->sum('quantity');
                                            $isOutOfStock = $totalQuantity <= 0;
                                            $productColorSizeId = $firstSize->id; // Assuming this is the ID field
                                        @endphp
                                        <div>
                                            <input
                                                data-image=""
                                                type="radio"
                                                id="size{{ $sizeId }}"
                                                name="size"
                                                value="{{ $sizeId }}"
                                                data-product_color_size_id="{{ $productColorSizeId }}"
                                                {{ $isOutOfStock ? 'disabled' : '' }}>
                                            <label for="size{{ $sizeId }}"
                                                   class="{{ $isOutOfStock ? 'disabled' : '' }}">
                                                <span>{{ $firstSize->size->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="dt-qty" id="quantity-section">
                            <div>
                                <p class="normalText">@lang('website.Make it yours') - <span>@lang('website.just a click away') !</span>
                                <p class="notifyMeText">@lang('website.notifyMeText1') - <span>@lang('website.notifyMeText2') !</span>
                                <p class="availableQuantityText d-none">@lang('website..Available Quantity')</span>
                                </p>
                                <div class="d-flex quantity-controller">
                                    <div class="quantity">
                                        <div class="btn button-count dec jsQuantityDecrease disabled" minimum="1">
                                            <i class="fa fa-minus"></i>
                                        </div>
                                        <input type="text" name="count-quat1" class="count-quat" value="1">
                                        <div class="btn button-count inc jsQuantityIncrease">
                                            <i class="fa fa-plus"></i>
                                        </div>
                                    </div>
                                    <div class="add-cart">
                                        @if($product ->is_cart > 0)
                                            <a class="btn-site removeFromCart" data-product_id="{{ @$product->id }}" id="cart-button">
                                                <span>@lang('website.Remove from Bag')</span>
                                            </a>
                                        @else
                                            <a class="btn-site addToCart" id="cart-button">
                                                <span>@lang('website.Add to Bag')</span>
                                            </a>
                                        @endif
                                        <a class="btn-site notify-me" id="notify-button"
                                           data-product_id_notify="{{ $product->id }}" style="display: none;">
                                            <span>@lang('website.Notify me')</span>
                                        </a>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="prd-dtalis wow fadInUp">
                <h5>@lang('website.Description')</h5>
                <p>{!! $product->description !!}</p>
            </div>
        </div>
    </section>
    <!--section_products_page-->
    @if (count($product->similarProducts) > 0)

        <section class="section_most_selling">
            <div class="container-fluid">
                <div class="sec_head wow fadeInUp">
                    <span>@lang('website.Just for you') !</span>
                    <h2>@lang('website.You might also like')</h2>
                </div>
                <div class="owl-carousel" id="selling-slider">
                    @foreach ($product->similarProducts as $oneSimilar)

                        <div class="item">
                            <a href="{{ route('productDetails', @$oneSimilar->productSimilar->id) }}"
                               class="item-product wow fadeInUp">
                                <figure><img src="{{ @$oneSimilar->productSimilar->image }}"
                                             alt="{{ @$oneSimilar->productSimilar->name }}"/></figure>
                                <div class="txt-product">
                                    <h4>{{ @$oneSimilar->productSimilar->name }}</h4>
                                    <ul>

                                        @if (@$oneSimilar->productSimilar->price_offer != '' && @$oneSimilar->productSimilar->price_offer > 0)
                                            <li>
                                                <p>{{number_format(@$oneSimilar->productSimilar->price_offer,3)}} {{@$oneSimilar->productSimilar->currency}}</p>
                                            </li>
                                            <li>
                                                <del>{{number_format(@$oneSimilar->productSimilar->price,3)}} {{@$oneSimilar->productSimilar->currency}}</del>
                                            </li>
                                        @else
                                            <li>
                                                <p>{{number_format(@$oneSimilar->productSimilar->price,3)}} {{@$oneSimilar->productSimilar->currency}}</p>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                                @if(@$oneSimilar->productSimilar->is_favourite == 0)
                                    <div class="favorite-product addToFavorite"
                                         data-product_id="{{$oneSimilar->productSimilar->id}}">
                                        <i class="fa-regular fa-heart"></i>
                                    </div>
                                @else
                                    <div class="favorite-product removeFromFavorite"
                                         data-product_id="{{$oneSimilar->productSimilar->id}}">
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
    @endif

    <div class="modal fade" id="modalSizeChart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
         role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-size-chart">
                        <figure><img src="{{ @$product->size_guide_image }}" alt="{{ @$product->name }}"/></figure>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="NotifyMeLogin" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-succes-sign">
                        <h3>@lang('website.Sorry')</h3>
                        <p>@lang('website.youcannotaddNotify').</p>
                        <a href="{{route('signIn')}}" class="btn-site" data-bs-dismiss="modal"
                           aria-label="Close"><span>@lang('website.login')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="NotifyMeSuccess" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-succes-sign">
                        <h3>@lang('website.Success')</h3>
                        <p>@lang('website.You will be notified when this item is back in stock!').</p>
                        <a class="btn-site" data-bs-dismiss="modal" aria-label="Close"><span>@lang('website.OK')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalSuccessCopy" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-succes-sign">
                        <h3 id="modalTitle">@lang('website.Success')</h3>
                        <p id="modalMessage"></p>
                        <a class="btn-site" data-bs-dismiss="modal" aria-label="Close"><span>@lang('website.OK')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function showModalCopyMessage(title, message) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;
            $('#modalSuccessCopy').modal('show');
        }

        document.querySelectorAll('.btn-share').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();

                const messages = {
                    en: {
                        copySuccess: 'Link copied to clipboard! You can now paste and share it.',
                        copyFail: 'Could not copy the link automatically. The product name is: ',
                        shareTitle: 'Check this out!',
                        shareText: 'I want to share this awesome product with you: ',
                        okButton: 'OK'
                    },
                    ar: {
                        copySuccess: 'تم نسخ الرابط إلى الحافظة! يمكنك الآن لصقه ومشاركته.',
                        copyFail: 'تعذر نسخ الرابط تلقائيًا. اسم المنتج هو: ',
                        shareTitle: 'شاهد هذا!',
                        shareText: 'أريد مشاركة هذا المنتج الرائع معك: ',
                        okButton: 'موافق'
                    }
                };

                // Get user language or fallback to English
                const userLang = document.documentElement.lang || navigator.language || navigator.userLanguage;
                const lang = userLang.startsWith('ar') ? 'ar' : 'en';
                const msg = messages[lang];

                // استرجاع اسم المنتج من data-product-name
                const productName = btn.dataset.productName || 'Untitled Product';

                const shareData = {
                    title: msg.shareTitle,
                    text: `${msg.shareText}${productName}`,
                    url: window.location.href
                };

                if (navigator.share) {
                    // Native sharing
                    navigator.share(shareData).catch(error => {
                        console.error('Error sharing:', error);
                    });
                } else {
                    // Fallback for browsers that don't support Web Share API
                    const fallbackShare = () => {
                        const tempInput = document.createElement('input');
                        document.body.appendChild(tempInput);
                        tempInput.value = shareData.url;
                        tempInput.select();

                        try {
                            document.execCommand('copy');
                            showModalCopyMessage('@lang("website.Success")', msg.copySuccess);
                        } catch (err) {
                            console.error('Failed to copy: ', err);
                            showModalCopyMessage('@lang("website.Error")', `${msg.copyFail}${productName}`);
                        }

                        document.body.removeChild(tempInput);

                        window.open(
                            `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareData.url)}`,
                            'facebook-share',
                            'width=580,height=296'
                        );
                    };

                    fallbackShare();
                }
            });
        });

        $(document).on('click', '.colorImages', function (e) {
            var color_images = $(this).data('color_images');
            if (!color_images || color_images.length === 0) return;

            var newImages = color_images.map(img => `<div class="item"><img src="${img.image}" alt=""></div>`);
            var $slider = $('#thumb-slider');

            $slider.trigger('destroy.owl.carousel');
            $slider.html(newImages.join(''));
            $slider.owlCarousel({
                loop: true,
                rtl: true,
                responsiveClass: true,
                items: 1,
                dots: true,
                nav: false,
                autoplay: false,
            });
            $slider.find('img')
                .on("mousedown", function () {
                    isDragging = false;
                })
                .on("mousemove", function () {
                    isDragging = true;
                })
                .on("mouseup", function () {
                    if (!isDragging) {
                        let src = $(this).attr("src");
                        $(".overlay img").attr("src", src);
                        $(".overlay").css("display", "flex").hide().fadeIn();
                    }
                });
        });

        var productColorSizes = [
                @if(!empty($product->productColorSizes))
                @foreach ($product->productColorSizes as $pcs)
            {
                id: {{ $pcs->id }},
                color_id: {{ $pcs->color_id  ?? 'null' }},
                size_id: {{ $pcs->size_id ?? 'null' }},
                quantity: {{ $pcs->quantity }}
            },
            @endforeach
            @endif
        ];

        var colorSizeInCart = [
            @if(!empty($product->color_size_is_cart))
                @foreach ($product->color_size_is_cart as $cartItem)
                {{ $cartItem }},
            @endforeach
            @endif
        ];

        function updateStockStatus() {
            var selectedColor = $('input[name="color"]:checked').val() || null;
            var selectedSize = $('input[name="size"]:checked').val() || null;
            var productColorSizeId = null;
            var availableQuantity = 0;
            var isOutOfStock = false;
            var inCart = false;

            $('input[name="color"]').prop('disabled', false);
            $('input[name="size"]').prop('disabled', false);
            $('.quantity').show();
            $('.notifyMeText').hide();
            $('.normalText').show();
            $('.count-quat').prop('disabled', false);

            var hasVariants = {{@$product->has_variants ?? 0}};
            var typeVariants = {{@$product->type_variants ?? 0}};

            if (hasVariants == 1 && productColorSizes.length > 0) {
                productColorSizes.forEach(function (pcs) {
                    if (
                        (typeVariants == 1 && pcs.color_id == selectedColor && pcs.size_id == selectedSize) ||
                        (typeVariants == 2 && pcs.color_id == selectedColor) ||
                        (typeVariants == 3 && pcs.size_id == selectedSize)
                    ) {
                        productColorSizeId = pcs.id;
                        availableQuantity = pcs.quantity;
                        isOutOfStock = (pcs.quantity <= 0);
                        if (colorSizeInCart.includes(pcs.id)) {
                            inCart = true;
                        }
                    }
                });
            } else {
                availableQuantity = {{@$product->remaining_quantity ?? 0}};
                isOutOfStock = {{ isset($product->remaining_quantity) ? ($product->remaining_quantity <= 0 ? 1 : 0) : 1 }};
            }

            availableQuantity = Math.max(availableQuantity, 1);

            if (isOutOfStock) {
                $('.outOfStock').show();
                $('.availableQuantityText').addClass('d-none');
                $('#cart-button').hide();
                $('#notify-button').show();
                $('.notifyMeText').show();
                $('.normalText').hide();
                $('.quantity').hide();
                $('.count-quat').val(0).prop('disabled', true);

                // Disable the selected color/size with zero quantity
                if (productColorSizes.length > 0 && selectedColor) {
                    $('input[name="color"]').each(function () {
                        $(this).prop('disabled', $(this).val() === selectedColor);
                    });
                }

                if (productColorSizes.length > 0 && selectedSize) {
                    $('input[name="size"]').each(function () {
                        $(this).prop('disabled', $(this).val() === selectedSize);
                    });
                }
            } else {
                $('.outOfStock').hide();
                $('#cart-button').show();
                $('#notify-button').hide();
                $('.notifyMeText').hide();
                $('.normalText').show();
                $('.count-quat').attr('max', availableQuantity);

                if (hasVariants == 0 && availableQuantity === 1) {
                    $('.availableQuantityText')
                        .removeClass('d-none')
                        .text(`@lang('website.Available Quantity') : ${availableQuantity}`);
                } else {
                    $('.availableQuantityText').addClass('d-none');
                }

                if (parseInt($('.count-quat').val()) > availableQuantity) {
                    $('.count-quat').val(availableQuantity);
                } else if (!parseInt($('.count-quat').val()) || $('.count-quat').val() == 0) {
                    $('.count-quat').val(1);
                }

                $('.jsQuantityDecrease').toggleClass('disabled', parseInt($('.count-quat').val()) <= 1);
                $('.jsQuantityIncrease').toggleClass('disabled', parseInt($('.count-quat').val()) >= availableQuantity);
            }

            // Re-enable color/size inputs on change
            $('input[name="color"], input[name="size"]').on('change', function () {
                $('input[name="color"]').prop('disabled', false);
                $('input[name="size"]').prop('disabled', false);
            });

            // Update cart button based on cart status
            if (inCart) {
                $('#cart-button').removeClass('addToCart').addClass('removeFromCart')
                    .html('<span>@lang("website.Remove from Bag")</span>');
            } else {
                $('#cart-button').removeClass('removeFromCart').addClass('addToCart')
                    .html('<span>@lang("website.Add to Bag")</span>');
            }

            return productColorSizeId;
        }

        $(document).ready(function () {
            window.updateStockStatus = updateStockStatus;
            updateStockStatus(); // Initial call

            var isCart = {{ $product->is_cart ?? 0 }};
            var $cartButton = $('#cart-button');

            if (isCart > 0) {
                $cartButton.removeClass('addToCart').addClass('removeFromCart')
                    .html('<span>@lang("website.Remove from Bag")</span>');
            } else {
                $cartButton.removeClass('removeFromCart').addClass('addToCart')
                    .html('<span>@lang("website.Add to Bag")</span>');
            }


            $(document).on('change', 'input[name="color"], input[name="size"]', function () {
                updateStockStatus();
            });


            $(document).on('click', '.jsQuantityIncrease', function (e) {
                e.stopImmediatePropagation(); // Prevent duplicate handlers
                var currentVal = parseInt($('.count-quat').val()) || 1;
                var maxVal = parseInt($('.count-quat').attr('max'));
                if (currentVal < maxVal) {
                    $('.count-quat').val(currentVal + 1);
                    $('.jsQuantityDecrease').toggleClass('disabled', currentVal + 1 <= 1);
                    $('.jsQuantityIncrease').toggleClass('disabled', currentVal + 1 >= maxVal);
                    $('.availableQuantityText')
                        .removeClass('d-none')
                        .text(`@lang('website.Available Quantity') : ${maxVal}`);
                }
            });

            $(document).on('click', '.jsQuantityDecrease', function (e) {
                e.stopImmediatePropagation(); // Prevent duplicate handlers
                var currentVal = parseInt($('.count-quat').val()) || 1;
                if (currentVal > 1) {
                    $('.count-quat').val(currentVal - 1);
                    $('.jsQuantityDecrease').toggleClass('disabled', currentVal - 1 <= 1);
                    $('.jsQuantityIncrease').toggleClass('disabled', currentVal - 1 >= parseInt($('.count-quat').attr('max')));
                    $('.availableQuantityText')
                        .removeClass('d-none')
                        .text(`@lang('website.Available Quantity') : ${parseInt($('.count-quat').attr('max'))}`);
                }
            });
            //// انبوت الكمية لازم يقبل بس اللي بالداتا بيز
            $(document).on('input', '.count-quat', function () {
                var currentVal = parseInt($(this).val()) || 1;
                var maxVal = parseInt($(this).attr('max')) || 1;
                var minVal = 1;

                if (currentVal > maxVal) {
                    $(this).val(maxVal);
                    currentVal = maxVal;
                } else if (currentVal < minVal || isNaN(currentVal)) {
                    $(this).val(minVal);
                    currentVal = minVal;
                }

                $('.jsQuantityDecrease').toggleClass('disabled', currentVal <= minVal);
                $('.jsQuantityIncrease').toggleClass('disabled', currentVal >= maxVal);
            });

            $(document).on('click', '.addToCart', function (e) {
                e.preventDefault();
                var id = {{@$product->id}};
                var has_variants = {{@$product->has_variants}};
                var type_variants = {{@$product->type_variants}};
                var quantity = $('.count-quat').val() || 1;
                var product_color_size_id = updateStockStatus();

                if (has_variants == 1) {
                    if (type_variants == 1 && !product_color_size_id) {
                        Swal.fire({
                            icon: 'warning',
                            title: '{{ __("website.alert") }}',
                            text: '{{ __("website.Please select both color and size") }}',
                            confirmButtonText: '@lang("website.OK")'
                        });
                        return;
                    } else if (type_variants == 2 && !product_color_size_id) {
                        Swal.fire({
                            icon: 'warning',
                            title: '{{ __("website.alert") }}',
                            text: '{{ __("website.Please select a color") }}',
                            confirmButtonText: '@lang("website.OK")'
                        });
                        return;
                    } else if (type_variants == 3 && !product_color_size_id) {
                        Swal.fire({
                            icon: 'warning',
                            title: '{{ __("website.alert") }}',
                            text: '{{ __("website.Please select a size") }}',
                            confirmButtonText: '@lang("website.OK")'
                        });
                        return;
                    }
                }
                // $('.addToCart span').html('<i class="fa fa-spinner fa-spin" style="font-size: 20px;position: initial;color:black;"></i>');
                $('.addToCart').css({
                    'pointer-events': 'none',
                });

                $.ajax({

                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    url: '{{route('addProductToCart')}}',
                    method: "post",
                    data: {
                        'product_id': id,
                        'quantity': quantity,
                        'product_color_size_id': product_color_size_id
                    },
                    success: function (response) {
                        $(".addToCart").css({
                            'pointer-events': 'auto',
                        });

                        if (response.status == true) {
                            $('.addToCart').html('<span>@lang("website.Remove from Bag")</span>')
                                .removeClass('addToCart')
                                .addClass('removeFromCart');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('website.Error') }}",
                                text: response.message,
                                confirmButtonText: '@lang("website.OK")'
                            });
                        }
                    },
                    error: function (jqXHR, error, errorThrown) {
                        $(".addToCart").css({
                            'pointer-events': 'auto',
                        });
                        var errorMessage = jqXHR.responseJSON && jqXHR.responseJSON.message
                            ? jqXHR.responseJSON.message
                            : "{{ __('website.Something went wrong') }}";
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __('website.Error') }}",
                            text: errorMessage,
                            confirmButtonText: '@lang("website.OK")'
                        });
                    }
                });
            });

            $(document).on('click', '.notify-me', function (e) {
                e.preventDefault();
                var product_id = $(this).data('product_id_notify');
                var product_color_size_id = updateStockStatus();

                @if(auth()->check())
                $('.notify-me').css({
                    'pointer-events': 'none',
                });
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    url: '{{route('notifyMe')}}',
                    method: "post",
                    data: {
                        'product_id': product_id,
                        'product_color_size_id': product_color_size_id
                    },
                    success: function (response) {
                        $('.notify-me').css({
                            'pointer-events': 'auto',
                        });
                        if (response.status == true) {
                            $('#NotifyMeSuccess').modal('show');
                            return false;

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('website.Error') }}",
                                text: response.message,
                                confirmButtonText: '@lang("website.OK")'
                            });
                        }
                    },
                    error: function (jqXHR, error, errorThrown) {
                        $('.notify-me').css({
                            'pointer-events': 'auto',
                        });
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __('website.Error') }}",
                            text: "{{ __('website.Something went wrong') }}",
                            confirmButtonText: '@lang("website.OK")'
                        });
                    }
                });
                @else
                $('#NotifyMeLogin').modal('show');
                return false;
                @endif
            });

            $(document).on('click', '.removeFromCart', function (e) {
                e.preventDefault();
                var ele = $(this);
                var product_id = {{@$product->id}};
                var product_color_size_id = updateStockStatus();

                // لو مفيش Variants، نستخدم product_id بس
                var has_variants = {{@$product->has_variants ?? 0}};
                var data = { 'product_id': product_id };
                if (has_variants == 1 && product_color_size_id) {
                    data['product_color_size_id'] = product_color_size_id;
                }

                $.ajax({
                    url: '{{route('deleteProductCart')}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    data: data,
                    success: function (response) {
                        if (response.status == true) {
                            ele.html("<span>@lang('website.Add to Bag')</span>")
                                .removeClass('removeFromCart')
                                .addClass('addToCart');

                            if (has_variants == 1) {
                                colorSizeInCart = colorSizeInCart.filter(id => id !== product_color_size_id);
                            }
                            updateStockStatus();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('website.Error') }}",
                                text: response.message || "{{ __('website.Something went wrong') }}",
                                confirmButtonText: '@lang("website.OK")'
                            });
                        }
                    },
                    error: function (jqXHR, error, errorThrown) {
                        var errorMessage = jqXHR.responseJSON && jqXHR.responseJSON.message
                            ? jqXHR.responseJSON.message
                            : "{{ __('website.Something went wrong') }}";
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __('website.Error') }}",
                            text: errorMessage,
                            confirmButtonText: '@lang("website.OK")'
                        });
                    }
                });
            });

        });
    </script>
@endsection
