@extends('layout.adminLayout')
@section('title')
    {{ucwords(__('cp.setting'))}}
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{__('cp.setting')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
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
                    <form method="post" action="{{ route('admins.settings.update' , 1) }}" enctype="multipart/form-data"
                          class="form-horizontal" role="form" id="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.main_data')}}</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label
                                                for="title_{{$locale->lang}}">{{__('cp.title_web_'.$locale->lang)}}</label>
                                            <input type="text" class="form-control"
                                                   {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                                                   name="title_{{$locale->lang}}"
                                                   id="title_{{$locale->lang}}"
                                                   value="{{@$item->translate($locale->lang)->title}}"
                                                   required/>
                                        </div>
                                    </div>
                                @endforeach
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label
                                                for="instagram_text_footer_{{$locale->lang}}">{{__('cp.instagram_text_footer_'.$locale->lang)}}</label>
                                            <textarea class="form-control" id="kt-ckeditor-{{$loop->index+4}}"
                                                      {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} name="instagram_text_footer_{{$locale->lang}}"
                                                      id="instagram_text_footer_{{$locale->lang}}" rows="4"
                                                      required>{{ @$item->translate($locale->lang)->instagram_text_footer}}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.dashboard_paginate')}}</label>
                                        <input type="number" class="form-control" name="dashboard_paginate"
                                               value="{{$item->dashboard_paginate}}"
                                               required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.website_paginate')}}</label>
                                        <input type="number" class="form-control" name="website_paginate"
                                               value="{{$item->website_paginate}}"
                                               required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.remember_continue_order')}}</label>
                                        <input type="number" class="form-control" name="remember_continue_order"
                                               value="{{$item->remember_continue_order}}" min="1"
                                               required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.remember_abandoned_cart')}}</label>
                                        <input type="number" class="form-control" name="remember_abandoned_cart"
                                               value="{{$item->remember_abandoned_cart}}" min="1"
                                               required/>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.contact')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row col-sm-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('cp.email')}}</label>
                                        <input type="email" class="form-control" name="info_email"
                                               value="{{$item->info_email}}"
                                               required/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('cp.mobile')}}</label>
                                        <input type="text" class="form-control  " name="mobile"
                                               onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                               value="{{$item->mobile}}" required/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('cp.whatsApp')}}</label>
                                        <input type="text" class="form-control" name="whatsApp"
                                               onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                               value="{{$item->whatsApp}}" required/>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.soctial_media')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row col-sm-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.instagram')}}</label>
                                        <input type="text" class="form-control" name="instagram"
                                               value="{{@$item->instagram}}" required/>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.address')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            @foreach($locales as $locale)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="address_{{$locale->lang}}">{{__('cp.address_'.$locale->lang)}}</label>
                                        <input type="text" class="form-control"
                                               {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                                               name="address_{{$locale->lang}}"
                                               id="address_{{$locale->lang}}"
                                               value="{{ old('address', @$item->translate($locale->lang)->address) }}"
                                               required/>
                                    </div>
                                </div>
                            @endforeach
                                @foreach($locales as $locale)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="area_{{$locale->lang}}">{{__('cp.area_'.$locale->lang)}}</label>
                                        <input type="text" class="form-control"
                                               {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                                               name="area_{{$locale->lang}}"
                                               id="area_{{$locale->lang}}"
                                               value="{{ old('area', @$item->translate($locale->lang)->area) }}"
                                               required/>
                                    </div>
                                </div>
                            @endforeach
                                @foreach($locales as $locale)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="block_{{$locale->lang}}">{{__('cp.block_'.$locale->lang)}}</label>
                                        <input type="text" class="form-control"
                                               {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                                               name="block_{{$locale->lang}}"
                                               id="block_{{$locale->lang}}"
                                               value="{{ old('block', @$item->translate($locale->lang)->block) }}"
                                               required/>
                                    </div>
                                </div>
                            @endforeach
                                @foreach($locales as $locale)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="street_{{$locale->lang}}">{{__('cp.street_'.$locale->lang)}}</label>
                                        <input type="text" class="form-control"
                                               {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                                               name="street_{{$locale->lang}}"
                                               id="street_{{$locale->lang}}"
                                               value="{{ old('street', @$item->translate($locale->lang)->street) }}"
                                               required/>
                                    </div>
                                </div>
                            @endforeach
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.map_location_pinpoint')}}</label>
                                        <input type="text" class="form-control" name="map_location_pinpoint"
                                               value="{{@$item->map_location_pinpoint}}" required/>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.Currency rates against the Kuwaiti dinar')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row col-sm-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.BHD')}}</label>
                                        <input type="text" class="form-control" name="BHD"
                                               value="{{@$item->BHD}}" step="0.01" min="0" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.OMR')}}</label>
                                        <input type="text" class="form-control" name="OMR"
                                               value="{{@$item->OMR}}" step="0.01" min="0" required/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('cp.QAR')}}</label>
                                        <input type="text" class="form-control" name="QAR"
                                               value="{{@$item->QAR}}" step="0.01" min="0" required/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('cp.SAR')}}</label>
                                        <input type="text" class="form-control" name="SAR"
                                               value="{{@$item->SAR}}" step="0.01" min="0" required/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('cp.AED')}}</label>
                                        <input type="text" class="form-control" name="AED"
                                               value="{{@$item->AED}}" step="0.01" min="0" required/>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>

                <div class="tab-content mt-5">
                    <div class="tab-pane fade show active" id="myTabContent2" role="tabpanel"
                         aria-labelledby="content-tab-main2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fileinputForm">
                                        <label>{{__('cp.logo')}}</label>
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_image1').click()"
                                             style="cursor:pointer">
                                            <img src="{{$item->logo}}" id="editImage1">
                                        </div>
                                        <div class="btn btn-change-img red"
                                             onclick="document.getElementById('edit_image1').click()">
                                            <i class="fas fa-pencil-alt"></i>
                                        </div>
                                        <input type="file" class="form-control" name="logo" id="edit_image1"
                                               style="display:none">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fileinputForm">
                                        <label>{{__('cp.image')}}</label>
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_image').click()"
                                             style="cursor:pointer">
                                            <img src="{{$item->image}}" id="editImage">
                                        </div>
                                        <div class="btn btn-change-img red"
                                             onclick="document.getElementById('edit_image').click()">
                                            <i class="fas fa-pencil-alt"></i>
                                        </div>
                                        <input type="file" class="form-control" name="image" id="edit_image"
                                               style="display:none">
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
        @endsection
        @section('script')
        @endsection
        @section('js')
            <script>
                $('#edit_image').on('change', function (e) {
                    readURL(this, $('#editImage'));
                });
                $('#edit_image1').on('change', function (e) {
                    readURL(this, $('#editImage1'));
                });
                $('#edit_image2').on('change', function (e) {
                    readURL(this, $('#editImage2'));
                });
                $('#edit_image3').on('change', function (e) {
                    readURL(this, $('#editImage3'));
                });
                $('#edit_image4').on('change', function (e) {
                    readURL(this, $('#editImage4'));
                });
            </script>

@endsection
