@extends('layout.adminLayout')
@section('title')
    {{ucwords(__('cp.orders'))}}
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{ucwords(__('cp.orders'))}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->

                <div>
                    <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                        <a href="{{url(getLocal().'/admin/exportOrders?')}}@foreach(request()->query() as $key => $one){{$key}}={{$one}}&@endforeach"
                           class="btn btn-secondary  mr-2 btn-success">
                            <i class="icon-xl la la-file-excel"></i>
                            <span>{{__('cp.export')}}</span>
                        </a>
                    </div>
                </div>
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
                                <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/orders')}}">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.order_id')}}</label>
                                                <input type="text" class="form-control" name="order_id"
                                                       placeholder="{{__('cp.order_id')}}"
                                                       value="{{request('order_id')?request('order_id'):''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.total')}}</label>
                                                <input type="number" class="form-control" name="total"
                                                       placeholder="{{__('cp.total')}}"
                                                       value="{{request('total')?request('total'):''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.customer')}}</label>
                                                <input type="text" class="form-control pull-right"
                                                       value="{{request('name')?request('name'):''}}"
                                                       name="name">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.email')}}</label>
                                                <input type="email" class="form-control pull-right"
                                                       value="{{request('email')?request('email'):''}}"
                                                       name="email">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.mobile')}}</label>
                                                <input type="number" class="form-control pull-right"
                                                       value="{{request('mobile')?request('mobile'):''}}"
                                                       name="mobile">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.start_date')}}</label>
                                                <input type="date" class="form-control pull-right"
                                                       value="{{request('start_date')?request('start_date'):''}}"
                                                       name="start_date" id="from_date">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.end_date')}}</label>
                                                <input type="date" class="form-control pull-right"
                                                       value="{{request('end_date')?request('end_date'):''}}"
                                                       name="end_date" id="to_date">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">{{__('cp.ReqStatus')}}</label>
                                                <select id="multiple2" class="form-control"
                                                        name="status">
                                                    <option value="">{{__('cp.all')}}</option>
                                                    <option value="0" {{request('status') == '1'?'selected':''}}>
                                                        {{__('website.placed')}}
                                                    </option>
                                                    <option value="1" {{request('status') == '1'?'selected':''}}>
                                                        {{__('website.onWay')}}
                                                    </option>
                                                    <option value="2" {{request('status') == '2'?'selected':''}}>
                                                        {{__('website.delivered')}}
                                                    </option>
                                                    <option value="3" {{request('status') == '3'?'selected':''}}>
                                                        {{__('website.cancelled')}}
                                                    </option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <button type="submit"
                                                    class="btn sbold btn-default btnSearch">{{__('cp.search')}}
                                                <i class="fa fa-search"></i>
                                            </button>

                                            <a href="{{url(getLocal().'/admin/orders')}}" type="submit"
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
                                    <th class="wd-1p no-sort">#</th>
                                    <th>{{__('cp.order_id')}}</th>
                                    <th>{{__('cp.customer')}}</th>
                                    <th>{{__('cp.email')}}</th>
                                    <th>{{__('cp.mobile')}}</th>
                                    <th>{{__('cp.total')}} / {{__('cp.KD')}} </th>
                                    <th>{{__('cp.delivery_cost')}} / {{__('cp.KD')}} </th>
                                    <th>{{__('cp.ReqStatus')}}</th>
                                    <th>{{__('cp.order_date')}}</th>
                                    <th>{{__('cp.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse(@$items as $one)
                                    <tr>
                                        <td> {{ $loop->iteration }}</td>
                                        <td>{{@$one->id}}</td>
                                        <td>{{@$one->user->name ?? @$one->name}}</td>
                                        <td>{{@$one->user->email ??  @$one->email}}</td>
                                        <td>{{@$one->user->mobile ??  @$one->mobile}}</td>
                                        <td>{{number_format(@$one->total,3)}}</td>
                                        <td>{{number_format(@$one->delivery_fees,3)}}</td>
                                        <td>
                                                <?php
                                                $cls = '';
                                                //	0->Placed , 1->On the Way , 2->Delivered , 3->Canceled
                                                switch ($one->status) {
                                                    case 0:
                                                        $cls = 'info';
                                                        break;
                                                    case 1:
                                                        $cls = 'warning';
                                                        break;
                                                    case 2:
                                                        $cls = 'success';
                                                        break;
                                                    case 3:
                                                        $cls = 'danger';
                                                        break;
                                                    default:
                                                        $cls = 'secondary';
                                                        break;
                                                }
                                                ?>
                                            <span class="badge badge-pill badge-{{$cls}}">
                                            {{$one->status_name}}
                                        </span>
                                        </td>

                                        <td>{{@$one->created_at->format('d/m/y')}}
                                            | {{@$one->created_at->format('h:m A')}}</td>

                                        <td>
                                            <div class="btn-group btn-action">
                                                <a href="{{url(getLocal().'/admin/orders/'.$one->id.'/edit')}}"
                                                   class="btn btn-sm btn-clean btn-icon" title="{{__('cp.edit')}}">
                                                    <i class="la la-edit"></i>
                                                </a>
                                                <a href="{{url(getLocal().'/admin/orders/'.$one->id)}}" target="_blank"
                                                   class="btn btn-sm btn-clean btn-icon" title="{{__('cp.invoice')}}">
                                                    <i class="la la-file-invoice"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <div
                                        style="text-align: center; color: #555; font-weight: bold; font-size: 18px; margin: 15px; padding: 20px; border: 2px dashed #ccc; border-radius: 10px; background-color: #f9f9f9;"
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
