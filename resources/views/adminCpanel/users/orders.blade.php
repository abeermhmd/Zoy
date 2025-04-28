@extends('adminCpanel.users.sideMenu')
@section('companyContent')

    <!--begin::Advance Table: Widget 7-->
    <div class="card card-custom gutter-b">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">{{__('cp.orders')}} </span>

            </h3>

        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-2">
            <!--begin::Table-->
            <div class="table-responsive">
                <button type="button" class="btn btn-secondar btn--filter mr-2"><i
                        class="icon-xl la la-sliders-h"></i>{{__('cp.filter')}}</button>
                <div class="container box-filter-collapse">
                    <div class="card">
                        <form class="form-horizontal" method="get"
                              action="{{url(getLocal().'/admin/users/'.$item->id.'/orders')}}">
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
                                <div class="col-md-6">
                                    <button type="submit" class="btn sbold btn-default btnSearch">{{__('cp.search')}}
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <a href="{{url(getLocal().'/admin/users/'.$item->id.'/orders')}}" type="submit"
                                       class="btn sbold btn-default btnRest">{{__('cp.reset')}}
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div
                    class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between"></div>
                <table class="table table-borderless table-vertical-center">
                    <thead>
                    <tr>
                        <th class="p-0" style="min-width: 70px">{{__('cp.order_id')}}</th>
                        <th class="p-0" style="min-width: 130px">{{__('cp.total')}} / {{__('cp.KD')}}</th>
                        <th class="p-0" style="min-width: 130px">{{__('cp.delivery_cost')}} / {{__('cp.KD')}} </th>
                        <th class="p-0" style="min-width: 100px">{{__('cp.ReqStatus')}}</th>
                        <th class="p-0" style="min-width: 90px">{{__('cp.order_date')}}</th>
                        <th class="p-0" style="min-width: 80px">{{__('cp.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $one)
                        <tr>
                            <td class="pl-0">
                                <a href="#"
                                   class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"></a>
                                <div>
                                    <span class="font-weight-bolder">{{@$one->id}}</span>
                                </div>
                            </td>
                            <td class="text-right">
                                <span
                                    class="text-dark-75 font-weight-bolder d-block font-size-lg">{{number_format(@$one->total,3)}}</span>
                            </td>
                            <td class="text-right">
                                <span
                                    class="text-dark-75 font-weight-bolder d-block font-size-lg">{{number_format(@$one->delivery_fees,3)}}</span>
                            </td>

                            <td class="text-right">
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
                                            $cls = 'primary';
                                            break;
                                        default:
                                            $cls = 'secondary';
                                            break;
                                    }
                                    ?>
                                <span class="label label-lg	label-light-{{$cls}} label-inline"> {{$one->status_name}}</span>
                            </td>
                            <td class="text-right"> {{@$one->created_at->format('d/m/y')}}
                                | {{@$one->created_at->format('h:m A')}} </td>
                            <td class="text-right">
                                <a href="{{url(getLocal().'/admin/users/'.$item->id.'/showOrder/'.$one->id)}}"
                                   title="{{__('cp.show')}}" class="btn btn-icon  btn-hover-primary btn-sm mx-3">
                                    <i class="la la-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$orders->appends($_GET)->links("pagination::bootstrap-4") }}
            </div>
            <!--end::Table-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Advance Table Widget 7-->
    </div>
    <!--end::Entry-->
    </div>
@endsection
