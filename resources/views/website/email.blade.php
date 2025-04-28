<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{(app()->getLocale() == 'ar') ? 'rtl' : 'ltr'}}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>{{$setting->title .' '}} | {{$item->subject}}</title>
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
                        <td style="border-radius: 15px;text-align: center;padding:50px 20px 0;">
                            <a href=""><img src="{{asset('website_assets/images/logo.png')}}" alt="" title="Logo" width="100x"/></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!--Logo-->

        <tr>
            <td style="padding:0 10px;">
                <table width="100%">
                    <tbody>
                    <tr>
                        <td style="">
                            <div>{!! $item->content !!}</div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>


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
                            </p>
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
