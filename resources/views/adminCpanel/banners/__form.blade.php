<div class="card-body">
    <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label"> {{__('cp.type')}}</label>
            <select class="select2 form-control" name="type" id="type">
                <option value="">
                    {{__('cp.select')}}
                </option>
                <option value="1" {{ old('type', @$item->type) == 1 ? 'selected' : '' }}>{{__('cp.image')}}</option>
                <option value="2" {{ old('type', @$item->type) == 2 ? 'selected' : '' }}>{{__('cp.video')}}</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label"> {{__('cp.type_link')}}</label>
            <select class="select2 form-control" name="type_link" id="typeLink" required>
                <option value="">
                    {{__('cp.select')}}
                </option>
                <option value="1" {{ old('type_link', @$item->type_link) == 1 ? 'selected' : '' }}>{{__('cp.nothing')}}</option>
                <option value="2" {{ old('type_link', @$item->type_link) == 2 ? 'selected' : '' }}>{{__('cp.product')}}</option>
                <option value="3" {{ old('type_link', @$item->type_link) == 3 ? 'selected' : '' }}>{{__('cp.main_category')}}</option>
                <option value="4" {{ old('type_link', @$item->type_link) == 4 ? 'selected' : '' }}>{{__('cp.sub_category')}}</option>
            </select>
        </div>
    </div>

    <div class="col-md-6" id="products">
        <div class="form-group">
            <label class="control-label"> {{__('cp.product')}}</label>
            <select class="select2 form-control" name="product_id" id="product_id">
                <option value="">
                    {{__('cp.select')}}
                </option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ (intval(old('product_id', @$item->linked_id)) === intval($product->id) &&
                        intval(old('type_link', @$item->type_link)) === 2) ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6" id="categories">
        <div class="form-group">
            <label class="control-label"> {{__('cp.main_category')}}</label>
            <select class="select2 form-control" name="category_id" id="category_id">
                <option value="">
                    {{__('cp.select')}}
                </option>
                @foreach ($main_categories as $oneCat)
                    <option value="{{ $oneCat->id }}" {{ (intval(old('category_id', @$item->linked_id)) === intval($oneCat->id) && intval(old('type_link', @$item->type_link)) === 3) ? 'selected' : '' }}>
                        {{ $oneCat->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6" id="subCategories">
        <div class="form-group">
            <label class="control-label"> {{__('cp.sub_category')}}</label>
            <select class="select2 form-control" name="sub_category_id" id="sub_category_id">
                <option value="">
                    {{__('cp.select')}}
                </option>
               @foreach ($sub_categories as $oneSub)
               <option value="{{ $oneSub->id }}" {{ (old('linked_id', @$item->linked_id) == $oneSub->id && @$item->type_link == 4) ? 'selected' : '' }}>
                    {{ $oneSub->name }}
                </option>
                @endforeach

            </select>
        </div>
    </div>
</div>
<div class="tab-content mt-5">
    <div class="tab-pane fade show active" id="myTabContent2" role="tabpanel" aria-labelledby="content-tab-main2">
        <div class="row">
            <div class="col-md-6" id="image">
                <div class="fileinputForm">
                    <label>{{__('cp.image')}} <span style="display: inline-block; color: #2c3e50; background: linear-gradient(to right, #ecf0f1, #bdc3c7); padding: 3px 8px; border-radius: 4px; font-size: 0.9em; box-shadow: 1px 1px 3px rgba(0,0,0,0.1);">( 1728px X 972px)</span></label>

                    <div class="fileinput-new thumbnail" onclick="document.getElementById('edit_image').click()"
                        style="cursor:pointer">
                        <img src="{{@$item->image && @$item->type == 1 ? @$item->image :  admin_assets('images/ChoosePhoto.png')}}" id="editImage">
                    </div>
                    <div class="btn btn-change-img red" onclick="document.getElementById('edit_image').click()">
                        <i class="fas fa-pencil-alt"></i>
                    </div>
                    <input type="file" class="form-control" name="image" id="edit_image" style="display:none">
                </div>
            </div>
            <div class="col-md-6" id="video">
                <div class="form-group">
                    <label>{{__('cp.video')}} <span style="display: inline-block; color: #2c3e50; background: linear-gradient(to right, #ecf0f1, #bdc3c7); padding: 3px 8px; border-radius: 4px; font-size: 0.9em; box-shadow: 1px 1px 3px rgba(0,0,0,0.1);">( 1728px X 972px)</span></label>

                    <input type="file" class="form-control" name="url" value="{{ old('image')}}" id="video_input"/>
                </div>
            </div>
            @if (@$item->type == 2)
            <div class="col-md-8">
                <div class="form-group">
                    @if(@$item->image)
                    <video controls style="max-width: 100%; height: auto; width: 400px;">
                        <source src="{{ @$item->image }}" type="video/mp4">
                    </video>
                    @else
                    <p>No video available.</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</div>

@section('js')
<script>
    $(document).ready(function () {
        $("#type").trigger('change');
        $("#typeLink").trigger('change');

    $(document).ready(function () {
    $(document.body).on("change", "#type", function () {
        var value_option = $(this).val();
        var currentUrl = window.location.href;
        var isEdit = currentUrl.includes("/edit");
        var hasVideo = "{{ @$item->image && @$item->type == 2 ? 'true' : 'false' }}"; // التحقق من وجود فيديو محمل مسبقًا
        var hasImage = "{{ @$item->image && @$item->type == 1 ? 'true' : 'false' }}"; // التحقق من وجود صورة محملة مسبقًا

        if (value_option == 1) {
            $("#image").show();
            $("#video").hide();

            if (!(isEdit && hasImage === 'true')) {
                $("#edit_image").attr("required", true);
            } else {
                $("#edit_image").removeAttr("required");
            }
            $("#video_input").removeAttr("required");
        } else if (value_option == 2) {
            $("#video").show();
            $("#image").hide();

            if (!(isEdit && hasVideo === 'true')) {
                $("#video_input").attr("required", true);
            } else {
                $("#video_input").removeAttr("required");
            }

            $("#edit_image").removeAttr("required");
        } else {
            $("#video, #image").hide();
            $("#edit_image, #video_input").removeAttr("required");
        }
    });

    $("#type").val("{{ old('type', @$item->type) }}").trigger("change");
    });

    $(document.body).on("change", "#typeLink", function () {
        var value_option = $(this).val();

        var currentUrl = window.location.href;
        var isEdit = currentUrl.includes("/edit");

        $("#products, #categories, #subCategories").hide();
        if (isEdit) {
            $("#product_id, #category_id, #sub_category_id").trigger('change').removeAttr("required");
        } else {
                $("#product_id, #category_id, #sub_category_id").val('').trigger('change').removeAttr("required");
        }
          if (value_option == 2) {
            $("#products").show();
            $("#product_id").attr("required", true);
        } else if (value_option == 3) {
            $("#categories").show();
            $("#category_id").attr("required", true);
        } else if (value_option == 4) {
            $("#subCategories").show();
            $("#sub_category_id").attr("required", true);
        }
    });

        $("#type").val("{{ old('type', @$item->type) }}").trigger("change");
        $("#typeLink").val("{{ old('type_link', @$item->type_link) }}").trigger("change");
    });
</script>
@endsection
