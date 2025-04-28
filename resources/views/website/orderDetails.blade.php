@extends('layout.websiteLayout')
@section('title')
    @lang('website.OrderDetails')
@endsection
@section('content')

    <section class="section_account_page">
        <div class="container">
            <div class="order-dtl wow fadeInUp">
                <div>
                    <p>@lang('website.Order Id')</p>
                    <h6>ZOY{{@$order->id}}</h6>
                </div>
                <div>
                    <p>@lang('website.No_of_Products')</p>
                    <h6>{{@$order->count_products}}</h6>
                </div>
                <div>
                    <p>@lang('website.Order Date & time')</p>
                    <h6>{{@$order->created_at->format('d/m/y')}} | {{@$order->created_at->format('h:m A')}}</h6>
                </div>
                <div>
                    <p>@lang('website.Amount')</p>
                    <h6>{{number_format(@$order->total ?? 0 ,3)}} @lang('website.KWD')</h6>
                </div>
                <div>
                    <p>@lang('website.Order Status')</p>
                    <h6>{{@$order->status_name}}</h6>
                </div>
            </div>
            <div class="dta-buyer wow fadeInUp">
                @if($order->user_id != '')
                    <span>{{@$order->user->name}}</span>
                    <p>{{@$order->user->email}}, +{{@$order->user->mobile}}</p>
                    <p>{{@$order->address->country->name}}  , {{@$order->address->city->name}}
                        , {{@$order->address->address_line_one}} {{@$order->address->address_line_two ? ' , '.$order->address->address_line_two : ''}} {{@$order->address->extra_directions ? ' , '.$order->address->extra_directions : ''}} {{@$order->address->postal_code ? ' , '.$order->address->postal_code : ''}}
                        .</p>
                @else
                    <span>{{@$order->name}}</span>
                    <p>{{@$order->email}}, +{{@$order->mobile}}</p>
                    <p>{{@$order->country->name}} , {{@$order->city->name}}
                        , {{@$order->address_line_one}} {{@$order->address_line_two ? ' , '.@$order->address_line_two : ''}} {{@$order->extra_directions ? ' , '.@$order->extra_directions : ''}} {{@$order->postal_code ? ' , '.@$order->address->postal_code : ''}}
                        .</p>
                @endif

            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="order-summry wow fadeInUp">
                        <h5>@lang('website.Order Summary')</h5>
                        @foreach($order->products as $oneProduct)
                            <div class="item-summary">
                                <figure><img src="{{@$oneProduct->product->image}}"
                                             alt="{{@$oneProduct->product->name}}"></figure>
                                <div class="txt-summ">
                                    <h6>{{@$oneProduct->product->name}}</h6>
                                    @if(@$oneProduct->size_id != '')
                                        <span>@lang('website.Size') : {{@$oneProduct->size->name}}</span>
                                    @endif
                                    @if(@$oneProduct->color_id != '')
                                        <span>@lang('website.Color') : {{@$oneProduct->color->name}}</span>
                                    @endif
                                    <span>@lang('website.Qty') : {{@$oneProduct->quantity}}</span>
                                </div>
                                <div class="price-order">
                                    <strong>{{number_format(@$oneProduct->price_offer && ($oneProduct->price_offer > 0) ? @$oneProduct->price_offer : @$oneProduct->price ,3)}}  @lang('website.KWD')</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="pay-details wow fadeInUp">
                        <h5>@lang('website.Payment Details')</h5>
                        <div><p>@lang('website.Payment Method')</p><span>{{@$order->payment_name}}</span></div>
                        <div><p>@lang('website.Transaction ID')</p><span>{{@$order->transaction_id ?? '--'}}</span></div>
                        <div><p>@lang('website.Invoice Reference')</p><span>{{@$order->InvoiceReference ?? '--'}}</span></div>
                        <div><p>@lang('website.subtotal')</p><span>{{number_format(@$order->sub_total ,3)}}  @lang('website.KWD')</span></div>
                        <div><p>@lang('website.Discount')</p><span>{{number_format(@$order->discount ?? 0 ,3)}}  @lang('website.KWD')</span></div>
                        <div><p>@lang('website.Delivery fees')</p><span>{{number_format(@$order->delivery_fees ?? 0 ,3)}}  @lang('website.KWD')</span></div>
                        <div class="d-total"><p>@lang('website.total')</p><span>{{number_format(@$order->total ?? 0 ,3)}}  @lang('website.KWD')</span></div>
                        <ul>
                            @if(auth('web')->check())
                                <li><a href="{{route('orders')}}"
                                       class="btn-site btn-order"><span>@lang('website.My Orders')</span></a></li>
                            @endif
                            <li><a href="{{route('home')}}" class="btn-site"><span>@lang('website.Back to Home')</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--section_account_page-->
@endsection
