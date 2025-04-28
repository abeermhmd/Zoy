@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.pages'))}}
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{__('cp.pages')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/pages')}}" class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
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
                    <form method="post" action="{{url(app()->getLocale().'/admin/pages/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.edit') }} {{__('cp.pages')}}</h3>
                        </div>
                        <div class="row">
                            @foreach($locales as $locale)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.name_'.$locale->lang)}}</label>
                                    <input type="text" class="form-control" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                                    name="name_{{$locale->lang}}" value="{{ isset($item->translate($locale->lang)->name) ? old('name_'.$locale->lang
                                    , $item->translate($locale->lang)->name) : old('name_'.$locale->lang ) }}" required/>
                                </div>
                            </div>
                            @endforeach
                                @foreach($locales as $locale)
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label
                                                for="description_{{$locale->lang}}">{{__('cp.description_'.$locale->lang)}}</label>
                                            <textarea class="form-control" id="kt-ckeditor-{{$loop->index+4}}"
                                                      {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} name="description_{{$locale->lang}}"
                                                      id="description_{{$locale->lang}}" rows="4"
                                                      required>{!! @$item->translate($locale->lang)->description!!}</textarea>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            @if($item->id == 1)
                            <div class="tab-content mt-5">
                                <div class="tab-pane fade show active" id="myTabContent2" role="tabpanel"
                                    aria-labelledby="content-tab-main2">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="fileinputForm">
                                                    <label>{{__('cp.image')}}</label>
                                                    <div class="fileinput-new thumbnail"
                                                        onclick="document.getElementById('edit_image').click()" style="cursor:pointer">
                                                        <img src="{{ isset($item) && $item->image ? $item->image :  url(admin_assets('/images/ChoosePhoto.png'))}}" id="editImage">
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
                            @endif
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
        <script src="{{asset('/admin_assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js')}}"></script>
        <script src="{{asset('/admin_assets/js/pages/crud/forms/editors/ckeditor-classic.js')}}"></script>
    <script>
        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });
    </script>
@endsection
