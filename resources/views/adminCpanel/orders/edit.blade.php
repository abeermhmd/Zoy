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
                        <h3>{{__('cp.orders')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/orders/')}}"
                       class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
                    <button id="submitButton" class="btn btn-success ">{{__('cp.edit')}}</button>
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
                    <form method="post" action="{{url(getLocal().'/admin/orders/'.$order->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.order-details')}} / {{$order->id}}</h3>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group"><label>{{__('cp.changeStatus')}}</label>
                                    <select id="status" class="form-control select2" name="status">
                                        //// 0->Placed , 1->On the Way , 2->Delivered , 3->Canceled
                                        <option value="">{{__('cp.select')}}</option>
                                        <option value="0">{{__('website.placed')}}</option>
                                        <option value="1">{{__('website.onWay')}}</option>
                                        <option value="2">{{__('website.delivered')}}</option>
                                        <option value="3">{{__('website.cancelled')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.customer')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           value="{{@$order->user->name ?? @$order->name}}" disabled/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.email')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           value="{{@$order->user->email ?? @$order->email}}" disabled/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.mobile')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           value="{{@$order->user->mobile ?? @$order->mobile}}" disabled/>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.country')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           value="{{@$order->address->country->name ?? @$order->country->name}}"
                                           disabled/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.city')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           @if(@$order->address_id != '')
                                               value="{{@$order->address->city_id  ?? @$order->address->city_name}}"
                                           @else
                                               value="{{@$order->city_id  ?? @$order->city_name}}"
                                           @endif disabled/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('website.address_line_one')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           value="{{@$order->address_line_one ?? @$order->address->address_line_one}}"
                                           disabled/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('website.address_line_two')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           value="{{@$order->address_line_two ?? @$order->address->address_line_two}}"
                                           disabled/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('website.Postal Code')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           value="{{@$order->postal_code ?? @$order->address->postal_code}}"
                                           disabled/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('website.Extra Directions')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           value="{{@$order->extra_directions ?? @$order->address->extra_directions}}"
                                           disabled/>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.total')}} / {{__('cp.KD')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           value="{{@$order->total}}" disabled/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.sub_total')}} / {{__('cp.KD')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           value="{{@$order->sub_total}}" disabled/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.delivery_cost')}} / {{__('cp.KD')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           value="{{@$order->delivery_fees}}" disabled/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.payment_method')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           value="{{@$order->payment_name}}" disabled/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.payment_status')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                           @if(@$order->payment_status == '0') value="{{__('cp.not_paid')}}"
                                           @else  value="{{__('cp.paid')}}" @endif disabled/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.status')}}</label>
                                    <input type="text" class="form-control form-control-solid" name="status"
                                           value="{{@$order->status_name}}" disabled required/>
                                </div>
                            </div>
{{--                            @if($order->status == 4)--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label>{{__('cp.refund_id')}}</label>--}}
{{--                                        <input type="text" class="form-control form-control-solid" name="refund_id"--}}
{{--                                               value="{{@$order->refund_id}}" disabled required/>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
                            <!--begin::Advance Table: Widget 7-->
                            <div class="card card-custom gutter-b">
                                <!--begin::Header-->
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span
                                            class="card-label font-weight-bolder text-dark">{{__('cp.products')}}</span>

                                    </h3>

                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body py-2">
                                    <!--begin::Table-->
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-vertical-center">
                                            <thead>
                                            <tr>
                                                <th class="p-0" style="min-width: 150px"></th>
                                                <th class="p-0" style="min-width: 120px">{{__('cp.name')}}</th>
                                                <th class="p-0" style="min-width: 150px">{{__('cp.color')}} </th>
                                                <th class="p-0" style="min-width: 150px">{{__('cp.size')}}</th>
                                                <th class="p-0" style="min-width: 120px">{{__('cp.quantity')}}</th>
                                                <th class="p-0" style="min-width: 120px">{{__('cp.price')}} / {{__('cp.KD')}}</th>
                                                <th class="p-0" style="min-width: 120px">{{__('cp.offer_price')}} / {{__('cp.KD')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->products as $one)
                                                <tr>
                                                    <td class="p-0 py-4">
                                                        <div class="symbol symbol-50 symbol-light">
                            <span class="symbol-label">
                                <img src="{{@$one->product->image}}" class="h-50 align-self-center" alt=""/>
                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <span
                                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{@$one->product->name}}</span>
                                                    </td>
                                                    <td class="text-right">
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                            @if($one->color_id != null)
                                {{ $one->color->name ?? '--' }}
                            @else
                                --
                            @endif
                        </span>
                                                    </td>
                                                    <td class="text-right">
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                            @if($one->size_id != null)
                                {{ $one->size->name  ?? '--' }}
                            @else
                                --
                            @endif
                        </span>
                                                    </td>
                                                    <td class="text-right">
                                                        <span
                                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{@$one->quantity}}</span>
                                                    </td>
                                                    <td class="text-right">
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                            {{number_format(@$one->price,3)}}
                        </span>
                                                    </td>
                                                    <td class="text-right">
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                            @if($one->price_offer != null )
                                {{number_format(@$one->price_offer,3)}}
                            @else
                                --
                            @endif
                        </span>
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>

                                <!--end::Body-->
                            </div>
                            <!--end::Advance Table Widget 7-->

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
    <script>
        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });
        $(document).on('click', '#submitButton', function () {
            // $('#submitButton').addClass('spinner spinner-white spinner-left');
            $('#submitForm').click();
        });
    </script>
@endsection

@section('script')

@endsection

