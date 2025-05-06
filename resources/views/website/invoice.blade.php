<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>{{$setting->title}} | @lang('cp.invoice')</title>
    <link rel="icon" href="{{asset('website_assets/images/favicon.svg')}}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Cairo', sans-serif;
            background: #eee
        }

        p,
        span,
        strong,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
            padding: 0;
            line-height: 1.6
        }

        .wrapper {
            background: #F5F1EC;
            padding: 15px;
            width: 800px;
            margin: auto;
        }

        .main-table {
            background: #F5F1EC;
            color: #231F20;
            border-radius: 10px;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border-spacing: 0;
            font-family: 'Cairo', sans-serif;
        }

        .table-product th,
        .table-product td {
            width: 20%;
        }

        .table-product th:first-child,
        .table-product td:first-child {
            width: 40%
        }

        .table-product tbody td {
            padding: 15px 0;
        }

        .table-product th,
        .table-product td {
            color: #2A2B2C
        }

        .d--p h6,
        .d--p p {
            display: inline-block;
        }

        .d--p h6 {
            font-size: 15px;
            color: #000;
        }

        .d--p p {
            font-size: 14px;
            margin: 0 5px;
        }

        .to--pro {
            margin-bottom: 10px;
        }
        .to--pro:last-child {
            margin-bottom: 0;
        }

        .to--pro p,
        .to--pro strong {
            display: inline-block;
            width: 49%;
            font-weight: 600;
            font-size: 14px;
            color: #707070;
        }

        .to--pro p:last-child,
        .to--pro strong:last-child {
            text-align: end
        }

        .to--pro strong {
            color: #452C44;
            font-size: 14px;
            font-weight: 700;
        }

        .de-add p:last-child {
            margin-bottom: 15px;
        }

        .icon-instagram {
            background: url('{{ asset('website_assets/images/instagram.png') }}');
            background-size: 100% 100% !important;
            width: 18px;
            height: 18px;
            display: block;
        }

        .order-summry > h5 {
            color: #452C44;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .item-summary {
            position: relative;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .item-summary figure {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: #452C44;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 5px 0 0;
            font-size: 13px;
        }
        .txt-summ {
            width: calc(100% - 120px);
        }
        .txt-summ h6 {
            color: #452C44;
            font-size: 13px;
        }

        .txt-summ span {
            color: #707070;
            display: block;
            font-size: 15px;
        }

        .price-order {
            width: 100px;
            text-align: end;
        }

        .price-order strong {
            font-weight: 600;
            color: #C2A88A;
        }

    </style>

</head>

<body>
<center class="wrapper">
    <table class="main-table" width="100%" style="">
        <tr>
            <td style="text-align: center;padding:0 10px;">
                <table width="100%">
                    <tr>
                        <td style="border-radius: 15px;text-align: center;padding:50px 20px 20px;">
                            <a href=""><img src="{{asset('website_assets/images/logo.png')}}" alt="" title="Logo" width="100x" /></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!--Logo-->
    </table>

    <table class="main-table" width="100%" style="background: #fff">
        <tr>
            <td style="padding:30px 10px;">
                <table width="100%">
                    <tbody><tr>
                        <td style="">
                            <h4 style="color:#452C44;font-size:26px;margin-bottom:5px;font-weight:600">@lang('cp.Your Order Invoice') - ZOY{{@$order->id}}</h4>
                            <p style="color:#452C44;font-size:18px;display:block;font-weight:500;margin-bottom:10px">@lang('cp.Dear') {{@$order->user->name ?? @$order->name}}</p>
                            <p style="color:#452C44;font-size:14px;display:block;">{{@$emailText->subject}}
                                <br /> {!! @$emailText->content !!}</p>
                        </td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>

        <tr>
            <td style="padding:0 10px;">
                <table width="100%">
                    <tbody><tr>
                        <td style="">
                            <h6 style="color:#452C44;font-size:14px;margin-bottom:5px;font-weight:600">@lang('cp.Billed to')</h6>
                            <p style="color:#452C44;font-size:12px;display:block;">{{@$order->user->name ?? @$order->name}}</p>
                            <p style="color:#452C44;font-size:12px;display:block;">{{@$order->user->email ?? @$order->email}}</p>
                            <p style="color:#452C44;font-size:12px;display:block;">{{@$order->user->mobile ?? @$order->mobile}}</p>
                            <p style="color:#452C44;font-size:12px;display:block;">{{@$order->address->title ?? @$order->address->title . ' , '}}  {{@$order->address->country->name ?? @$order->country->name}}
                                , {{@$order->address->city->name ?? @$order->city->name}}
                                , {{@$order->address->address_line_one ?? @$order->address_line_one}} {{ @$order->address->address_line_two ? ' , '.$order->address->address_line_two :  ' , '.$order->address_line_two}} {{@$order->address->extra_directions ? ' , '.$order->address->extra_directions : ' , '.$order->extra_directions}} {{@$order->address->postal_code ? ' , '.$order->address->postal_code : ' , '.$order->postal_code}}</p>
                        </td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>

        <tr>
            <td style="padding: 15px;">
                <table width="100%">
                    <tr>
                        <td style="background:#fff;border:1px solid #E5E5E5;padding:25px;display:flex;justify-content:space-between;">
                            <div style="display: inline-block;">
                                <p style="color:#452C44;font-size:12px;margin-bottom:5px">@lang('website.Order Id')</p>
                                <strong style="color:#452C44;display:block;font-size:14px;font-weight:600">ZOY{{@$order->id}}</strong>
                            </div>
                            <div style="display: inline-block;">
                                <p style="color:#452C44;font-size:12px;margin-bottom:5px">@lang('website.No_of_Products')</p>
                                <strong style="color:#452C44;display:block;font-size:14px;font-weight:600">{{@$order->count_products}}</strong>
                            </div>
                            <div style="display: inline-block;">
                                <p style="color:#452C44;font-size:12px;margin-bottom:5px">@lang('website.Order Date & time')</p>
                                <strong style="color:#452C44;display:block;font-size:14px;font-weight:600">{{@$order->created_at->format('d/m/y')}}
                                    | {{@$order->created_at->format('h:m A')}}</strong>
                            </div>
                            <div style="display: inline-block;">
                                <p style="color:#452C44;font-size:12px;margin-bottom:5px">@lang('website.Amount')</p>
                                <strong style="color:#452C44;display:block;font-size:14px;font-weight:600">{{number_format(@$order->total ?? 0 ,3)}} @lang('website.KWD')</strong>
                            </div>
                            <div style="display: inline-block;">
                                <p style="color:#452C44;font-size:12px;margin-bottom:5px">@lang('website.status')</p>
                                <strong style="color:#452C44;display:block;font-size:14px;font-weight:600">{{@$order->status_name}}</strong>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!--ph invoice-->

        <tr>
            <td style="padding-bottom: 10px;">
                <table width="100%">
                    <tr style="vertical-align: top;">
                        <td style="width: 60%;padding:0 10px">
                            <table class="colom" style="width:100%;background:#fff;border:1px solid #E5E5E5;padding:25px;height:330px;">
                                <tr>
                                    <td>
                                        <div class="order-summry">
                                            <h5>@lang('website.Order Summary')</h5>
                                            @foreach($order->products as $oneProduct)
                                                <div class="item-summary">
                                                    <figure>{{@$oneProduct->quantity}}X</figure>
                                                    <div class="txt-summ">
                                                        <h6>{{@$oneProduct->product->name}}</h6>
                                                        @if(@$oneProduct->size_id != '')
                                                            <span>@lang('website.Size') : {{@$oneProduct->size->name}}</span>
                                                        @endif
                                                        @if(@$oneProduct->color_id != '')
                                                            <span>@lang('website.Color') : {{@$oneProduct->color->name}}</span>
                                                        @endif
                                                    </div>
                                                    <div class="price-order">
                                                        <strong>{{number_format(@$oneProduct->price_offer && ($oneProduct->price_offer > 0) ? @$oneProduct->price_offer : @$oneProduct->price ,3)}}  @lang('website.KWD')</strong>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 40%;padding: 0 10px">
                            <table class="colom" style="width:100%;background:#fff;border:1px solid #E5E5E5;padding:25px;height:330px;">
                                <tr width="100%">
                                    <td width="100%">
                                        <div class="to--pro">
                                            <p>@lang('website.Payment Method')</p>
                                            <p>{{@$order->payment_name}}</p>
                                        </div>
                                        <div class="to--pro">
                                            <p>@lang('website.Transaction ID')</p>
                                            <p>{{@$order->transaction_id ?? '--'}}</p>
                                        </div>
                                        <div class="to--pro">
                                            <p>@lang('website.Invoice Reference')</p>
                                            <p>{{@$order->InvoiceReference ?? '--'}} </p>
                                        </div>
                                        <div class="to--pro">
                                            <p>@lang('website.subtotal')</p>
                                            <p>{{number_format(@$order->sub_total ,3)}}  @lang('website.KWD')</p>
                                        </div>
                                        <div class="to--pro">
                                            <p>@lang('website.Discount')</p>
                                            <p>{{number_format(@$order->discount ?? 0 ,3)}}  @lang('website.KWD')</p>
                                        </div>
                                        <div class="to--pro">
                                            <p>@lang('website.Delivery fees')</p>
                                            <p>{{number_format(@$order->delivery_fees ?? 0 ,3)}}  @lang('website.KWD')</p>
                                        </div>
                                        <div class="to--pro"><strong>@lang('website.total')</strong><strong>{{number_format(@$order->total ?? 0 ,3)}}  @lang('website.KWD')</strong></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <!--ph-->

        <tr>
            <td style="padding-bottom: 50px;">
                <table width="100%">
                    <tr>
                        <td style="padding:0 10px">
                            <p style="color:#452C44;font-size:15px;margin-bottom:5px">@lang('website.We will notify you once your order has shipped. Thank you for shopping with us!')</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="main-table" width="100%" style="">
        <tr>
            <td style="text-align:center;padding-top:15px">
                <table width="100%">
                    <tr>
                        <td style="text-align: center;">
                            <p style="font-size: 14px;font-weight: 500;color: #171717">
                                <a target="_blank" href="{{@$setting->instagram}}"
                                   style="background:#fff;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;"><i
                                        class="icon-instagram"></i></a>
                            </p>
                            <p style="font-size: 14px;font-weight: 500;margin: 10px 0;color:#7E7E7E">@lang('website.Copyright')
                                © {{date('Y')}} {{$setting->title}}
                                - @lang('website.allRightsReserved')</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!--footer-->
    </table>
</center>
</body>

</html>
