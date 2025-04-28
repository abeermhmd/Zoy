@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.newsletter_management'))}}
@endsection
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <h3>{{__('cp.newsletters')}}</h3>
                </div>
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <a href="{{ route('admins.newsletters.index') }}" class="btn btn-secondary mr-2">{{__('cp.cancel')}}</a>
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
                    <h3 class="card-title">{{__('cp.show')}} {{ucwords(__('cp.newsletters'))}}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($locales as $locale)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('cp.subject_' . $locale->lang) }}</label>
                                <p class="form-control-plaintext" {{ ($locale->lang == 'ar') ? 'dir=rtl' : '' }}>
                                    {{ $item->translate($locale->lang)->subject ?? '-' }}
                                </p>
                            </div>
                        </div>
                        @endforeach

                            @foreach($locales as $locale)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="content_{{ $locale->lang }}">{{ __('cp.content_' . $locale->lang) }}</label>
                                        <textarea class="form-control kt-ckeditor ckEditor-y" id="kt-ckeditor-{{ $loop->index+4 }}" {{
                    ($locale->lang == 'ar') ? 'dir=rtl' : '' }}
                                        name="content_{{ $locale->lang }}"
                                                  rows="4"
                                                  disabled>{!! old('content_' . $locale->lang, @$item->translate($locale->lang)->content) !!}</textarea>
                                        @error('content_' . $locale->lang)
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('cp.status') }}</label>
                                <p class="form-control-plaintext">
                                    {{ ucfirst(__("cp.{$item->status}")) }}
                                </p>
                            </div>
                        </div>

                        @if($item->status === 'scheduled')
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('cp.date') }}</label>
                                <p class="form-control-plaintext">
                                    {{ $item->date ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('cp.time') }}</label>
                                <p class="form-control-plaintext">
                                    {{ $item->time ?? '-' }}
                                </p>
                            </div>
                        </div>
                        @endif
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
@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/super-build/ckeditor.js"></script>
    @include('adminCpanel.settings.editor_script')
    <script src="{{ asset('/admin_assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script src="{{ asset('/admin_assets/js/pages/crud/forms/editors/ckeditor-classic.js') }}"></script>
    <script src="{{ asset('/admin_assets/plugins/custom/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/admin_assets/plugins/jquery/jquery.min.js') }}"></script>
@endsection
