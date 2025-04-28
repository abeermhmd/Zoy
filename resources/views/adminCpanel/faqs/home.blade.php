@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.faqs'))}}
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{ucwords(__('cp.faqs'))}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div>
                    <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                        <button type="button" class="btn btn-secondary" href="#activation" role="button"  data-toggle="modal">
                            <i class="icon-xl la la-check"></i>
                            <span>{{__('cp.active')}}</span>
                        </button>
                        <button type="button" class="btn btn-secondary" href="#cancel_activation" role="button"  data-toggle="modal">
                            <i class="icon-xl la la-ban"></i>
                            <span>{{__('cp.not_active')}}</span>
                        </button>
                        <button type="button" class="btn btn-secondary" href="#deleteAll" role="button" data-toggle="modal">
                            <i class="flaticon-delete"></i>
                            <span>{{__('cp.delete')}}</span>
                        </button>
                    </div>

                    <a href="{{route('admins.faqs.create')}}" class="btn btn-secondary  mr-2 btn-success">
                        <i class="icon-xl la la-plus"></i>
                        <span>{{__('cp.add')}} </span>
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
                        <button  type="button" class="btn btn-secondar btn--filter mr-2"><i class="icon-xl la la-sliders-h"></i>{{__('cp.filter')}}</button>
                        <div class="container box-filter-collapse" >
                            <div class="card" >
                                <form class="form-horizontal" method="get" action="{{route('admins.faqs.index')}}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.question')}}</label>
                                                <input type="text" class="form-control" name="question" placeholder="{{__('cp.question')}}"
                                                    value="{{request('question')?request('question'):''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.Answer')}}</label>
                                                <input type="text" class="form-control" name="answer" placeholder="{{__('cp.Answer')}}"
                                                    value="{{request('answer')?request('answer'):''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.status')}}</label>
                                                <select id="multiple2" class="form-control"
                                                        name="status">
                                                    <option value="">{{__('cp.all')}}</option>
                                                    <option value="active" @selected(request('status') == 'active')>
                                                        {{__('cp.active')}}
                                                    </option>
                                                    <option value="not_active" @selected(request('status') == 'not_active')>
                                                        {{__('cp.not_active')}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <button type="submit" class="btn sbold btn-default btnSearch">{{__('cp.search')}}
                                                <i class="fa fa-search"></i>
                                            </button>

                                            <a href="{{ route('admins.faqs.index') }}" type="submit" class="btn sbold btn-default btnRest">{{__('cp.reset')}}
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
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
                                                <input type="checkbox" name="checkAll" /> <span></span></label>
                                        </div>
                                    </th>
                                    <th class="wd-25p"> {{ucwords(__('cp.question'))}}</th>
                                    <th class="wd-25p"> {{ucwords(__('cp.Answer'))}}</th>
                                    <th class="wd-10p"> {{ucwords(__('cp.status'))}}</th>
                                    <th class="wd-10p"> {{ucwords(__('cp.created'))}}</th>
                                    <th class="wd-15p"> {{ucwords(__('cp.action'))}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($items as $one)
                                    <tr class="odd gradeX" id="tr-{{@$one->id}}">
                                        <td class="v-align-middle wd-5p">
                                            <div class="checkbox-inline">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="{{@$one->id}}"  class="checkboxes" name="chkBox" />
                                                    <span></span></label>
                                            </div>
                                        </td>

                                        <td class="v-align-middle wd-25p">{{ Illuminate\Support\Str::limit(@$one->question, 60) }}</td>
                                        <td class="v-align-middle wd-25p">{{ Illuminate\Support\Str::limit(@$one->answer, 60) }}</td>
                                        <td class="v-align-middle wd-10p" > <span id="label-{{@$one->id}}" class="badge badge-pill badge-{{(@$one->status == "active")
                                            ? "info" : "danger"}}" id="label-{{@$one->id}}">

                                            {{__('cp.'.@$one->status)}}
                                        </span>
                                        </td>

                                        <td class="v-align-middle wd-10p">{{@@$one->created_at->format('Y-m-d')}}</td>

                                        <td class="v-align-middle wd-15p optionAddHours">

                                            <a href="{{route('admins.faqs.edit' , @@$one->id)}}"
                                               class="btn btn-sm btn-clean btn-icon" title="{{__('cp.edit')}}">
                                                <i class="la la-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <div style="text-align: center; color: #555; font-weight: bold; font-size: 18px; margin: 15px; padding: 20px; border: 2px dashed #ccc; border-radius: 10px; background-color: #f9f9f9;">
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
