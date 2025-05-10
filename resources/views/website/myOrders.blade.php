@extends('website.myAccountLayout')
@section('contentMyAccount')
<div class="col-lg-9 @if(count($orders) == 0) d-none @endif">
    <div class="cont-orders wow fadeInUp">
        @foreach($orders as $order)
            <div class="item-order">
                <div class="dta-order">
                    <p>@lang('website.Order Id')</p>
                    <span>ZOY{{ @$order->id}}</span>
                </div>
                <div class="dta-order">
                    <p>@lang('website.No_of_Products')</p>
                    <span>{{@$order->count_products}}</span>
                </div>
                <div class="dta-order">
                    <p>@lang('website.Order Date & time')</p>
                    <span>{{@$order->created_at->format('d/m/y')}} | {{@$order->created_at->format('h:m A')}}</span>
                </div>
                <div class="dta-order">
                    <p>@lang('website.Amount')</p>
                    <span>{{number_format(@$order->total ?? 0 ,3)}} @lang('website.KWD')</span>
                </div>
                <div class="dta-order">
                    <p>@lang('website.Order Status')</p>
                    <span>{{@$order->status_name}}</span>
                </div>
                <div class="dta-order">
                    <a href="{{route('orderDetails' ,@$order->id)}}" class="btn-site"><span>@lang('website.View')</span></a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="col-lg-9 @if(count($orders) > 0) d-none @endif">
    <div class="cont-orders wow fadeInUp">
        <div class="cont-empty">
            <figure><i class="icon-no-product"></i></figure>
            <h5>@lang('website.No Orders')</h5>
            <p>@lang('website.Your order history is empty') .<br />@lang('website.Start shopping to track purchases') .</p>
        </div>
    </div>
</div>
@endsection
