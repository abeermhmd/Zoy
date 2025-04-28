@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.emailTexts'))}}
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{__('cp.emailTexts')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/emailTexts')}}" class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
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
                    <form method="post" action="{{url(app()->getLocale().'/admin/emailTexts/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.edit') }} {{__('cp.emailTexts')}} / {{$item->type_name}}</h3>
                        </div>
                        <div class="row">
                            @foreach($locales as $locale)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.subject_'.$locale->lang)}}</label>
                                        <input type="text" class="form-control" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}
                                        name="subject_{{$locale->lang}}" value="{{ isset($item->translate($locale->lang)->subject) ? old('subject_'.$locale->lang
                                    , $item->translate($locale->lang)->subject) : old('subject_'.$locale->lang ) }}" required/>
                                    </div>
                                </div>
                            @endforeach
                            @foreach($locales as $locale)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label
                                            for="content_{{$locale->lang}}">{{__('cp.content_'.$locale->lang)}}</label>
                                        <textarea class="form-control ckEditor-y" id="kt-ckeditor-{{$loop->index+4}}"
                                                  {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} name="content_{{$locale->lang}}"
                                                  id="content_{{$locale->lang}}" rows="4"
                                                  required>{!! @$item->translate($locale->lang)->content!!}</textarea>
                                    </div>
                                </div>
                            @endforeach

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
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/super-build/ckeditor.js"></script>
    @include('adminCpanel.settings.editor_script')
    <script src="{{ asset('/admin_assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script src="{{ asset('/admin_assets/js/pages/crud/forms/editors/ckeditor-classic.js') }}"></script>
    <script src="{{ asset('/admin_assets/plugins/custom/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/admin_assets/plugins/jquery/jquery.min.js') }}"></script>

@endsection
