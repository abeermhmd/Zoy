<div class="card-body">
    <div class="row">
        @foreach($locales as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.name_'.$locale->lang)}}</label>
                <input type="text" class="form-control" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                name="name_{{$locale->lang}}" value="{{ isset($item->translate($locale->lang)->name) ?
                old('name_'.$locale->lang , $item->translate($locale->lang)->name) : old('name_'.$locale->lang ) }}"
                required/>
            </div>
        </div>
        @endforeach
        @foreach($locales as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="description_{{$locale->lang}}">{{__('cp.description_'.$locale->lang)}}</label>
                <textarea class="form-control" id="kt-ckeditor-{{$loop->index+4}}"
                    {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} name="description_{{$locale->lang}}"
                            id="description_{{$locale->lang}}" rows="4" required>{{ @$item->translate($locale->lang)->description}}</textarea>
            </div>
        </div>
        @endforeach
            @foreach($locales as $locale)
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__('cp.key_words_'.$locale->lang) . ' ('.__('cp.optional') .')'}} </label>
                        <input type="text" class="form-control" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                        name="key_words_{{$locale->lang}}" value="{{ isset($item->translate($locale->lang)->key_words) ?
                old('key_words_'.$locale->lang , $item->translate($locale->lang)->key_words) : old('key_words_'.$locale->lang ) }}"
                               />
                    </div>
                </div>
            @endforeach
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.price') . ' ('.__('cp.KWD') .')'}} </label>
                <input type="number" class="form-control" name="price" value="{{ old('price', @$item->getRawOriginal('price')) }}"
                     min="0" required />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label> {{__('cp.price_offer') . ' (' . __('cp.KWD') .')'}}</label>
                <input type="number" class="form-control" name="price_offer"
                    value="{{ old('price_offer', @$item->getRawOriginal('price_offer')) }}"  min="0" />
            </div>
        </div>
        <div class="col-md-6" id="sku">
            <div class="form-group">
                <label>SKU </label>
                <input type="text" class="form-control" name="sku" value="{{ old('sku', @$item->sku) }}" @if(request()->routeIs('admins.products.create')) required @endif/>
            </div>
        </div>
        <div class="col-md-6" id="quantity">
            <div class="form-group">
                <label>{{__('cp.quantity')}} </label>
                <input type="number" class="form-control" name="quantity"
                    value="{{ old('quantity', @$item->quantity) }}"  min="0" id="quantityInput" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__('cp.weight') .' ('.__('cp.KG') .')'}} </label>
                <input type="number" class="form-control" name="weight" value="{{ old('weight', @$item->weight) }}"
                    step="0.01" min="0" required />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="col-8 col-form-label">{{__('cp.most_selling')}} </label>
                <div class="col-6">
                    <span class="switch">
                        <label>
                            <input type="checkbox" {{@$item->most_selling == 1 ? "checked" : ""}}
                            name="most_selling"/>
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
                            <input type="checkbox" {{@$item->new_arrival == 1 ? "checked" : ""}}
                            name="new_arrival"/>
                            <span></span>
                        </label>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-sm-12 control-label">{{__('cp.similar_products')}}</label>
                <select class="form-control select2 sizes" name="similar_products[]" multiple>
                    <option value="" disabled>{{__('cp.select')}}</option>
                    @foreach ($similar_products as $product)
                    <option value="{{ $product->id }}" @if(in_array($product->id,
                        @$item->similarProducts->pluck('similar_product_id')->toArray())) selected
                        @endif>{{$product->name}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label"> {{__('cp.category')}}</label>
                <select class="select2 form-control" name="category_id" required>
                    <option value="">
                        {{__('cp.select')}}
                    </option>

                    @foreach($categories as $oneCat)
                    <option value="{{ $oneCat->id }}" {{ old('category_id', @$item->category_id) == $oneCat->id ?
                        'selected' :
                        ''
                        }}>{{@$oneCat->name}}</option>
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
                            <input type="checkbox" id="has_variants" {{@$item->has_variants == 1 ? "checked" : ""}}
                            name="has_variants"/>
                            <span></span>
                        </label>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="colors">
            <div class="form-group">
                <label>{{__('cp.colors')}}</label>
                <select class="form-control select2 colors" id="colorSelect">
                    @if(request()->routeIs('admins.products.create'))
                    <option value="" disabled selected>{{__('cp.select')}}</option>
                    @foreach ($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach

                    @else
                    <option value="" disabled>{{ __('cp.select') }}</option>
                    @foreach ($colors as $color)
                    <option value="{{ $color->id }}" @if(@$item->productColorSizes->pluck('color_id')->contains($color->id))
                        selected @endif>
                        {{ $color->name }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-md-6" id="sizes">
            <div class="form-group">
                <label class="col-sm-12 control-label">{{__('cp.sizes')}}</label>
                <select class="form-control select2 sizes" name="sizes[]" multiple>
                    <option value="" disabled>{{__('cp.select')}}</option>
                    @foreach ($sizes as $size)
                    <option value="{{ $size->id }}" @if(in_array($size->id,
                        @$item->productColorSizes->pluck('size_id')->toArray())) selected @endif>{{$size->name}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div id="selectedColorsContainer" class="row">
            </div>
        </div>
        <div class="col-md-6">
            <div class="fileinputForm">
                <label>{{__('cp.image')}} <span style="display: inline-block; color: #2c3e50; background: linear-gradient(to right, #ecf0f1, #bdc3c7); padding: 3px 8px; border-radius: 4px; font-size: 0.9em; box-shadow: 1px 1px 3px rgba(0,0,0,0.1);">(10:13 Ratio,  1000 px X 1300 px)</span></label>

                <div class="fileinput-new thumbnail" onclick="document.getElementById('edit_image').click()" style="cursor:pointer">
                    <img src="{{ @$item->image }}" alt="Image" id="editImage">
                </div>
                <div class="btn btn-change-img red" onclick="document.getElementById('edit_image').click()">
                    <i class="fas fa-pencil-alt"></i>
                </div>
                <input type="file" class="form-control" name="image" id="edit_image" style="display:none"
                    accept="image/*" @if(request()->routeIs('admins.products.create')) required @endif>
            </div>
        </div>
        <div class="col-md-6">
            <div class="fileinputForm">
                <label>{{__('cp.size_guide_image') . ' ('.__('cp.optional') . ') '}}</label>
                <div class="fileinput-new thumbnail" onclick="document.getElementById('edit_image1').click()"
                    style="cursor:pointer">
                    <img src="{{ @$item->size_guide_image }}" alt="Image" id="editImage1">
                </div>
                <div class="btn btn-change-img red" onclick="document.getElementById('edit_image1').click()">
                    <i class="fas fa-pencil-alt"></i>
                </div>
                <input type="file" class="form-control" name="size_guide_image" id="edit_image1" style="display:none"
                    accept="image/*">
            </div>
        </div>
        <div class="card-header">
            <h3 class="card-title">{{__('cp.images')}} <span style="display: inline-block; color: #2c3e50; background: linear-gradient(to right, #ecf0f1, #bdc3c7); padding: 3px 8px; border-radius: 4px; font-size: 0.9em; box-shadow: 1px 1px 3px rgba(0,0,0,0.1);">{{ __('cp.max_images_message_pr') }}</span></h3>
            <br>
        </div>
        <div class="card-body">
            <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                @if ($errors->has('image'))
                <span class="help-block"> <strong>{{ $errors->first('image') }}</strong></span>
                @endif
                {{-- <label>{{__('cp.images')}} </label> --}}
                <div class="imageupload" style="display:flex;flex-wrap:wrap">
                    @foreach(@$item->images as $oneImage)
                    <div class="imageBox text-center" style="width:150px;height:190px;margin:5px">
                        <img src="{{$oneImage->image}}" style="width:150px;height:150px">
                        <button class="btn btn-danger deleteImage" type="button">{{__("cp.remove")}}</button>
                        <input class="attachedValues" type="hidden" name="oldImages[]" value="{{$oneImage->id}}">
                    </div>
                    @endforeach
                </div>
                <div class="input-group control-group increment">
                    <div class="input-group-btn" onclick="document.getElementById('all_images').click()">
                    </div>
                    <input type="file" class="form-control " accept="image/*" id="all_images" multiple />
                </div>


            </div>
        </div>
    </div>
</div>
@section('js')
<script>
    $(document).ready(function () {
        var isEditRoute = @json(request()->routeIs('admins.products.edit'));
        function toggleQuantityField() {
            if ($("#has_variants").is(":checked")) {
                $("#colors, #sizes").show();
                $("#quantity").hide();
                $("#quantityInput").prop("required", false); // Remove required when hidden
                // $("#skuInput").prop("required", false); // Remove required when hidden

            } else {
                $("#colors, #sizes").hide();
                $("#quantity").show();
                $("#quantityInput").prop("required", true); // Add required when visible
                // $("#skuInput").prop("required", true); // Add required when visible
                $("#quantityInput").val(0); // Ensure default value is 0
            }
            if (isEditRoute && $("#has_variants").is(":checked")) {
                $("#sku").hide();
                $("#skuInput").prop("required", false);
            }else{
                $("#sku").show();
                $("#skuInput").prop("required", true);
            }
        }

        toggleQuantityField();

        $("#has_variants").on("change", function () {
            toggleQuantityField();
        });

        $('#colorSelect').val(null).trigger('change');
        $('#colorSelect').select2({
            placeholder: "{{__('cp.select')}}",
            allowClear: true
        });
        let maxImages = 6;
        let selectedColors = [];

        function addColor(colorId, colorName, images = []) {
            if (!colorId || !colorName || selectedColors.includes(colorId.toString())) return;

            selectedColors.push(colorId.toString());
            $("#colorSelect option[value='" + colorId + "']").prop("disabled", true);

            $('#colorSelect').val(null).trigger('change');

            let colorHtml = `
            <div class="col-md-6 color-item border p-2 mt-2 rounded shadow-sm" data-color="${colorId}">
                <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                    <strong class="color-name">${colorName}</strong>
                    <button type="button" class="btn btn-danger btn-sm removeColor">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                <input type="hidden" name="colors[]" value="${colorId}">
                <div class="row mt-2" id="imagesContainer-${colorId}">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-success btn-sm addImageBtn" data-color="${colorId}">
                            + {{__('cp.add_image')}}
                        </button>
                    </div>
                </div>
            </div>`;

            $("#selectedColorsContainer").append(colorHtml);

            if (images.length === 0) {
                addImage(colorId);
            } else {
                images.forEach(image => {
                addImage(colorId, image.id, image.image);
                });
            }
        }

            function addImage(colorId, imageId = null, imageUrl = null) {
            let imagesContainer = $("#imagesContainer-" + colorId);
            let imageCount = imagesContainer.find(".image-input").length;

            if (imageCount >= maxImages) {
                alert("{{ __('cp.max_images_message') }}");
                return;
            }

            let imageHtml = `
            <div class="col-md-4 mt-2 image-input" ${imageId ? `data-image-id="${imageId}" ` : '' }>
                <div class="image-preview-container">
                    ${imageUrl ? `<img src="${imageUrl}" class="img-thumbnail mt-1" style="width:100px; height:100px;">`
                    : `<input type="file" name="color_images[${colorId}][]" accept="image/*" class="form-control imageUpload"
                        data-preview="#preview-${colorId}-${imageCount}">
                    <img id="preview-${colorId}-${imageCount}" class="img-thumbnail mt-1"
                        style="display:none; width:100px; height:100px;">`}
                    <button type="button" class="btn btn-danger btn-sm removeImage mt-1" ${imageId ? `data-image-id="${imageId}" `
                        : '' }>
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>`;

            imagesContainer.append(imageHtml);
        }

        @if(isset($item) && @$item->exists)
            @foreach(@$item->productColorSizes as $productColor)
                @if(@$productColor->color_id != '')
                    addColor(
                        {{ @$productColor->color_id }},
                        "{{ @$productColor->color->name }}",
                        [
                                @foreach(@$productColor->images as $image)
                            { id: {{ @$image->id }}, image: "{{ @$image->image }}" },
                            @endforeach
                        ]
                    );
                @endif

            @endforeach
        @endif

        $("#colorSelect").on("select2:select", function (e) {
            let colorId = e.params.data.id;
            let colorName = e.params.data.text.trim();

            if (colorId && colorName) {
                addColor(colorId, colorName);
                $(this).val(null).trigger('change');
            }
        });

        $(document).on('click', '.select2-results__option', function() {
            setTimeout(function() {
                let colorId = $('#colorSelect').val();
                if (colorId) {
                    let colorName = $("#colorSelect option:selected").text().trim();
                    addColor(colorId, colorName);
                    $('#colorSelect').val(null).trigger('change');
                }
            }, 100);
        });

        $(document).on("click", ".addImageBtn", function () {
            let colorId = $(this).data("color");
            addImage(colorId);
        });

        $(document).on("change", ".imageUpload", function () {
            let input = this;
            let previewId = $(this).data("preview");
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $(previewId).attr("src", e.target.result).show();
                };
                reader.readAsDataURL(input.files[0]);
            }
        });

        $(document).on("click", ".removeImage", function () {
            let imageId = $(this).data("image-id");
            if (imageId) {
                $("<input>").attr({
                    type: "hidden",
                    name: "deleted_images[]",
                    value: imageId
                }).appendTo("form");
            }
            $(this).closest(".image-input").remove();
        });

        $(document).on("click", ".removeColor", function () {
        let colorItem = $(this).closest(".color-item");
        let colorId = colorItem.data("color").toString();

        selectedColors = selectedColors.filter(id => id !== colorId);

        $("#colorSelect option[value='" + colorId + "']").prop("disabled", false);

            $('#colorSelect').select2('destroy');
            $('#colorSelect').select2({
                placeholder: "{{__('cp.select')}}",
                allowClear: true
            });

        colorItem.remove();

        let select = $('#colorSelect');
        let parent = select.parent();
        select.detach().appendTo(parent);
        });
    });
</script>
@endsection
