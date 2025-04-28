@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.banners'))}}
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-settings-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-settings-center flex-wrap mr-1">
                    <div class="d-flex align-settings-baseline mr-5">
                        <h3>{{__('cp.adPopUp')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-settings-center">

                    <button id="submitButton" class="btn btn-success ">{{__('cp.save')}}</button>
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
                    <form method="post" action="{{ route('admins.adPopUpUpdate') }}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                        @csrf

                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.adPopUp')}}</h3>
                        </div>

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> {{__('cp.type_link')}}</label>
                                            <select class="select2 form-control" name="type_link" id="typeLink" required>
                                                <option value="">
                                                    {{__('cp.select')}}
                                                </option>
                                                <option value="1" {{ old('type_link', @$setting->type_link_pop) == 1 ? 'selected' : ''
                                                    }}>{{__('cp.nothing')}}</option>
                                                <option value="2" {{ old('type_link', @$setting->type_link_pop) == 2 ? 'selected' : ''
                                                    }}>{{__('cp.product')}}</option>
                                                <option value="3" {{ old('type_link', @$setting->type_link_pop) == 3 ? 'selected' : ''
                                                    }}>{{__('cp.main_category')}}</option>
                                                <option value="4" {{ old('type_link', @$setting->type_link_pop) == 4 ? 'selected' : ''
                                                    }}>{{__('cp.sub_category')}}</option>
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
                                                <option value="{{ $product->id }}" {{ (intval(old('product_id', @$setting->linked_id_pop)) ===
                                                    intval($product->id) &&
                                                    intval(old('type_link', @$setting->type_link_pop)) === 2) ? 'selected' : '' }}>
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
                                                <option value="{{ $oneCat->id }}" {{ (intval(old('category_id', @$setting->linked_id_pop)) ===
                                                    intval($oneCat->id) && intval(old('type_link', @$setting->type_link_pop)) === 3) ? 'selected' : '' }}>
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
                                                <option value="{{ $oneSub->id }}" {{ (old('linked_id', @$setting->linked_id_pop) == $oneSub->id &&
                                                    @$setting->type_link_pop == 4) ? 'selected' : '' }}>
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
                                            <div class="col-md-12" >
                                                <div class="fileinputForm">
                                                    <label>{{__('cp.image')}}</label>
                                                    <div class="fileinput-new thumbnail" onclick="document.getElementById('edit_image').click()"
                                                        style="cursor:pointer">
                                                        <img src="{{@$setting->ad_popUp_image ? @$setting->ad_popUp_image :  admin_assets('images/ChoosePhoto.png')}}"
                                                            id="editImage">
                                                    </div>
                                                    <div class="btn btn-change-img red" onclick="document.getElementById('edit_image').click()">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </div>
                                                    <input type="file" class="form-control" name="ad_popUp_image" id="edit_image" style="display:none">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        <button type="submit" id="submitForm" style="display:none"></button>
                    </form>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $("#typeLink").trigger('change');

        $(document.body).on("change", "#typeLink", function () {
            var value_option = $(this).val();

            $("#products, #categories, #subCategories").hide();
            $("#product_id, #category_id, #sub_category_id").removeAttr("required");
            $("#product_id, #category_id, #sub_category_id").trigger('change');

            if (value_option == 2) { // منتج
                $("#products").show();
                $("#product_id").attr("required", true);
            } else if (value_option == 3) { // تصنيف رئيسي
                $("#categories").show();
                $("#category_id").attr("required", true);
            } else if (value_option == 4) { // تصنيف فرعية
                $("#subCategories").show();
                $("#sub_category_id").attr("required", true);
            }
        });

        $("#typeLink").val("{{ old('type_link', @$setting->type_link_pop) }}").trigger("change");
    });
</script>
@endsection
