@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.contact'))}}
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{ucwords(__('cp.contact'))}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->


                <div>
                    <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">

                        <button type="button" class="btn btn-secondary" href="#deleteAll" role="button"
                                data-toggle="modal">
                            <i class="flaticon-delete"></i>
                            <span>{{__('cp.delete')}}</span>
                        </button>

                    </div>

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
                                      action="{{url(getLocal().'/admin/contact')}}">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.name')}}</label>
                                                <input type="text" value="{{request('name')?request('name'):''}}"
                                                       class="form-control" name="name" placeholder="{{__('cp.name')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.email')}}</label>
                                                <input type="text" value="{{request('email')?request('email'):''}}"
                                                       class="form-control" name="email" placeholder="{{__('cp.email')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.mobile')}}</label>
                                                <input type="text" value="{{request('mobile')?request('mobile'):''}}"  onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                                       class="form-control" name="mobile" placeholder="{{__('cp.mobile')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.status')}}</label>
                                                <select id="multiple2" class="form-control"
                                                        name="status">
                                                    <option value="">{{__('cp.all')}}</option>
                                                    <option value="1" {{request('status') == '1'?'selected':''}}>
                                                        {{__('cp.read')}}
                                                    </option>
                                                    <option value="0" {{request('status') == '0'?'selected':''}}>
                                                        {{__('cp.pending')}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <button type="submit"
                                                    class="btn sbold btn-default btnSearch">{{__('cp.search')}}
                                                <i class="fa fa-search"></i>
                                            </button>

                                            <a href="{{url(app()->getLocale().'/admin/contact')}}" type="submit"
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
                                <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                    <thead>
                                    <tr>
                                    <tr>
                                        <th class="wd-1p no-sort">
                                            <div class="checkbox-inline">
                                                <label class="checkbox">
                                                    <input type="checkbox" name="checkAll"/>
                                                    <span></span></label>
                                            </div>
                                        </th>
                                        <th> {{ucwords(__('cp.name'))}}</th>
                                        <th> {{ucwords(__('cp.email'))}}</th>
                                        <th> {{ucwords(__('cp.mobile'))}}</th>
                                        <th> {{ucwords(__('cp.status'))}}</th>
                                        <th> {{ucwords(__('cp.created'))}}</th>
                                        <th> {{ucwords(__('cp.action'))}}</th>
                                    </tr>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($items as $item)
                                        <tr class="odd gradeX" id="tr-{{$item->id}}">
                                            <td class="v-align-middle wd-5p">
                                                <div class="checkbox-inline">
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="{{$item->id}}" class="checkboxes" name="chkBox"/>
                                                        <span></span></label>
                                                </div>
                                            </td>
                                            <td> {{@$item->name}}</td>
                                            <td> <a href="mailto:{{@$item->email}}"> {{@$item->email}}</a></td>
                                            <td> <a> {{@$item->mobile}}</a></td>

                                            <td class="v-align-middle wd-10p"> <span id="label-{{$item->id}}"
                                                                                     class="badge badge-pill badge-{{($item->read == 1)
                                                            ? "info" : "danger"}}" id="label-{{$item->id}}">
    @if($item->read == 1)
                                                        {{__('cp.read')}}
                                                    @else
                                                        {{__('cp.pending')}}
                                                    @endif
                                                        </span>
                                            </td>
                                            <td> {{$item->created_at->format('Y-m-d')}}</td>
                                            <td>
                                                <div class="btn-group btn-action">
                                                    <a href="{{url(getLocal().'/admin/viewMessage/'.$item->id)}}"
                                                       class="btn btn-sm btn-clean btn-icon" title="{{__('cp.show')}}">
                                                        <i class="la la-edit"></i>
                                                    </a>
                                                    <div id="myModal{{$item->id}}" class="modal fade" tabindex="-1"
                                                         role="dialog" aria-labelledby="myModalLabel1"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal"
                                                                            aria-hidden="true"></button>
                                                                    <h4 class="modal-title">{{__('cp.delete')}}</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{__('cp.confirm')}} </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn default" data-dismiss="modal"
                                                                            aria-hidden="true">{{__('cp.cancel')}}</button>
                                                                    <a href="#"
                                                                       onclick="delete_adv('{{$item->id}}','{{$item->id}}',event)">
                                                                        <button
                                                                            class="btn btn-danger">{{__('cp.delete')}}</button>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
