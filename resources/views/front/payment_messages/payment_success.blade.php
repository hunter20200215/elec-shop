@extends('front.layout')
@section('custom_css')
    <style>
        .steps{
            width: 50%;
        }
        .step-count{
            width: 25%
        }
        .step-text{
            width: 75%;
        }
        @media(max-width: 768px){
            .steps{
                width: 100%;
            }
            .step-count{
                width: 40%
            }
            .step-text{
                width: 60%;
            }
        }
    </style>
@endsection
@section('content')
    <div class="row cart-container" style="font-family: Mulish-Light, fantasy">
        <nav class="breadcrumb-wrapper" style="width: 100%; padding-left: 7%; margin-left: 0;" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('front.Return to store')</a></li>
            </ol>
        </nav>
        <h1 style="text-align: center; font-family: Mulish-Bold, fantasy">
            @lang('front.Thank You') {{Auth::user()->full_name}}
        </h1>
        <div class="steps" style="text-align: center; font-size: 17pt; font-weight: bold;">@lang('front.Your payment has been successful and an order has been made. You
            will receive an email with order details.')</div>
        <div style="display: flex; flex-direction: row; justify-content: center; flex-wrap: wrap;">
            <div style="width: 51%; margin-bottom:20px">
                <h3 style="font-family: Mulish-Bold,fantasy">@lang('front.What to Expect:')</h3>
            </div>
            <div class="steps">
                <div style="display: flex; justify-content: space-around;margin-bottom: 20px">
                    <div  class="step-count">@lang('front.Step') 1:</div>
                    <div class="step-text">
                        @lang('You have made your order. In a few moments you will receive an order
                        summary email ')(@lang('front.from '){{$settings->email}}). @lang('You can view the status of
                        your order') <a href="{{route('my_orders')}}" style="color:darkblue; font-weight: bold">@lang('here.')</a> @lang('It typically takes 2 business days to receive and pack your')
                    </div>
                </div>
                <div style="display: flex; justify-content: space-around;margin-bottom: 20px">
                    <div  class="step-count">@lang('front.Step') 2:</div>
                    <div class="step-text">
                        @lang('Once your order has shipped, you will receive an email letting you know, along
                with the tracking code. This tracking code will also be added to PayPal to
                protect both you and us.')
                    </div>
                </div>
                <div style="display: flex; justify-content: space-around;">
                    <div class="step-count">@lang('front.Step') 3:</div>
                    <div class="step-text">
                        @lang('Receive your order! This is the final step! Please let us know how we did!')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
@endsection
