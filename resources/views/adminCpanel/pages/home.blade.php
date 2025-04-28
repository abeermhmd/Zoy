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
                    <h3>{{ucwords(__('cp.pages'))}}</h3>
                </div>
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
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
            <div class="gutter-b example example-compact">
                <div class="contentTabel">
                    <div
                        class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                        <div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover tableWithSearch" id="tableWithSearch">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th> {{ucwords(__('cp.title'))}}</th>
                                    <th> {{ucwords(__('cp.created'))}}</th>
                                    <th> {{ucwords(__('cp.action'))}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(@$pages as $page)
                                <td>
                                    <span>{{$loop->iteration}}</span>
                                    </label>
                                </td>
                                <td>{{$page->name}}</td>
                                <td>{{$page->created_at->format('Y-m-d')}}</td>
                                <td>
                                    <div class="btn-group btn-action">
                                        <a href="{{url(getLocal().'/admin/pages/'.$page->id.'/edit')}}"
                                            class="btn btn-sm btn-clean btn-icon" title="{{__('cp.edit')}}">
                                            <i class="la la-edit"></i>
                                        </a>
                                    </div>
                                </td>
                                </tr>
                                @empty
                                {{__('cp.no')}}
                                @endforelse
                            </tbody>
                        </table>
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
