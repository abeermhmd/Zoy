@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.products'))}}
@endsection
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{__('cp.products')}} </h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{ route('admins.products.index') }}"
                       class="btn btn-secondary mr-2">{{__('cp.back')}}</a>
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">{{__('cp.view')}} {{ucwords(__('cp.product'))}} \ {{$item->name}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($locales as $locale)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.name_'.$locale->lang)}}</label>
                                        <input type="text" class="form-control" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                                        value="{{ isset($item->translate($locale->lang)->name) ? $item->translate($locale->lang)->name : '' }}"
                                               disabled />
                                    </div>
                                </div>
                            @endforeach
                            @foreach($locales as $locale)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description_{{$locale->lang}}">{{__('cp.description_'.$locale->lang)}}</label>
                                        <textarea class="form-control" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                                        rows="4" disabled>{{ @$item->translate($locale->lang)->description }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                            @foreach($locales as $locale)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.key_words_'.$locale->lang) . ' ('.__('cp.optional') .')'}} </label>
                                        <input type="text" class="form-control" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                                        value="{{ isset($item->translate($locale->lang)->key_words) ? $item->translate($locale->lang)->key_words : '' }}"
                                               disabled />
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.price') . ' ('.__('cp.KWD') .')'}} </label>
                                    <input type="number" class="form-control" value="{{ @$item->getRawOriginal('price') }}"
                                           disabled />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.price_offer') . ' (' . __('cp.KWD') .')'}}</label>
                                    <input type="number" class="form-control" value="{{ @$item->getRawOriginal('price_offer') }}"
                                           disabled />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SKU </label>
                                    <input type="text" class="form-control" value="{{ @$item->sku }}" disabled />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.quantity')}} </label>
                                    <input type="number" class="form-control" value="{{ @$item->quantity }}" disabled />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.weight') .' ('.__('cp.KG') .')'}} </label>
                                    <input type="number" class="form-control" value="{{ @$item->weight }}" disabled />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-8 col-form-label">{{__('cp.most_selling')}} </label>
                                    <div class="col-6">
                                        <span class="switch">
                                            <label>
                                                <input type="checkbox" {{@$item->most_selling == 1 ? "checked" : ""}} disabled />
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-6 col-form-label">{{__('cp.new_arrival')}} </label>
                                    <div class="col-6">
                                        <span class="switch">
                                            <label>
                                                <input type="checkbox" {{@$item->new_arrival == 1 ? "checked" : ""}} disabled />
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if($item->similarProducts->isNotEmpty())
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">{{__('cp.similar_products')}}</label>
                                        <select class="form-control select2 sizes" multiple disabled>
                                            @foreach ($similar_products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ in_array($product->id, @$item->similarProducts->pluck('similar_product_id')->toArray()) ? 'selected' : '' }}>
                                                    {{$product->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">{{__('cp.category')}}</label>
                                    <select class="select2 form-control" disabled>
                                        @foreach($categories as $oneCat)
                                            <option value="{{ $oneCat->id }}" {{ @$item->category_id == $oneCat->id ? 'selected' : '' }}>
                                                {{@$oneCat->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-6 col-form-label">{{__('cp.has_variants')}} </label>
                                    <div class="col-6">
                                        <span class="switch">
                                            <label>
                                                <input type="checkbox" {{@$item->has_variants == 1 ? "checked" : ""}} disabled />
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if(@$item->has_variants)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.colors')}}</label>
                                        <select class="form-control select2 colors" disabled>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}"
                                                    {{ @$item->productColorSizes->pluck('color_id')->contains($color->id) ? 'selected' : '' }}>
                                                    {{ $color->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">{{__('cp.sizes')}}</label>
                                        <select class="form-control select2 sizes" multiple disabled>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}"
                                                    {{ in_array($size->id, @$item->productColorSizes->pluck('size_id')->toArray()) ? 'selected' : '' }}>
                                                    {{$size->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="selectedColorsContainer" class="row">
                                        @foreach(@$item->productColorSizes->groupBy('color_id') as $colorId => $productColors)
                                            @if($colorId && $productColors->first()->color)
                                                <div class="col-md-6 color-item border p-2 mt-2 rounded shadow-sm">
                                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                        <strong class="color-name">{{ $productColors->first()->color->name }}</strong>
                                                    </div>
                                                    <div class="row mt-2">
                                                        @if($productColors->first()->images->isNotEmpty())
                                                            @foreach($productColors->first()->images as $image)
                                                                <div class="col-md-4 mt-2">
                                                                    <img src="{{ asset($image->image) }}"
                                                                         class="img-thumbnail"
                                                                         style="width:100px; height:100px; object-fit:cover;"
                                                                         onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="col-md-12 text-muted">

                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.image')}}</label>
                                    <div class="thumbnail">
                                        <img src="{{ @$item->image ? asset($item->image) : asset('images/placeholder.png') }}"
                                             alt="Image"
                                             style="max-width: 200px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.size_guide_image') . ' ('.__('cp.optional') . ') '}}</label>
                                    <div class="thumbnail">
                                        <img src="{{ @$item->size_guide_image ? asset($item->size_guide_image) : asset('images/placeholder.png') }}"
                                             alt="Size Guide Image"
                                             style="max-width: 200px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>
                            <div class="card-header">
                                <h3 class="card-title">{{__('cp.images')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="imageupload" style="display:flex; flex-wrap:wrap">
                                    @foreach(@$item->images as $oneImage)
                                        <div class="imageBox text-center" style="width:150px; height:150px; margin:5px">
                                            <img src="{{ asset($oneImage->image) }}"
                                                 style="width:150px; height:150px; object-fit:cover;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

@endsection
