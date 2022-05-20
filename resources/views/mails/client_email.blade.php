<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<style>
    /* Base */

    body,
    body *:not(html):not(style):not(br):not(tr):not(code) {
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif,
        'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
        position: relative;
    }

    body {
        -webkit-text-size-adjust: none;
        background-color: #ffffff;
        color: #718096;
        height: 100%;
        line-height: 1.4;
        margin: 0;
        padding: 0;
        width: 100% !important;
    }

    p,
    ul,
    ol,
    blockquote {
        line-height: 1.4;
        text-align: left;
    }

    a {
        color: #3869d4;
    }

    a img {
        border: none;
    }

    /* Typography */

    h1 {
        color: #3d4852;
        font-size: 18px;
        font-weight: bold;
        margin-top: 0;
        text-align: left;
    }

    h2 {
        font-size: 16px;
        font-weight: bold;
        margin-top: 0;
        text-align: left;
    }

    h3 {
        font-size: 14px;
        font-weight: bold;
        margin-top: 0;
        text-align: left;
    }

    p {
        font-size: 16px;
        line-height: 1.5em;
        margin-top: 0;
        text-align: left;
    }

    p.sub {
        font-size: 12px;
    }

    img {
        max-width: 100%;
    }

    /* Layout */

    .wrapper {
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 100%;
        background-color: #edf2f7;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .content {
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 100%;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    /* Header */

    .header {
        padding: 25px 0;
        text-align: center;
    }

    .header a {
        color: #3d4852;
        font-size: 19px;
        font-weight: bold;
        text-decoration: none;
    }

    /* Logo */

    .logo {
        height: 75px;
        max-height: 75px;
        width: 75px;
    }

    /* Body */

    .body {
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 100%;
        background-color: #edf2f7;
        border-bottom: 1px solid #edf2f7;
        border-top: 1px solid #edf2f7;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .inner-body {
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 570px;
        background-color: #ffffff;
        border-color: #e8e5ef;
        border-radius: 2px;
        border-width: 1px;
        box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015);
        margin: 0 auto;
        padding: 0;
        width: 570px;
    }

    /* Subcopy */

    .subcopy {
        border-top: 1px solid #e8e5ef;
        margin-top: 25px;
        padding-top: 25px;
    }

    .subcopy p {
        font-size: 14px;
    }

    /* Footer */

    .footer {
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 570px;
        margin: 0 auto;
        padding: 0;
        text-align: center;
        width: 570px;
    }

    .footer p {
        color: #b0adc5;
        font-size: 12px;
        text-align: center;
    }

    .footer a {
        color: #b0adc5;
        text-decoration: underline;
    }

    /* Tables */

    .table table {
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 100%;
        margin: 30px auto;
        width: 100%;
    }

    .table th {
        border-bottom: 1px solid #edeff2;
        margin: 0;
        padding-bottom: 8px;
    }

    .table td {
        color: #74787e;
        font-size: 15px;
        line-height: 18px;
        margin: 0;
        padding: 10px 0;
    }

    .content-cell {
        max-width: 100vw;
        padding: 32px;
    }

    /* Buttons */

    .action {
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 100%;
        margin: 30px auto;
        padding: 0;
        text-align: center;
        width: 100%;
    }

    .button {
        -webkit-text-size-adjust: none;
        border-radius: 4px;
        color: #fff;
        display: inline-block;
        overflow: hidden;
        text-decoration: none;
    }

    .button-blue,
    .button-primary {
        background-color: #2d3748;
        border-bottom: 8px solid #2d3748;
        border-left: 18px solid #2d3748;
        border-right: 18px solid #2d3748;
        border-top: 8px solid #2d3748;
    }

    .button-green,
    .button-success {
        background-color: #48bb78;
        border-bottom: 8px solid #48bb78;
        border-left: 18px solid #48bb78;
        border-right: 18px solid #48bb78;
        border-top: 8px solid #48bb78;
    }

    .button-red,
    .button-error {
        background-color: #e53e3e;
        border-bottom: 8px solid #e53e3e;
        border-left: 18px solid #e53e3e;
        border-right: 18px solid #e53e3e;
        border-top: 8px solid #e53e3e;
    }

    /* Panels */

    .panel {
        border-left: #2d3748 solid 4px;
        margin: 21px 0;
    }

    .panel-content {
        background-color: #edf2f7;
        color: #718096;
        padding: 16px;
    }

    .panel-content p {
        color: #718096;
    }

    .panel-item {
        padding: 0;
    }

    .panel-item p:last-of-type {
        margin-bottom: 0;
        padding-bottom: 0;
    }

    /* Utilities */

    .break-all {
        word-break: break-all;
    }
</style>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="header">
                        <a href="#">
                            {{ config('app.name') }}
                        </a>
                    </td>
                </tr>

                <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                            <!-- Body content -->
                            <tr>
                                <td class="content-cell">
                                    <h1>@lang('email.The following order was made by') {{ $client->full_name }} @lang('email.from') {{$settings->name}} - @lang('email.Order')  #{{$order->getIDWithYear()}}</h1>
                                    <p>@lang('email.The following order was made by') {{$client->full_name}} on {{\Carbon\Carbon::now()->format('m.d.Y')}}</p>
                                    <p>@lang('email.Order ID'): {{$order->getIDWithYear()}} </p>
                                    <p>@lang('email.Order date'): {{\Carbon\Carbon::parse($order->created_at)->format('m.d.Y')}}</p>
                                    <p>@lang('email.Payment By'): Paypal</p>
                                    <hr/>
                                    <p>@lang('email.Order Summary'):</p>
                                    <hr/>
                                    <p>@lang('email.Total Items'): {{count($order->order_items)}}</p>
                                    @foreach($order->order_items as $order_item)
                                        <p>
                                            {{
                                                $order_item->product->name . ' (' . $order_item->quantity . 'x) ' . '$' .
                                                number_format($order_item->getPrice() / $order_item->quantity, 2)
                                            }}
                                        </p>
                                    @endforeach
                                    <br>
                                    <p>@lang('email.Online Order Summary:') <a href="{{config('app.url').'/my-orders'}}">{{config('app.url').'/my-orders'}}</a></p>
                                    <br>
                                    <p>@lang('email.Total'): {{$order->getPrice()}}$</p>
                                    <p>@lang('email.Shipping'): {{$order->shipping}}$</p>
                                    <p>@lang('email.Grand Total'): {{$order->getPriceWithShipping()}}$</p>
                                    <hr/>
                                    <p>@lang("email.Buyer's Details"):</p>
                                    <hr/>
                                    <p>@lang('email.Full Name'): {{$client->full_name}}</p>
                                    <p>@lang('email.E-Mail'): {{$client->email}}</p>
                                    <br>
                                    <p>@lang('email.Address'):</p>
                                    <p>{{$client->full_name}}</p>
                                    <p>{{$client->address}}</p>
                                    <hr/>
                                    <p>@lang('email.Seller Information:')</p>
                                    <hr/>
                                    <p>@lang('email.Store Name'): {{$settings->name}}</p>
                                    <br/>
                                    <p>@lang('email.Site URL:') <a href="{{config('app.url')}}">{{config('app.url')}}</a></p>
                                    <p>@lang('email.E-Mail'): {{$settings->email}}</p>
                                    <p>@lang('email.Address'): Genesis Bricks
                                        500-34 Eglinton Avenue W, Toronto, Ontario, M4R 2H6, Canada
                                    </p>
                                    <hr/>
                                    <p>@lang('email.Note: To view the status of your orders, and review your purchase please go to:') <a href="{{config('app.url') . '/my-orders'}}">{{config('app.url') . '/my-orders'}}</a></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td class="content-cell" align="center">
                                    <p>Genesis Bricks
                                        7F, MW Tower, 111 Bonham Strand, Sheung Wan, Hong Kong</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>

