@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.shippingManagement'))}}
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <h3>{{__('cp.shipping_content')}}</h3>
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
                <form method="post" action="{{ route('admins.update.shipping.content') }}" enctype="multipart/form-data"
                    class="form-horizontal" role="form" id="form">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">{{__('cp.shipping_content')}}</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                          @foreach($locales as $locale)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shipping_content_kuwait_{{$locale->lang}}">{{__('cp.shipping_content_kuwait_'.$locale->lang)}}</label>
                                    <textarea class="form-control" id="kt-ckeditor-{{$loop->index+4}}"  {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} name="shipping_content_kuwait_{{$locale->lang}}" id="shipping_content_kuwait_{{$locale->lang}}" rows="4" required>{{ @$item->translate($locale->lang)->shipping_content_kuwait}}</textarea>
                                </div>
                            </div>
                        @endforeach
                        @foreach($locales as $locale)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shipping_content_outside_kuwait_{{$locale->lang}}">{{__('cp.shipping_content_outside_kuwait_'.$locale->lang)}}</label>
                                    <textarea class="form-control" id="kt-ckeditor-{{$loop->index+4}}"
                                        {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} name="shipping_content_outside_kuwait_{{$locale->lang}}"
                                                        id="shipping_content_outside_kuwait_{{$locale->lang}}" rows="4" required>{{ @$item->translate($locale->lang)->shipping_content_outside_kuwait}}</textarea>
                                </div>
                            </div>
                         @endforeach
                        </div>
                    </div>

            </div>
            <button type="submit" id="submitForm" style="display:none"></button>
            </form>
        </div>
        <!--end::Card-->
    </div>
    @endsection

