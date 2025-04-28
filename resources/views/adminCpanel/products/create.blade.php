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
                    <h3>{{__('cp.products')}}</h3>
                </div>
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <a href="{{route('admins.products.index')}}" class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
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
                <form method="post" action="{{route('admins.products.store')}}" enctype="multipart/form-data"
                    class="form-horizontal" role="form" id="form">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">{{__('cp.add')}} {{ucwords(__('cp.products'))}}</h3>
                    </div>
                    @include('adminCpanel.products.__form')
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
