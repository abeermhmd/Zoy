@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.banners'))}}
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{ucwords(__('cp.banners'))}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div>
                    <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                        <button type="button" class="btn btn-secondary" href="#activation" role="button"
                                data-toggle="modal">
                            <i class="icon-xl la la-check"></i>
                            <span>{{__('cp.active')}}</span>
                        </button>
                        <button type="button" class="btn btn-secondary" href="#cancel_activation" role="button"
                                data-toggle="modal">
                            <i class="icon-xl la la-ban"></i>
                            <span>{{__('cp.not_active')}}</span>
                        </button>
                        <button type="button" class="btn btn-secondary" href="#deleteAll" role="button" data-toggle="modal">
                            <i class="flaticon-delete"></i>
                            <span>{{__('cp.delete')}}</span>
                        </button>
                    </div>
                    <a href="{{url(getLocal().'/admin/banners/create')}}" class="btn btn-secondary  mr-2 btn-success">
                        <i class="icon-xl la la-plus"></i>
                        <span>{{__('cp.add')}}</span>
                    </a>
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
                        <button type="button" class="btn btn-secondar btn--filter mr-2"><i
                                class="icon-xl la la-sliders-h"></i>{{__('cp.filter')}}</button>
                        <div class="container box-filter-collapse">
                            <div class="card">
                                <form class="form-horizontal" method="get"
                                      action="{{url(app()->getLocale().'/admin/banners')}}">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.type')}}</label>
                                                <select id="multiple2" class="form-control" name="type">
                                                    <option value="">{{__('cp.all')}}</option>
                                                    <option value="1" {{request('type') == 1 ? 'selected' : ''}}>{{__('cp.image')}}</option>
                                                    <option value="2" {{request('type') == 2 ? 'selected' : ''}}>{{__('cp.video')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.type_link')}}</label>
                                                <select id="multiple2" class="form-control" name="type_link">
                                                    <option value="">{{__('cp.all')}}</option>
                                                    <option value="1" {{ request('type_link') == 1 ? 'selected' : '' }}>{{__('cp.nothing')}}</option>
                                                    <option value="2" {{ request('type_link') == 2 ? 'selected' : '' }}>{{__('cp.product')}}</option>
                                                    <option value="3" {{ request('type_link') == 3 ? 'selected' : '' }}>{{__('cp.main_category')}}</option>
                                                    <option value="4" {{ request('type_link') == 4 ? 'selected' : '' }}>{{__('cp.sub_category')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.status')}}</label>
                                                <select id="multiple2" class="form-control"name="status">
                                                    <option value="">{{__('cp.all')}}</option>
                                                    <option
                                                        value="active" {{('status') == 'active'?'selected':''}}>
                                                        {{__('cp.active')}}
                                                    </option>
                                                    <option
                                                        value="not_active" {{request('status') == 'not_active'?'selected':''}}>
                                                        {{__('cp.not_active')}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <button type="submit"
                                                    class="btn sbold btn-default btnSearch">{{__('cp.search')}}
                                                <i class="fa fa-search"></i>
                                            </button>

                                            <a href="{{url(app()->getLocale().'/admin/banners')}}" type="submit"
                                               class="btn sbold btn-default btnRest">{{__('cp.reset')}}
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div
                            class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                            <div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                <thead>
                                <tr>
                                    <th class="wd-1p no-sort">
                                        <div class="checkbox-inline">
                                            <label class="checkbox">
                                                <input type="checkbox" name="checkAll" />
                                                <span></span></label>
                                        </div>
                                    </th>
                                    <th> {{ucwords(__('cp.image')) .' / '. ucwords(__('cp.video'))}}  </th>
                                    <th> {{ucwords(__('cp.type_link'))}}</th>
                                    <th> {{ucwords(__('cp.status'))}}</th>
                                    <th> {{ucwords(__('cp.created'))}}</th>
                                    <th> {{ucwords(__('cp.action'))}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse(@$items as $item)
                                    <tr class="odd gradeX" id="tr-{{$item->id}}">
                                        <td class="v-align-middle wd-5p">
                                            <div class="checkbox-inline">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="{{$item->id}}"  class="checkboxes" name="chkBox" />
                                                    <span></span></label>
                                            </div>
                                        </td>
                                        <td class="v-align-middle wd-5p" style="text-align: center; vertical-align: middle;">
                                            @if(@$item->type == 1)
                                            <img src="{{ @$item->image }}"
                                                style="width: 100%; max-width: 130px; height: 130px; object-fit: cover; display: block; border-radius: 5px;">
                                            @elseif(@$item->type == 2)
                                            <video style="width: 130px; height: 130px; object-fit: cover; display: block; border-radius: 5px;" controls>
                                                <source src="{{ @$item->image }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            @else
                                            <span>No media available</span>
                                            @endif
                                        </td>
                                        <td >@if($item->type_link == 1) {{__('cp.nothing')}} @elseif($item->type_link == 2) {{__('cp.products')}} @elseif($item->type_link == 3) {{__('cp.main_category')}} @elseif($item->type_link == 4) {{__('cp.sub_category')}} @endif</td>
                                        <td class="v-align-middle wd-10p">
                                            <span id="label-{{$item->id}}"  class="badge badge-pill badge-{{($item->status == "active") ? "info" : "danger"}}"> {{__('cp.'.$item->status)}}</span>
                                        </td>
                                        <td class="center">{{$item->created_at->format('Y-m-d')}}</td>
                                        <td>
                                            <div class="btn-group btn-action">
                                                <a  href="{{url(getLocal().'/admin/banners/'.$item->id.'/edit')}}"
                                                   class="btn btn-sm btn-clean btn-icon" title="{{__('cp.edit')}}">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <div style="text-align: center; color: #555; font-weight: bold; font-size: 18px; margin: 15px; padding: 20px; border: 2px dashed #ccc; border-radius: 10px; background-color: #f9f9f9;"
                                        id="no-data-message">
                                        @lang('cp.no_data')
                                    </div>
                                @endforelse
                                </tbody>
                            </table>
                            {{$items->appends($_GET)->links("pagination::bootstrap-4") }}
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
